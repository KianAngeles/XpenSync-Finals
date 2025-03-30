<?php
session_start();
include 'database.php';

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['id'];
$user_name = $_SESSION['name'] ?? 'Guest';

$query = "
    SELECT u.name, u.email, u.phone, 
           up.profile_picture, up.first_name, up.last_name, 
           up.gender, up.bio
    FROM users u
    LEFT JOIN user_profiles up ON u.id = up.user_id
    WHERE u.id = ?
";

$stmt = $db->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Initialize notification variables
$notification = '';
$notification_type = ''; // 'success' or 'error'

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        $new_name = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $first_name = $_POST['firstname'];
        $last_name = $_POST['lastname'];
        $gender = $_POST['gender'];
        $bio = $_POST['bio'];

        // Profile picture upload
        if (!empty($_FILES['profile_picture']['name'])) {
            $target_dir = "uploads/";
            $file_name = basename($_FILES['profile_picture']['name']);
            $target_file = $target_dir . time() . "_" . $file_name; // Unique filename
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($imageFileType, $allowed_types)) {
                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                    // Delete old profile picture if exists
                    if (!empty($user['profile_picture']) && file_exists($user['profile_picture'])) {
                        unlink($user['profile_picture']);
                    }
                    $profile_picture = $target_file;
                    // Update session with new profile picture
                    $_SESSION['profile_picture'] = $profile_picture;
                } else {
                    $profile_picture = $user['profile_picture']; // Keep old picture if upload fails
                    $notification = "Failed to upload profile picture.";
                    $notification_type = "error";
                }
            } else {
                $profile_picture = $user['profile_picture']; // Keep old picture if invalid file type
                $notification = "Invalid file type. Only JPG, JPEG, PNG & GIF are allowed.";
                $notification_type = "error";
            }
        } else {
            $profile_picture = $user['profile_picture']; // Keep old picture if not changed
        }

        // Update users table
        $update_user_query = "UPDATE users SET name=?, email=?, phone=? WHERE id=?";
        $stmt = $db->prepare($update_user_query);
        $stmt->bind_param("sssi", $new_name, $email, $phone, $user_id);
        $user_update_success = $stmt->execute();
        $stmt->close();

        // Update user_profiles table
        $update_profile_query = "UPDATE user_profiles SET profile_picture=?, first_name=?, last_name=?, gender=?, bio=? WHERE user_id=?";
        $stmt = $db->prepare($update_profile_query);
        $stmt->bind_param("sssssi", $profile_picture, $first_name, $last_name, $gender, $bio, $user_id);
        $profile_update_success = $stmt->execute();
        $stmt->close();

        if ($user_update_success && $profile_update_success) {
            $_SESSION['name'] = $new_name;
            $notification = "Profile updated successfully!";
            $notification_type = "success";
        } else {
            $notification = "Error updating profile.";
            $notification_type = "error";
        }
    }

    // Handle password change
    if (isset($_POST['change_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Fetch current password hash
        $pass_query = "SELECT password FROM users WHERE id = ?";
        $stmt = $db->prepare($pass_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($current_hashed_password);
        $stmt->fetch();
        $stmt->close();

        // Verify old password
        if (password_verify($old_password, $current_hashed_password)) {
            if ($new_password === $confirm_password) {
                $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $update_pass_query = "UPDATE users SET password=? WHERE id=?";
                $stmt = $db->prepare($update_pass_query);
                $stmt->bind_param("si", $new_hashed_password, $user_id);
                if ($stmt->execute()) {
                    $notification = "Password updated successfully!";
                    $notification_type = "success";
                } else {
                    $notification = "Error updating password.";
                    $notification_type = "error";
                }
                $stmt->close();
            } else {
                $notification = "New passwords do not match.";
                $notification_type = "error";
            }
        } else {
            $notification = "Incorrect old password.";
            $notification_type = "error";
        }
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <link href="css/mediaquery.css" rel="stylesheet" type="text/css">
</head>
<style>
    .notification{position:fixed;top:20px;right:20px;padding:15px 25px;border-radius:5px;color:#fff;font-weight:700;box-shadow:0 4px 6px #0000001a;z-index:1000;opacity:0;transition:opacity .5s ease-in-out;max-width:300px}.notification.show{opacity:1}.notification.success{background-color:#4CAF50}.notification.error{background-color:#f44336}.close-notification{margin-left:15px;color:#fff;font-weight:700;float:right;cursor:pointer}
</style>
<body>
    <!-- Notification Container -->
    <?php if (!empty($notification)): ?>
    <div class="notification <?php echo $notification_type; ?>" id="notification">
        <span><?php echo htmlspecialchars($notification); ?></span>
        <span class="close-notification" onclick="hideNotification()">&times;</span>
    </div>
    <?php endif; ?>

    <div class="og-container profile-container">
        <?php include 'sidebar.php'; ?>

        <div class="main-content">
            <h2 class="profile-title">Profile Settings</h2>
            <!-- Profile Update Form -->
            <form class="profile-form" action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="form_type" value="profile_update"> 

                <div class="profile-pic">
                    <img class="profile-img" src="<?= $user['profile_picture']?>" alt="Profile Picture" id="profileImage">
                    <p><strong><?= htmlspecialchars($user_name); ?></strong></p>

                    <div class="profile-pic-buttons">
                        <label for="fileInput" class="upload-btn">Upload</label>
                    </div>
                    <input class="profile-file-input" type="file" name="profile_picture" accept="image/*" id="fileInput">
                </div>

                <div class="profile-input-container">
                    <label class="profile-label">Username:</label>
                    <input class="profile-input" type="text" name="username" value="<?= htmlspecialchars($user['name']); ?>" >

                    <label class="profile-label">Email:</label>
                    <input class="profile-input" type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>">

                    <label class="profile-label">Phone:</label>
                    <input class="profile-input" type="text" name="phone" value="<?= htmlspecialchars($user['phone']); ?>">

                    <label class="profile-label">First Name:</label>
                    <input class="profile-input" type="text" name="firstname" value="<?= htmlspecialchars($user['first_name']); ?>">

                    <label class="profile-label">Last Name:</label>
                    <input class="profile-input" type="text" name="lastname" value="<?= htmlspecialchars($user['last_name']); ?>">

                    <label class="profile-label">Gender:</label>
                    <select class="profile-select" name="gender">
                        <option value="male" <?= ($user['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?= ($user['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
                    </select>

                    <label class="profile-label">Bio:</label>
                    <textarea class="profile-textarea" name="bio"><?= htmlspecialchars($user['bio']); ?></textarea>
                </div>

                <!-- Profile Update Button -->
                <button type="submit" name="update_profile" class="save-btn">Save Profile Changes</button>
            </form>

            <!-- Password Change Form -->
            <form class="password-form" action="" method="POST" id="passwordForm">
                <input type="hidden" name="form_type" value="password_change"> 

                <div class="change-password-container">
                    <h3>Change Password</h3>
                    <input class="profile-input" type="password" name="old_password" placeholder="Old Password" required>
                    <input class="profile-input" type="password" name="new_password" placeholder="New Password" required>
                    <input class="profile-input" type="password" name="confirm_password" placeholder="Confirm New Password" required>
                </div>

                <!-- Password Update Button -->
                <button type="submit" name="change_password" class="save-btn">Update Password</button>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('fileInput');
        const profileImage = document.getElementById('profileImage');
        let tempProfileImage = null; 

        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    tempProfileImage = event.target.result; 
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // When the user submits the form, update the profile picture
        document.querySelector('.profile-form').addEventListener('submit', function() {
            if (tempProfileImage) {
                profileImage.src = tempProfileImage; 
            }
        });

        // Notification handling
        const notification = document.getElementById('notification');
        if (notification) {
            notification.classList.add('show');
            setTimeout(() => {
                hideNotification();
            }, 5000);
        }
    });

    function hideNotification() {
        const notification = document.getElementById('notification');
        if (notification) {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 500);
        }
    }
</script>

</body>
</html>