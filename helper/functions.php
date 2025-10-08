<?php

function isUserExist($pdo, $username) {
    $sql = $pdo->prepare("select * from users where username = '{$username}';");
    $sql->execute();

    $usernames = $sql->fetchAll(PDO::FETCH_ASSOC);
    if (count($usernames) == 1) return true;
    return false;
}

function isEmailExist($pdo, $email) {
    $sql = $pdo->prepare("select * from users where email = '{$email}';");
    $sql->execute();

    $emails = $sql->fetchAll(PDO::FETCH_ASSOC);
    if (count($emails) == 1) return true;
    return false;
}

function getUser($pdo, $username) {
    try {
        $query = $pdo->prepare("select pwd from users where username = {$username};");
        $query->execute([$username]);
        $hashedPwd = $query->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $error) {

    }
}

?>