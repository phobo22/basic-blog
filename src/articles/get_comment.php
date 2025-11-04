<?php

require_once __DIR__ . "/../../config/database.php";

header("Content-Type: application/json");
$response = [
    "success" => false,
    "msg" => "",
    "data" => null
];

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    $response["msg"] = "Invalid request method";
    echo json_encode($response);
    exit;
}

$articleId = $_GET["id"];
if (empty($articleId)) {
    $response["msg"] = "Missing article ID";
    echo json_encode($response);
    exit;
}

try {
    $pdo = dbConnect();
    $selectQuery = $pdo->prepare("select u.username, c.commented_at, c.content 
                                from users u join comments c on u.id = c.user_id 
                                where c.article_id = :id 
                                order by c.commented_at desc;");
    $selectQuery->execute([":id" => $articleId,]);
    $comments = $selectQuery->fetchAll(PDO::FETCH_ASSOC);
    
    $response["success"] = true;
    $response["msg"] = "Successfully";
    $response["data"] = $comments;

    echo json_encode($response);
    exit;
} catch (Exception $error) {
    $response["msg"] = "Error when getting comments: {$error->getMessage()}";
    echo json_encode($response);
    exit;
}

?>