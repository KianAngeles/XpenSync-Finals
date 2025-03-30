<?php
session_start();
include 'database.php';

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $first_name = htmlspecialchars($_POST['firstname']);
    $last_name = htmlspecialchars($_POST['lastname']);
    $gender = $_POST['gender'];
    $bio = htmlspecialchars($_POST['bio']);

    // Profile Picture Upload Handling
    $profile_picture = NULL;
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); 
        }
        $file_name = basename($_FILES["profile_picture"]["name"]);
        $target_file = $target_dir . time() . "_" . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an image
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $profile_picture = $target_file;
            } else {
                echo "Error uploading file.";
                exit;
            }
        } else {
            echo "File is not an image.";
            exit;
        }
    }

    // Update Profile Data in Database
    $sql = "UPDATE users SET 
                name = ?, 
                email = ?, 
                phone = ?, 
                first_name = ?, 
                last_name = ?, 
                gender = ?, 
                bio = ?";

    $params = [$username, $email, $phone, $first_name, $last_name, $gender, $bio];

    // If a new profile picture was uploaded, update it in the query
    if ($profile_picture) {
        $sql .= ", profile_picture = ?";
        $params[] = $profile_picture;
    }

    $sql .= " WHERE id = ?"; // Update only for the logged-in user
    $params[] = $user_id;

    $stmt = $db->prepare($sql);
    $stmt->execute($params);

    header("Location: profile.php?success=1");
    exit;
}
?>
