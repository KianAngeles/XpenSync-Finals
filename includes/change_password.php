<?php
session_start();
include 'database.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate new password and confirmation
    if ($new_password !== $confirm_password) {
        die("Error: Passwords do not match.");
    }

    // Fetch the current hashed password from the database
    $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password); 
    $stmt->fetch(); 
    $stmt->close();

    // Verify the old password
    if (!password_verify($old_password, $hashed_password)) {
        die("Error: Old password is incorrect.");
    }

    // Hash the new password
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $new_hashed_password, $user_id);
    $stmt->execute();
    $stmt->close();

    // Redirect after successful password change
    header("Location: profile.php?password_updated=1");
    exit;
}
?>
