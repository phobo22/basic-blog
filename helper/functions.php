<?php

function isUserExist($pdo, $username) {
    $sql = $pdo->prepare("select username from users where username = '{$username}';");
    $sql->execute();
    $usernames = $sql->fetchAll(PDO::FETCH_ASSOC);

    if (count($usernames) == 1) return true;
    return false;
}

function isEmailExist($pdo, $email) {
    $sql = $pdo->prepare("select email from users where email = '{$email}';");
    $sql->execute();
    $emails = $sql->fetchAll(PDO::FETCH_ASSOC);

    if (count($emails) == 1) return true;
    return false;
}

function isStrongPassword($password) {
    if (strlen($password) < 8) return false;
    if (!preg_match("/[A-Z]/", $password)) return false;
    if (!preg_match("/[a-z]/", $password)) return false;
    if (!preg_match("/\d/", $password)) return false;
    if (!preg_match("/[^A-Za-z0-9]/", $password)) return false;
    return true;
}

function getUserWithUsername($pdo, $username) {
    $query = $pdo->prepare("select * from users where username = '{$username}';");
    $query->execute();
    $user = $query->fetchAll(PDO::FETCH_ASSOC);
    return $user;
}

function getUserWithEmail($pdo, $email) {
    $query = $pdo->prepare("select * from users where email = '{$email}';");
    $query->execute();
    $user = $query->fetchAll(PDO::FETCH_ASSOC);
    return $user;
}

function createToken($pdo, $userid) {
    $rawToken = bin2hex(random_bytes(32));
    $tokenHash = hash('sha256', $rawToken);

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $expiresAt = date("Y-m-d H:i:s", strtotime("+1 hour"));
    
    $query = $pdo->prepare("insert into password_reset (user_id, token_hash, expires_at) values (?, ?, ?)");
    $query->execute([$userid, $tokenHash, $expiresAt]);

    $resetUrl = urlencode($rawToken);
    return $resetUrl;
}

?>