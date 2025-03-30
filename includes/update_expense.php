<?php
include "database.php"; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $type = $_POST['type'];

    // Validate inputs (basic security)
    $id = mysqli_real_escape_string($db, $id);
    $date = mysqli_real_escape_string($db, $date);
    $category = mysqli_real_escape_string($db, $category);
    $description = mysqli_real_escape_string($db, $description);
    $amount = mysqli_real_escape_string($db, $amount);
    $type = mysqli_real_escape_string($db, $type);

    // Update query
    $query = "UPDATE expenses SET date='$date', category='$category', description='$description', amount='$amount', type='$type' WHERE id=$id";

    if (mysqli_query($db, $query)) {
        header("Location: manage_expenses.php?update=success");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($db);
    }
}
?>
