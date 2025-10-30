<?php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../config/session.php";

header("Content-Type: application/json");
$response = [
    "success" => false,
    "msg" => ""
];

if ($_SERVER["REQUEST_METHOD"] !== "POST")  {
    $response["msg"] = "Invalid request method";
    echo json_encode($response);
    exit;
}

$articleId = $_POST["article_id"];
$cmtMsg = $_POST["cmt-msg"];

if (empty($cmtMsg)) {
    $response["msg"] = "Please type something";
    echo json_encode($response);
    exit;
}

try {
    $pdo = dbConnect();
    $addQuery = $pdo->prepare("insert into comments (article_id, user_id, content) 
                                values (:article_id, :user_id, :content);");
    $addQuery->execute([
        ":article_id" => $articleId,
        ":user_id" => $_SESSION["userid"],
        ":content" => $cmtMsg,
    ]);

    $response["success"] = true;
    $response["msg"] = "Add comment successfully";
    
    echo json_encode($response);
    exit;
} catch (Exception $error) {
    $response["msg"] = "Error when adding comment: {$error->getMessage()}";
    echo json_encode($response);
    exit;
}

?>