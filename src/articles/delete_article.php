<?php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../config/session.php";

if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    echo json_encode(["success" => false, "msg" => "1"]);
    exit;
}

$articleID = $_GET["id"];

if (empty($articleID)) {
    echo json_encode(["success" => false, "msg" => "2"]);
    exit;
}

try {
    // connect database
    $pdo = dbConnect();

    // get image file name if exist in order to delete file in uploads
    $selectQuery = $pdo->prepare("select file_name from articles where id = :id;");
    $selectQuery->execute([":id" => $articleID,]);
    $data = $selectQuery->fetch(PDO::FETCH_ASSOC);
    $imgFilename = (count($data) !== 0) ? $data["file_name"] : "";

    // delete row in database
    $deleteQuery = $pdo->prepare("delete from articles where id = :id;");
    $deleteQuery->execute([":id" => $articleID,]);

    // delete image file in uploads
    $filePath = "../../uploads/{$_SESSION["userid"]}/{$imgFilename}";
    if ($imgFilename !== "") {
        if (unlink($filePath)) {
            echo json_encode(["success" => true]);
            exit;
        }
    }

    echo json_encode(["success" => true]);
    exit;
} catch (Exception $error) {
    echo json_encode(["success" => false, "msg" => $error]);
    exit;
}

?>