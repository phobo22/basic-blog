<?php

require_once __DIR__ . "/../../config/session.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION = [];
    session_unset();
    session_destroy();

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    header("Content-Type: application/json");
    echo json_encode(["success" => true, "msg" => ""]);
    exit;
}

?>