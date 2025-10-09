<?php

$dbhost = "localhost";
$dbname = "blogdb";
$dbusername = "root";
$dbpwd = "mysql123";

function dbConnect() {
    global $dbhost, $dbname, $dbusername, $dbpwd;
    try {
        $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbusername, $dbpwd);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        throw new Exception("Database connect failed");
    }
}

?>