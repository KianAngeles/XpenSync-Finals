<?php
session_start();
include 'database.php';

// Ensure user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $date_lent = $_POST['date_lent'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $borrower = $_POST['borrower'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];
    
    // Validate input
    if (empty($id) || empty($date_lent) || empty($description) || empty($amount) || empty($borrower) || empty($due_date) || empty($status)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: manage_lending.php");
        exit;
    }

    // Update query
    $query = "UPDATE lending SET date_lent = ?, description = ?, amount = ?, borrower = ?, due_date = ?, status = ? WHERE id = ? AND user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssdsssii", $date_lent, $description, $amount, $borrower, $due_date, $status, $id, $_SESSION['id']);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Lending record updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating record.";
    }

    // Redirect back to manage_lending.php
    header("Location: manage_lending.php");
    exit;
}
?>
