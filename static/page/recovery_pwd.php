<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/recovery_pwd.css">
    <title>Recover Password</title>
</head>
<body>
    <h1 id="title">Recover Your Password</h1>
    <form id="sendmail-form" method="post" style="display:none">
        <input type="hidden" name="form" value="send">
        <h3 id="email-title">Recover With Email</h3>
        <div class="content">
            <input type="email" name="email" id="email" placeholder="Enter your email">
        </div>
        <span id="send-msg-display"></span>
        <button type="submit" name="send-btn" value="send" id="send-btn">Send email</button>
    </form>

    <form id="recoverpwd-form" method="post" style="display:none">
        <input type="hidden" name="form" value="recover">
        <h3 id="pwd-title">Recover Your Password</h3>
        <div class="content">
            <input type="password" name="new-password" id="new-password" placeholder="New password">
            <input type="password" name="re-password" id="re-password" placeholder="Confirm password">
        </div>
        <span id="recover-msg-display"></span>
        <button type="submit" id="recover-btn" name="recover-btn" value="recover">Recover Password</button>
    </form>

    <div id="msg-display" style="display:none">asdasd</div>
    <script src="../js/recovery_pwd.js"></script>
</body>
</html>

