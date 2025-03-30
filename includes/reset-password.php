<?php
require 'database.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $db->prepare("SELECT user_id FROM password_resets WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
    } else {
        die("<script>alert('Invalid or expired token.'); window.location.href='forgot-password.php';</script>");
    }
} else {
    die("<script>alert('No token provided.'); window.location.href='forgot-password.php';</script>");
}

// Handle new password submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['new_password'])) {
        echo "<script>alert('Password cannot be empty.');</script>";
        exit;
    }

    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $new_password, $user_id);

    if ($stmt->execute()) {
        // Delete the used reset token from `password_resets`
        $stmt = $db->prepare("DELETE FROM password_resets WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        echo "<script>alert('Password reset successful. You can now log in.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Failed to reset password. Try again.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<style>
body{font-family:Arial,sans-serif;background:url(images/wallpaper.jpg);background-size:cover;display:flex;justify-content:center;align-items:center;height:100vh;margin:0}.container{background:#fff;padding:30px;border-radius:10px;box-shadow:0 4px 10px #0000001a;width:350px;text-align:center}h2{color:#333;margin-bottom:10px}p{color:#666;font-size:14px}form{display:flex;flex-direction:column;gap:15px}label{text-align:left;font-weight:700;color:#444}input[type="password"]{padding:10px;border:1px solid #ccc;border-radius:5px;font-size:16px;width:100%}button{background:#7209b7;color:#fff;padding:10px;border:none;border-radius:5px;font-size:16px;cursor:pointer;transition:.3s}button:hover{background-color:#A999FF}
</style>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <p>Enter a new password below:</p>
        <form method="post">
            <label>New Password</label>
            <input type="password" name="new_password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
