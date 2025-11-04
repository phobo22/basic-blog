<?php

// get all articles in database

require_once __DIR__ . "/../../config/database.php";

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

    // just get all articles in current 3 days
    $current_3_day = date('Y-m-d H:i:s', strtotime("-3 day"));
    $selectQuery = $pdo->prepare("select u.username, a.id, a.user_id, a.posted_at, a.text_content, a.file_name 
                                from users u join articles a on u.id = a.user_id 
                                where a.posted_at > :time 
                                order by a.posted_at desc;");
    $selectQuery->execute([":time" => $current_3_day,]);
    $articles = $selectQuery->fetchAll(PDO::FETCH_ASSOC);

    // redefine article to assign image path
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