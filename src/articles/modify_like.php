<?php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../config/session.php";

$articleId = $_GET["article_id"];
$userId = $_SESSION["userid"];

if (empty($articleId)) {
    echo json_encode(["success" => false]);
    exit;
}

try {
    $pdo = dbConnect();

    // if like
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $insertQuery = $pdo->prepare("insert into likes values (:articleId, :userId);");
        $insertQuery->execute([
            ":articleId" => $articleId,
            ":userId" => $userId
        ]);
        echo json_encode(["success" => true]);
        exit;
    }

    // if unlike
    if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
        $deletetQuery = $pdo->prepare("delete from likes where article_id = :articleID and user_id = :userID;");
        $deletetQuery->execute([
            ":articleID" => $articleId,
            ":userID" => $userId
        ]);
        echo json_encode(["success" => true]);
        exit;
    }
} catch (Exception $error) {
    echo json_encode(["success" => false]);
    exit;
}

?>