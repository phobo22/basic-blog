<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_unset();
    session_destroy();

    header("Content-Type: application/json");
    echo json_encode(["success" => true, "msg" => ""]);
}

?>