<?php

ini_set("session.use_only_cookies", 1);
ini_set("session.use_strict_mode", 1);

session_set_cookie_params([
    "lifetime" => 1800,
    "domain" => "localhost",
    "path" => "/",
    "secure" => true,
    "httponly" => true
]);

session_start();

if (!isset($_SESSION["last_generate"])) {
    session_regenerate_id(true);
    $_SESSION["last_generate"] = time();
} else {
    $interval = 30 * 60;
    if (time() - $_SESSION["last_generate"] > $interval) {
        session_regenerate_id(true);
        $_SESSION["last_generate"] = time();
    }
}

?>