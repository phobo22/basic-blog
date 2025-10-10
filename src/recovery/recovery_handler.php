<?php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../helper/functions.php";
require_once __DIR__ . "/../../services/email/send_recovery_email.php";

// if user click the reset password link with token
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    header("Content-Type: application/json");
    $response = [
        "success" => false,
        "msg" => ""
    ];

    // check if token is not exist or invalid token
    $token = $_GET["token"] ?? '';
    if (!$token || !ctype_xdigit($token)) {
        $response["msg"] = "Invalid or expired link";
        echo json_encode($response);
        exit;
    }

    try {
        $pdo = dbConnect();

        // check if token exists in database
        $tokenHash = hash('sha256', $token);
        $query = $pdo->prepare("select id from password_reset
                                where token_hash = :tokenHash and used = 0 and expires_at >= NOW()
                                limit 1;");
        $query->execute([":tokenHash" => $tokenHash,]);
        $reset = $query->fetchAll(PDO::FETCH_ASSOC);

        if (count($reset) === 0) {
            $response["msg"] = "Invalid or expired link";
            echo json_encode($response);
            exit;
        } else {
            $response["success"] = true;
            echo json_encode($response);
            exit;
        }
    } catch (Exception $error) {
        $response["msg"] = "Error when checking token";
        echo json_encode($response);
        exit;
    }
}

// if user click forgot password
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // if user submit email to receive reset link
    if ($_POST["form"] === "send") {    
        $email = $_POST["email"];
        header("Content-Type: text/plain");
        
        if (empty($email)) {
            echo "Please enter your email address";
            exit;
        }

        try {
            $pdo = dbConnect();
            $users = getUserWithEmail($pdo, $email);

            if (count($users) === 0) {
                echo "Email has not been registerd yet";
                exit;
            } else {
                $user = $users[0];
                $token = createToken($pdo, $user["id"]);
                sendRecoveryEmail($user["email"], $user["username"], $token);
                echo "Check your mail for reset link";
                exit;
            }
        } catch (Exception $error) {
            echo "{$error->getMessage()}";
            exit;
        }
    }

    // if user send new password
    elseif ($_POST["form"] === "recover") {
        $newPwd = $_POST["new-password"];
        $rePwd = $_POST["re-password"];
        $token = $_POST["token"];

        header("Content-Type: application/json");
        $response = [
            "success" => false,
            "msg" => "" 
        ];

        if (empty($newPwd) || empty($rePwd)) {
            $response["msg"] = "Please fill in all blanks";
            echo json_encode($response);
            exit;
        }

        if ($newPwd !== $rePwd) {
            $response["msg"] = "Password does not match";
            echo json_encode($response);
            exit;
        }

        if (!isStrongPassword($newPwd)) {
            $response["msg"] = "Password is not strong enough";
            echo json_encode($response);
            exit;
        }

        try {
            $pdo = dbConnect();
            $newHashedPwd = password_hash($newPwd, PASSWORD_BCRYPT);
            $hashToken = hash("sha256", $token);

            // update new password
            $changePwdQuery = $pdo->prepare("update users u
                                            join password_reset pr on u.id = pr.user_id
                                            set u.pwd = :newPwd
                                            where pr.token_hash = :hashToken;"
            );
            
            $changePwdQuery->execute([
                ":newPwd" => $newHashedPwd,
                ":hashToken" => $hashToken,
            ]);

            //delete reset link from database
            $deleteTokenQuery = $pdo->prepare("delete from password_reset where token_hash = :hashToken;");
            $deleteTokenQuery->execute([":hashToken" => $hashToken,]);

            $response["success"] = true;
            $response["msg"] = "Password changed successfully";
            echo json_encode($response);
            exit;
        } catch (Exception $error) {
            $response["msg"] = "Error when recovering password: {$error->getMessage()}";
            echo json_encode($response);
            exit;
        }
    }
}

?>