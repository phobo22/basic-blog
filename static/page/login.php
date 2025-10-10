<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Log in</title>
</head>
<body>
    <form id="login-form" method="post">
        <h2 id="title">Sign In</h2>
        <span id="error-display"></span>
        <div class="content">
            <input type="text" name="username" id="username" placeholder="Username">
            <input type="password" name="password" id="password" placeholder="Password">
            <a href="./recovery_pwd.php">Forgot Password ?</a>
        </div>
        <button id="login-btn" name="login">Log In</button>
    </form>
    <script src="../js/login.js"></script>
</body>
</html>

