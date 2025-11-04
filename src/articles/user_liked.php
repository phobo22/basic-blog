<?php

// check if an user like an article or not, and all like of that article

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../config/session.php";

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

$articleID = $_GET["articleId"];
if (empty($articleID)) {
    $response["msg"] = "Missing Article ID";
    echo json_encode($response);
    exit;
}

$userID = $_SESSION["userid"];

try {
    $pdo = dbConnect();
    $selectQuery = $pdo->prepare("select (select count(*) from likes 
                                        where article_id = :articleID and user_id = :userID) as userLiked, 
                                    count(*) as numberOfLikes 
                                from likes where article_id = :articleID;");
    $selectQuery->execute([":articleID" => $articleID, ":userID" => $userID,]);
    $data = $selectQuery->fetch(PDO::FETCH_ASSOC);

    $response["success"] = true;
    $response["data"] = [
        "liked" => $data["userLiked"],
        "like_count" => $data["numberOfLikes"]
    ];

    echo json_encode($response);
    exit;
} catch (Exception $error) {
    $response["msg"] = "Error when getting likes data from db";
    echo json_encode($response);
    exit;
}

?>