<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$user_name = $_SESSION['name'] ?? 'Guest';

include 'database.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrower = $_POST['borrower'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $date_lent = $_POST['date_lent'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];
    $user_id = $_SESSION['id']; 

    // Prepare the SQL query
    $query = "INSERT INTO lending (user_id, borrower, description, amount, date_lent, due_date, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($query);
    
    if (!$stmt) {
        die("Prepare failed: " . $db->error);
    }

    $stmt->bind_param("issdsss", $user_id, $borrower, $description, $amount, $date_lent, $due_date, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Lending transaction added successfully!'); window.location.href='addlending.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Lending</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="css/mediaquery.css" rel="stylesheet" type="text/css" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
body{background:#16263b;color:#fff}.container{background:#16263b}h1,h2,h3{color:#e0e4e8}.add-lending-form{background:#23344d;padding:20px;border-radius:8px;box-shadow:0 4px 8px #4a6a8a99}.add-lending-form label{font-weight:700;color:#fff}.add-lending-form input,.add-lending-form select,.add-lending-form textarea{border:none;border-radius:5px;background:#16263b;color:#fff;padding:8px;width:100%}.add-lending-form input::placeholder,.add-lending-form select::placeholder,.add-lending-form textarea::placeholder{color:#fff;opacity:.7}.add-lending-form input[type="date"]::-webkit-calendar-picker-indicator{filter:invert(1)}.add-lending-form button{background:#4a6a8a;border-radius:5px;color:#fff;font-size:16px;cursor:pointer;padding:10px;transition:background .3s;width:100%;border:none}.add-lending-form button:hover{background:#6f8ba8}.recent-transactions{background:#16263b;border-radius:8px;box-shadow:0 4px 8px #4a6a8a99}#transactionsTable th{background:#4a6a8a;color:#fff}
    </style>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>

        <div class="main-content">
            <h1>Add Lending Transaction</h1>

            <form action="addlending.php" method="POST" class="add-lending-form">
                <label>Borrower Name:</label>
                <input type="text" name="borrower" required>

                <label>Description:</label>
                <textarea name="description" rows="3" required></textarea>

                <label>Amount (₱):</label>
                <input type="number" name="amount" step="0.01" required>

                <label>Date Lent:</label>
                <input type="date" name="date_lent" required>

                <label>Due Date:</label>
                <input type="date" name="due_date" required>

                <label>Status:</label>
                <select name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Paid">Paid</option>
                </select>

                <button type="submit">Add Lending</button>
            </form>

        </div>
    </div>
</body>
</html>
