<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include_once 'database.php';
session_start();

// Check if user email exists in session
if (!isset($_SESSION['temp_email'])) {
    echo '<script>alert("No email found. Please sign up first."); window.location.href="signup.php";</script>';
    exit();
}

$email = $_SESSION['temp_email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Verification process
    if (isset($_POST['verification_code'])) {
        $entered_code = trim($_POST["verification_code"]);

        // Retrieve the stored verification code from the database
        $stmt = $db->prepare("SELECT verification_code FROM users WHERE email = ? AND is_verified = 0");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($stored_code);
            $stmt->fetch();

            if ($entered_code == $stored_code) {
                // Update user's verification status
                $update_stmt = $db->prepare("UPDATE users SET is_verified = 1 WHERE email = ?");
                $update_stmt->bind_param("s", $email);

                if ($update_stmt->execute()) {
                    // Clear session data after successful verification
                    unset($_SESSION['temp_email']);
                    echo '<script>alert("Verification successful! Your account is now active. You can log in."); window.location.href="login.php";</script>';
                    exit();
                } else {
                    echo '<script>alert("Failed to verify account. Please try again.");</script>';
                }
                
                $update_stmt->close();
            } else {
                echo '<script>alert("Invalid verification code. Please try again.");</script>';
            }
        } else {
            echo '<script>alert("User not found or already verified."); window.location.href="signup.php";</script>';
            exit();
        }

        $stmt->close();
    }

    // Resend verification code
    if (isset($_POST['resend_code'])) {
        $new_code = rand(100000, 999999);

        // Update verification code in the database
        $update_stmt = $db->prepare("UPDATE users SET verification_code = ? WHERE email = ?");
        $update_stmt->bind_param("is", $new_code, $email);

        if ($update_stmt->execute()) {
            $mail = new PHPMailer(true);

            try {
                // PHPMailer SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'krisdane232004@gmail.com'; 
                $mail->Password = 'eyyvhtbpelvqjlbd';      
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('krisdane232004@gmail.com', 'XpenSync');
                $mail->addAddress($email);
                $mail->Subject = "Resend Verification Code";
                $mail->Body = "Your new verification code is: " . $new_code;

                if ($mail->send()) {
                    echo '<script>alert("A new verification code has been sent to your email.");</script>';
                } else {
                    echo '<script>alert("Failed to send verification email. Please try again.");</script>';
                }
            } catch (Exception $e) {
                echo '<script>alert("Mailer Error: ' . $mail->ErrorInfo . '");</script>';
            }
        } else {
            echo '<script>alert("Database update failed.");</script>';
        }

        $update_stmt->close();
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    
</head>
<style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif}body{display:flex;justify-content:center;align-items:center;height:100vh;background:url(images/wallpaper.jpg) no-repeat center center;background-size:cover}.container{max-width:400px;background:#fff;padding:20px;border-radius:10px;box-shadow:0 0 10px #0003;text-align:center}h2{margin-bottom:15px}.form-group{margin-bottom:10px;text-align:left}.form-group label{font-weight:700;display:block}.form-group input{width:100%;padding:8px;border:1px solid #ccc;border-radius:5px;font-size:14px}.btn{width:100%;padding:10px;background:#7209b7;color:#fff;border:none;border-radius:5px;cursor:pointer;transition:.3s;font-size:14px;margin-bottom:5px}.btn:hover{background:#3a0ca3}.resend-btn{background:#555}.resend-btn:hover{background:#333}
</style>
<body>
    <div class="container">
        <h2>Email Verification</h2>
        <p>Please enter the verification code sent to <strong><?php echo htmlspecialchars($email); ?></strong>.</p>
        <form method="post">
            <div class="form-group">
                <label>Verification Code</label>
                <input type="text" name="verification_code" required>
            </div>
            <button type="submit" class="btn">Verify</button>
        </form>
        <form method="post">
            <button type="submit" name="resend_code" class="btn resend-btn">Resend Code</button>
        </form>
    </div>
</body>
</html>
