<?php

// get all articles of an user
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../config/session.php";

header("Content-Type: application/json");
$response = [
    "success" => false,
    "msg" => "",
    "data" => null
];

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    $response["msg"] = "Invalid method";
    echo json_encode($response);
    exit;
}

try {
    $pdo = dbConnect();
    $selectQuery = $pdo->prepare("select u.username, a.id, a.user_id, a.posted_at, a.text_content, a.file_name 
                                from articles a join users u on a.user_id = u.id 
                                where a.user_id = :id 
                                order by a.posted_at desc;");
    $selectQuery->execute([":id" => $_SESSION["userid"],]);
    $articles = $selectQuery->fetchAll(PDO::FETCH_ASSOC);

    $new_articles = array_map(fn($article) => [
        "username" => $article["username"],
        "id" => $article["id"],
        "user_id" => $article["user_id"],
        "posted_at" => $article["posted_at"],
        "text_content" => $article["text_content"],
        "file_name" => ($article["file_name"]) ? "http://localhost/my-web/basic-blog/uploads/{$article["user_id"]}/{$article["file_name"]}" : "",
    ], $articles);

    $response["success"] = true;
    $response ["msg"] = "Successfully";
    $response["data"] = $new_articles;
    echo json_encode($response);
    exit;
} catch (Exception $error) {
    $response["msg"] = "Error when get articles";
    echo json_encode($response);
    exit;
}

?>