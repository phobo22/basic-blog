<?php

require_once __DIR__ . "/../../config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    header("Content-Type: application/json");
    $response = [
        "success" => false,
        "msg" => ""
    ];

    if (!isset($_GET["id"])) {
        $response["msg"] = "Missing task ID";
        echo json_encode($response);
        exit;
    }

    $taskId = $_GET["id"];
    try {
        $pdo = dbConnect();
        $deleteQuery = $pdo->prepare("delete from tasks where id = :taskId;");
        $deleteQuery->execute([":taskId" => $taskId,]);

        $response["success"] = true;
        $response["msg"] = "Delete successfully";
        echo json_encode($response);
        exit;
    } catch (Exception $error) {
        $response["msg"] = "Error when deleting task: {$error->getMessage()}";
        echo json_encode($response);
        exit;
    }
}

?>