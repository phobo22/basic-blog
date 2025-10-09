<?php

require_once "../../config/database.php";
require_once "../../helper/functions.php";



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["password"];

    $response = [
        "success" => true,
        "msg" => ""
    ];

    if (empty($username) || empty($pwd)) {
        $response["success"] = false;
        $response["msg"] = "Please fill in all blanks";
        echo json_encode($response);
        exit;
    }

}

?>