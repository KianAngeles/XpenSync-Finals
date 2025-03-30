<?php
session_start();
include_once 'database.php';
error_reporting(E_ALL);
$msg = '';

if (isset($_POST['submit'])) {
    $email = $db->real_escape_string($_POST['email']);
    $password = $db->real_escape_string($_POST['password']);
    
    // Fetch user details (id, name, password)
    $query = "SELECT id, name, password FROM users WHERE email = '$email'";
    $result = $db->query($query);
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_object();
        
        if (password_verify($password, $user->password)) {
            $_SESSION['id'] = $user->id;
            $_SESSION['name'] = $user->name; // Store the name in session

            header('Location: home.php'); // Redirect to home page
            exit;
        } else {
            $msg = "Invalid email or password.";
        }
    } else {
        $msg = "Invalid email or password.";
    }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<style>
/* General Reset */
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif}body{display:flex;justify-content:center;align-items:center;height:100vh;background:url(images/wallpaper.jpg);background-size:cover}.container{display:flex;max-width:800px;width:90%;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 0 20px #0003}.left-panel{width:40%;background:linear-gradient(135deg,#3a0ca3,#7209b7);color:#fff;display:flex;flex-direction:column;justify-content:center;align-items:center;padding:20px;text-align:center}.left-panel h2{font-size:22px;margin-bottom:10px}.left-panel p{font-size:14px}.right-panel{width:60%;padding:30px}.right-panel h2{text-align:center;margin-bottom:15px;font-size:22px;color:#333}.right-panel p{font-size:14px;color:#666;text-align:center;margin-bottom:15px}.form-group{margin-bottom:12px}.form-group label{display:block;font-weight:700;margin-bottom:5px;font-size:14px;color:#333}.input-group{display:flex;align-items:center;border:1px solid #ccc;border-radius:5px;padding:8px;background:#f9f9f9}.input-group input{width:100%;border:none;outline:none;background:transparent;padding:5px;font-size:14px}.btn{width:100%;padding:10px;background:#7209b7;color:#fff;border:none;border-radius:5px;font-size:14px;cursor:pointer;transition:.3s}.btn:hover{background:#3a0ca3}.text-center{text-align:center;margin-top:10px}.text-danger{color:#7209b7;text-decoration:none}.text-danger:hover{text-decoration:underline}.error-message{background-color:#fdd;color:#a94442;padding:8px;border-left:4px solid #d9534f;font-size:14px;margin-bottom:10px;border-radius:5px}@media screen and (max-width: 767px){.left-panel{display:none}.right-panel{margin:0 auto;width:80%}}
</style>
<body>

    <div class="container">
        <!-- Left Panel -->
        <div class="left-panel">
            <h2>Login & Signup</h2>
            <p>Simplify Your Finances with Xpensync</p>
        </div>

        <!-- Right Panel (Login Form) -->
        <div class="right-panel">
            <h2>Login</h2>
            <p>Enter your credentials</p>

            <?php if ($msg): ?>
                <div class="error-message"><?= $msg; ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                        <input type="email" name="email" required />
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <input type="password" name="password" required />
                    </div>
                </div>

                <button type="submit" name="submit" class="btn">Login</button>
            </form>

            <p class="text-center">
                <a href="forgot-password.php" class="text-danger">Forgot password?</a>
            </p>
            <p class="text-center">
                Don't have an account? <a href="signup.php" class="text-danger">Sign up</a>
            </p>
        </div>
    </div>

</body>
</html>



