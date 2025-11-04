<?php

require_once __DIR__ . "/../../config/database.php";
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    echo json_encode(["success" => false]);
    exit;
}

$articleId = $_GET["id"];

if (empty($articleId)) {
    echo json_encode(["success" => false]);
    exit;
}

try {
    $pdo = dbConnect();
    $countQuery = $pdo->prepare("select count(*) as cmt_count from comments where article_id = :id;");
    $countQuery->execute([":id" => $articleId,]);
    echo json_encode(["cmt_count" => $countQuery->fetch(PDO::FETCH_ASSOC)["cmt_count"]]);
    exit;
} catch (Exception $error) {
    echo json_encode(["success" => false]);
    exit;
}

?>