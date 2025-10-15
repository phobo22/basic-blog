<?php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../config/session.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["taskTitle"];
    $description = $_POST["taskDescription"];
    $start = $_POST["taskStartDate"];
    $end = $_POST["taskEndDate"];

    header("Content-Type: application/json");
    $response = [
        "success" => false,
        "msg" => ""
    ];

    if (empty($title) || empty($description) || empty($start) || empty($end)) {
        $response["msg"] = "Please fill in all blanks";
        echo json_encode($response);
        exit;
    }

    try {
        $pdo = dbConnect();

        $insertQuery = $pdo->prepare("insert into tasks (user_id, title, descriptions, start_date, end_date) 
                                    values (:userid, :title, :descriptions, :startdate, :enddate);");
        $insertQuery->execute([
            ":userid" => $_SESSION["userid"],
            ":title" => $title,
            ":descriptions" => $description,
            ":startdate" => $start,        
            ":enddate" => $end,              
        ]);

        $response["success"] = true;
        $response["msg"] = "Add task successfully";
        echo json_encode($response);
        exit;
    } catch (Exception $error) {
        $response["msg"] = "Error when adding task: {$error->getMessage()}";
        echo json_encode($response);
        exit;
    }
}

?>