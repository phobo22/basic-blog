<?php

require_once __DIR__ . "/../../config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    header("Content-Type: application/json");
    $response = [
        "success" => false,
        "msg" => ""
    ];

    parse_str(file_get_contents("php://input"), $_PUT);
    $taskId = $_PUT["taskId"];
    $newTitle = $_PUT["taskTitle"];
    $newDes = $_PUT["taskDescription"];
    $newStart = $_PUT["taskStartDate"];
    $newEnd = $_PUT["taskEndDate"];

    if (empty($newTitle) || empty($newDes) || empty($newStart) || empty($newEnd)) {
        $response["msg"] = "Please fill in all blanks";
        echo json_encode($response);
        exit;
    }

    try {
        $pdo = dbConnect();
        $updateQuery = $pdo->prepare("update tasks 
                                    set title = :newTitle, 
                                    descriptions = :newDes, 
                                    start_date = :newStart, 
                                    end_date = :newEnd 
                                    where id = :taskId;");
        $updateQuery->execute([
            ":newTitle" => $newTitle,
            ":newDes" => $newDes,
            ":newStart" => $newStart,
            ":newEnd" => $newEnd,
            ":taskId" => $taskId,
        ]);

        $response["success"] = true;
        $response["msg"] = "Update successfully";
        echo json_encode($response);
        exit;
    } catch (Exception $error) {
        $response["msg"] = "Error when updating task: {$error->getMessage()}";
        echo json_encode($response);
        exit;
    }
}

?>