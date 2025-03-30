<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.location.href='forgot-password.php';</script>";
        exit;
    }

    // Fetch user_id based on email
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    if ($user_id) {
        date_default_timezone_set('Asia/Manila'); 
        $token = bin2hex(random_bytes(32)); 
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Store token in password_resets table
        $stmt = $db->prepare("
            INSERT INTO password_resets (user_id, reset_token, reset_expires) 
            VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE reset_token = VALUES(reset_token), reset_expires = VALUES(reset_expires)
        ");
        $stmt->bind_param("iss", $user_id, $token, $expires);
        
        if ($stmt->execute()) {
            $stmt->close();
            $reset_link = "http://localhost/XpenSync/includes/reset-password.php?token=$token";

            // Send Email with PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'krisdane232004@gmail.com';
                $mail->Password = 'eyyvhtbpelvqjlbd'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('krisdane232004@gmail.com', 'XpenSync Support');
                $mail->addAddress($email);
                $mail->Subject = "Password Reset Request";
                $mail->Body = "Click the following link to reset your password: $reset_link \nThis link will expire in 1 hour.";

                if ($mail->send()) {
                    $success_message = "Password reset link has been sent to your email address.";
                } else {
                    $error_message = "Failed to send reset email. Please try again.";
                }
            } catch (Exception $e) {
                $error_message = "Mailer Error: " . htmlspecialchars($mail->ErrorInfo);
            }
        } else {
            $error_message = "Database error. Please try again.";
        }
    } else {
        $error_message = "Email not found in our system.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script>
        // Show notification after form submission
        window.onload = function() {
            <?php if(isset($success_message)): ?>
                alert("<?php echo $success_message; ?>");
                window.location.href = 'login.php';
            <?php endif; ?>
            
            <?php if(isset($error_message)): ?>
                alert("<?php echo $error_message; ?>");
            <?php endif; ?>
        };
    </script>
</head>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif}body{display:flex;justify-content:center;align-items:center;height:100vh;background:url(images/wallpaper.jpg);background-size:cover}.container{max-width:400px;background:#fff;padding:20px;border-radius:10px;box-shadow:0 0 10px #0003;text-align:center}h2{margin-bottom:15px;color:#333}p{font-size:14px;color:#555;margin-bottom:15px}.form-group{margin-bottom:15px;text-align:left}label{font-weight:700;display:block;margin-bottom:5px;color:#444}input{width:100%;padding:10px;border:1px solid #ccc;border-radius:5px;font-size:14px}button{width:100%;padding:10px;background:#7209b7;color:#fff;border:none;border-radius:5px;cursor:pointer;transition:.3s;font-size:14px;margin-top:10px}button:hover{background:#3a0ca3}
</style>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <p>Enter your email to receive a password reset link.</p>
        <form method="post">
            <label>Email</label>
            <input type="email" name="email" required>
            <button type="submit">Send Reset Link</button>
        </form>
    </div>
</body>
</html>