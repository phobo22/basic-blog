<?php

// $dbhost = "sql310.infinityfree.com";
// $dbname = "if0_40289485_myblog";
// $dbusername = "if0_40289485";
// $dbpwd = "Domain8ang0936";

$dbhost = "localhost";
$dbname = "blogdb";
$dbusername = "root";
$dbpwd = "mysql123";

date_default_timezone_set('Asia/Ho_Chi_Minh');

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