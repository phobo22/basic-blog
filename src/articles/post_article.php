<?php

require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../config/session.php";

$BASE_DIR = __DIR__ . "/../../uploads/{$_SESSION["userid"]}/";

header("Content-Type: application/json");
$response = [
    "success" => false,
    "msg" => ""
];

// some configuarations for image file
$uploadDir = __DIR__ . "/../uploads";
$maximumSize = 2 * 1024 * 1024;
$allowedMime = [
    'image/jpeg', 'image/png', 'image/gif', 'image/webp'
];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $response["msg"] = "Invalid method";
    echo json_encode($response);
    exit;
}

// if user does not include anything
if (empty($_FILES["image"]["name"]) && empty($_POST["text"])) {
    $response["msg"] = "You have to type something or upload a photo";
    echo json_encode($response);
    exit;
}

$textInput = $_POST["text"];
$imageFile = $_FILES["image"];

// user include an image
if ($imageFile["name"]) {
    // if file zise exceeds limitation
    if ($imageFile['size'] > $maximumSize) {
        $response["msg"] = "File exceeds limit - 2MB";
        echo json_encode($response);
        exit;
    }

    // read file information 
    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    if (!$finfo) {
        $response["msg"] = "File type error";
        echo json_encode($response);
        exit;
    }

    // get file extension
    $mime = finfo_file($finfo, $imageFile["tmp_name"]);
    finfo_close($finfo);

    // user's file input is not in allowed file
    if (!in_array($mime, $allowedMime)) {
        $response["msg"] = "File type is not allowed";
        echo json_encode($response);
        exit;
    }

    // if can not create folder to store file
    if (!is_dir($BASE_DIR) && !mkdir($BASE_DIR, 0755, true)) {
        $response["msg"] = "Error when creating uploads folder";
        echo json_encode($response);
        exit;
    }

    // if can not store file
    if (!move_uploaded_file($imageFile["tmp_name"], $BASE_DIR . $imageFile["name"])) {
        $response["msg"] = "Error when uploading file";
        echo json_encode($response);
        exit;
    }
}

try {
    $pdo = dbConnect();
    $insertQuery = $pdo->prepare("insert into articles (user_id, text_content, file_name) 
                                values (:userid, :text, :filename);");
    $insertQuery->execute([
        ":userid" => $_SESSION["userid"],
        ":text" => $textInput ?? null,
        ":filename" => $imageFile["name"] ?? null,
    ]);

    $response["success"] = true;
    $response["msg"] = "Upload successfully";
    echo json_encode($response);
    exit;
} catch (Exception $error) {
    $response["msg"] = "Error when posting article";
    echo json_encode($response);
    exit;
}

?>