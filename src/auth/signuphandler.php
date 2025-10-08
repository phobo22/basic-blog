<?php

require_once "../../config/database.php";
require_once "../../helper/functions.php";


function isStrongPassword($password) {
    if (strlen($password) < 8) return false;
    if (!preg_match("/[A-Z]/", $password)) return false;
    if (!preg_match("/[a-z]/", $password)) return false;
    if (!preg_match("/\d/", $password)) return false;
    if (!preg_match("/[^A-Za-z0-9]/", $password)) return false;
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    $email = $_POST["email"];

    header("Content-Type: application/json");
    $response = [
        "success" => true,
        "msg" => ""
    ];

    if (empty($username) || empty($pwd) || empty($email)) {
        $response["success"] = false;
        $response["msg"] = "Please fill in all blanks";
        echo json_encode($response);
        exit;
    }

    try {
        $pdo = dbConnect();

        if (isUserExist($pdo, $username)) {
            $response["success"] = false;
            $response["msg"] = "Username has been used";
            echo json_encode($response);
            exit;
        }

        if (isEmailExist($pdo, $email)) {
            $response["success"] = false;
            $response["msg"] = "Email has been used";
            echo json_encode($response);
            exit;
        }

        if (!isStrongPassword($pwd)) {
            $response["success"] = false;
            $response["msg"] = "Password is not strong enough";
            echo json_encode($response);
            exit;
        }
        
        $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT);
        $now = date("Y-m-d h:i:s");

        $query = $pdo->prepare("insert into users (username, pwd, email, created) values (?, ?, ?, ?);");
        $query->execute([$username, $hashedPwd, $email, $now]);

        $response["msg"] = "Create account successfully";
        echo json_encode($response);
        exit;
    } catch (Exception $error) {
        $response["success"] = false;
        $response["msg"] = $error->getMessage();
        echo json_encode($response);
        exit;
    }
}

?>