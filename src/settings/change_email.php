<?php

session_start();

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../helper/functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newemail = $_POST["new-email"];

    header("Content-Type: application/json");
    $response = [
        "success" => false,
        "msg" => ""
    ];

    if (empty($newemail)) {
        $response["msg"] = "Please enter new email";
        echo json_encode($response);
        exit;
    }

    try {
        $pdo = dbConnect();

        if (isEmailExist($pdo, $newemail)) {
            $response["msg"] = "Email has been already registered";
            echo json_encode($response);
            exit;
        }

        $updateQuery = $pdo->prepare("update users set email = :newEmail where id = :userid");
        $updateQuery->execute([":newEmail" => $newemail, ":userid" => $_SESSION["userid"],]);

        $response["success"] = true;
        $response["msg"] = "Email changed";
        echo json_encode($response);
        exit;
    } catch (Exception $error) {
        $response["msg"] = "Error while changing email: {$error->getMessage()}";
        echo json_encode($response);
        exit;
    }
}

?>