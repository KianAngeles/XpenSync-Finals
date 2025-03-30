<?php
include "database.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Validate ID
    $id = mysqli_real_escape_string($db, $id);

    // Delete query
    $query = "DELETE FROM expenses WHERE id=$id";

    if (mysqli_query($db, $query)) {
        header("Location: manage_expenses.php?delete=success"); 
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($db);
    }
}
?>
