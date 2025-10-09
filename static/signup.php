<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/signup.css">
    <title>Sign Up</title>
</head>
<body>
    <form id="signup-form" method="post">
        <h2 id="title">Sign Up</h2>
        <div class="content">
            <input type="text" name="username" id="username" placeholder="Username">
            <input type="password" name="password" id="password" placeholder="Password">
            <input type="email" name="email" id="email" placeholder="Email">
        </div>
        <span id="error-display"></span>
        <button id="signup-btn">Sign up</button>
    </form>
    <script src="./js/signup.js"></script>
</body>
</html>