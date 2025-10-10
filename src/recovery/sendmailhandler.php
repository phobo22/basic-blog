<?php

// require_once __DIR__ . "../../config/database.php";
// require_once __DIR__ . "../../helper/functions.php";
// require_once __DIR__ . "./createtoken.php";

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $email = $_POST["email"];
//     header("Content-Type: text/plain");

//     if (empty($email)) {
//         echo "Please enter your email address";
//         exit;
//     }

//     try {
//         $pdo = dbConnect();
//         $users = getUserWithUsername($pdo, $email);

//         if (count($users) === 0) {
//             echo "Email has not been registerd yet";
//             exit;
//         } else {
//             $token = createToken($pdo, $user["id"]);
//             echo "Check your email for recovery password link";
//             exit;
//         }
//     } catch (Exception $error) {
//         echo "{$error->getMessage()}";
//         exit;
//     }
// }

?>