<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/settings.css">
    <title>Setting</title>
</head>
<body>
    <?php require_once "./sidebar.php";?>
    <main class="content">
        <h1 id="title">Setting your account</h1>
        <div class="form-container">
            <div class="pwd">
                <h3>Change Password</h3>
                <form id="pwd-form" method="POST">
                    <label>Old password: <input type="password" name="old-pwd" id="old-pwd"></label>
                    <label>New password: <input type="password" name="new-pwd" id="new-pwd"></label>
                    <button type="submit" name="pwd-btn" value="pwd-btn" id="pwd-btn">Change</button>
                </form>
                <p id="pwd-msg-display"></p>
            </div>

            <div class="email">
                <h3>Change Email</h3>
                <form id="email-form" method="POST">
                    <label>New email: <input type="email" name="new-email" id="new-email"></label>
                    <button type="submit" name="email-btn" value="email-btn" id="email-btn">Change</button>
                </form>
            </div>
            <p id="email-msg-display"></p>
        </div>
    </main>
    <script src="../js/settings.js"></script>
</body>
</html>