<?php

session_start();

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../helper/functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $oldpwd = $_POST["old-pwd"];
    $newpwd = $_POST["new-pwd"];

    header("Content-Type: application/json");
    $response = [
        "success" => false,
        "msg" => ""
    ];

    if (empty($oldpwd) || empty($newpwd)) {
        $response["msg"] = "Please fill in all blanks";
        echo json_encode($response);
        exit;
    }

    if (!isStrongPassword($newpwd)) {
        $response["msg"] = "New password is not strong enough";
        echo json_encode($response);
        exit;
    }

    try {
        $pdo = dbConnect();

        $checkPwdQuery = $pdo->prepare("select pwd from users where id = :userid");
        $checkPwdQuery->execute([":userid" => $_SESSION["userid"],]);
        $oldHashedPwd = $checkPwdQuery->fetch(PDO::FETCH_ASSOC)["pwd"];

        if (password_verify($oldpwd, $oldHashedPwd)) {
            $newHashedPwd = password_hash($newpwd, PASSWORD_BCRYPT);
            $updateQuery = $pdo->prepare("update users set pwd = :newHashedPwd where id = :userid");
            $updateQuery->execute([":newHashedPwd" => $newHashedPwd, ":userid" => $_SESSION["userid"],]);

            $response["success"] = true;
            $response["msg"] = "Password changed";
            echo json_encode($response);
            exit;
        }
    
        $response["msg"] = "Old password is incorrect";
        echo json_encode($response);
        exit;
    } catch (Exception $error) {
        $response["msg"] = "Error while chaging password: {$error->getMessage()}";
        echo json_encode($response);
        exit;
    }
}

?>