<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/XpenSync/includes/PHPMailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/XpenSync/includes/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/XpenSync/includes/PHPMailer/src/SMTP.php';

include_once 'database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validation checks
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        echo '<script>alert("All fields are required");</script>';
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email address");</script>';
        exit();
    }
    if (!preg_match('/^\d{10,}$/', $phone)) {
        echo '<script>alert("Invalid phone number");</script>';
        exit();
    }
    if ($password !== $confirm_password) {
        echo '<script>alert("Passwords do not match");</script>';
        exit();
    }
    if (strlen($password) < 8) {
        echo '<script>alert("Password must be at least 8 characters long");</script>';
        exit();
    }

    // Check if email or username already exists
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo '<script>alert("Error: Email already registered!");</script>';
        exit();
    }
    $stmt->close();

    $stmt = $db->prepare("SELECT id FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo '<script>alert("Error: Username already taken!");</script>';
        exit();
    }
    $stmt->close();

    // Generate verification code and hash password
    $verification_code = rand(100000, 999999);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert_stmt = $db->prepare("INSERT INTO users (name, email, phone, password, verification_code, is_verified) VALUES (?, ?, ?, ?, ?, 0)");
    $insert_stmt->bind_param("ssssi", $name, $email, $phone, $hashed_password, $verification_code);

    if ($insert_stmt->execute()) {
        $_SESSION['temp_email'] = $email;

        // **PHPMailer setup**
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'krisdane232004@gmail.com'; 
            $mail->Password = 'eyyvhtbpelvqjlbd';   
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

     
            $mail->SMTPDebug = 0; 

            // Recipients
            $mail->setFrom('krisdane232004@gmail.com', 'XpenSync');
            $mail->addAddress($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification Code';
            $mail->Body = "Your verification code is: <b>{$verification_code}</b>";
            $mail->AltBody = "Your verification code is: {$verification_code}";

            if ($mail->send()) {
                echo '<script>alert("Verification code sent! Check your email."); window.location.href="signupverify.php";</script>';
                exit();
            } else {
                echo '<script>alert("Mailer Error: ' . $mail->ErrorInfo . '");</script>';
                exit();
            }
        } catch (Exception $e) {
            echo '<script>alert("Mailer Exception: ' . $mail->ErrorInfo . '");</script>';
            exit();
        }
    } else {
        echo '<script>alert("Error: Could not create user. ' . htmlspecialchars($insert_stmt->error) . '");</script>';
        exit();
    }

    $insert_stmt->close();
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>
<style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif}body{display:flex;justify-content:center;align-items:center;height:100vh;background:url(images/wallpaper.jpg);background-size:cover}.container{display:flex;max-width:1000px;width:90%;background:#fff;border-radius:10px;overflow:hidden;max-height:500px;box-shadow:0 0 20px #0003}.left-panel{width:45%;background:linear-gradient(135deg,#3a0ca3,#7209b7);color:#fff;display:flex;flex-direction:column;justify-content:center;align-items:center;padding:20px}.left-panel h2{font-size:20px;margin-bottom:8px}.left-panel p{font-size:12px;text-align:center}.right-panel{width:55%;padding:25px}h2{text-align:center;margin-bottom:12px;font-size:20px}.form-group{margin-bottom:10px}.form-group label{display:block;font-weight:700;margin-bottom:4px;font-size:13px}.input-group{display:flex;align-items:center;border:1px solid #ccc;border-radius:5px;padding:6px;background:#f9f9f9}.input-group i{margin-right:8px;color:#555;font-size:14px}.input-group input{width:100%;border:none;outline:none;background:transparent;padding:4px;font-size:12px}.btn{width:100%;padding:8px;background:#7209b7;color:#fff;border:none;border-radius:5px;font-size:13px;cursor:pointer;transition:.3s}.btn:hover{background:#3a0ca3}.text-center{text-align:center;margin-top:8px;font-size:12px}.text-danger{color:#7209b7;text-decoration:none;font-size:12px}.text-danger:hover{text-decoration:underline}.form-check{display:flex;align-items:center;font-size:12px}@media screen and (max-width: 767px){.left-panel{display:none}.right-panel{margin:0 auto;width:80%}}
</style>
<body>
    <div class="container">
        <div class="left-panel">
            <h2>Login & Signup</h2>
            <p>Simplify Your Finances with Xpensync</p>
        </div>
        <div class="right-panel">
            <h2>Sign Up</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label>Your Name</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Your Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mobile Number</label>
                    <div class="input-group">
                        <i class="bx bx-phone"></i>
                        <input type="text" name="phone" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="input-group">
                        <i class="bx bx-key"></i>
                        <input type="password" name="confirm_password" required>
                    </div>
                </div>

                <div class="form-check">
                    <input type="checkbox" required>
                    <label>I agree to the <a href="#" class="terms-service">Terms of Service</a></label>
                </div>

                <button type="submit" name="submit" class="btn">Create Account</button>

                <p class="text-center">
                    Already have an account? <a href="login.php" class="text-danger">Login here</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>