<?php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../config/session.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    header("Content-Type: application/json");
    $response = [
        "success" => false,
        "msg" => "",
        "data" => null
    ];

    try {
        $pdo = dbConnect();
        
        if (!isset($_GET["id"])) {
            $selectQuery = $pdo->prepare("select * from tasks where user_id = :userid order by end_date asc;");
            $selectQuery->execute([":userid" => $_SESSION["userid"]],);
            $tasks = $selectQuery->fetchAll(PDO::FETCH_ASSOC);
            $response["data"] = $tasks;
        } else {
            $selectQuery = $pdo->prepare("select * from tasks where id = :taskId;");
            $selectQuery->execute([":taskId" => $_GET["id"]],);
            $task = $selectQuery->fetch(PDO::FETCH_ASSOC);
            $response["data"] = $task;
        }
    
        $response["success"] = true;
        $response["msg"] = "Success";
        echo json_encode($response);
        exit;
    } catch (Exception $error) {
        $response["msg"] = "Error when get tasks: {$error->getMessage()}";
        echo json_encode($response);
        exit;
    }
}

?>