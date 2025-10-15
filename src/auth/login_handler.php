<?php

require_once __DIR__ . "/../../config/session.php";
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../helper/functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["password"];

    header("Content-Type: application/json");
    $response = [
        "success" => false,
        "msg" => ""
    ];

    if (empty($username) || empty($pwd)) {
        $response["msg"] = "Please fill in all blanks";
        echo json_encode($response);
        exit;
    }

    try {
        $pdo = dbConnect();
        $users = getUserWithUsername($pdo, $username);

        if (count($users) !== 0) $user = $users[0];
        if (count($users) === 0 || password_verify($pwd, $user["pwd"]) === false) {
            $response["msg"] = "Username or password is incorrect";
            echo json_encode($response);
            exit;
        }

        $response["success"] = true;
        $response["msg"] = "Login successfully";

        $_SESSION["userid"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["email"] = $user["email"];

        session_regenerate_id(true);
        $_SESSION["last_generate"] = time();

        echo json_encode($response);
        exit;
    } catch (Exception $error) {
        $response["msg"] = $error->getMessage();
        echo json_encode($response);
        exit;
    }
}

?>