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
    $date = $_POST['date'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $user_id = $_SESSION['id']; 

    $query = "INSERT INTO expenses (date, category, type, description, amount, user_id) 
              VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssssdi", $date, $category, $type, $description, $amount, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Expense added successfully!'); window.location.href='addexpenses.php';</script>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Home</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <link href="css/mediaquery.css" rel="stylesheet" type="text/css" >
</head>
<style>
    body{background:#16263b;color:#fff}.main-content{background:#16263b}h1,h2,h3{color:#e0e4e8}.action-btn{background:#4a6a8a;color:#fff;transition:transform 0.3s,box-shadow .3s;border-radius:6px}.action-btn:hover{transform:scale(1.05);box-shadow:0 5px 15px #4a6a8a99}.expense-card{background:#23344d;border:2px solid #4a6a8a;box-shadow:0 4px 8px #4a6a8a99;transition:transform 0.3s,box-shadow .3s;border-radius:8px}.expense-card:hover{transform:translateY(-5px);box-shadow:0 5px 15px #4a6a8acc}.amount{color:#e0e4e8}.recent-transactions{background:#16263b;border-radius:8px;box-shadow:0 4px 8px #4a6a8a99}#transactionsTable th{background:#4a6a8a;color:#fff}.dashboard-separator{background:#4a6a8a}.expense-form-container{background:#23344d;box-shadow:0 4px 8px #4a6a8a99;border-radius:8px}.expense-form-container h2{text-align:center;color:#e0e4e8}.expense-form-container label{font-weight:700;color:#fff}input[type="date"]::-webkit-calendar-picker-indicator{filter:invert(1)}.expense-form-container input,.expense-form-container select{border:none;border-radius:5px;background:#16263b;color:#fff;caret-color:#fff}.expense-form-container input::placeholder,.expense-form-container select::placeholder{color:#fff;opacity:.7}.expense-form-container button{background:#4a6a8a;border-radius:5px;color:#fff;font-size:16px;cursor:pointer;transition:background .3s}.expense-form-container button:hover{background:#6f8ba8}
</style>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?> <!-- Sidebar -->

        <div class="main-content">

        <div class="expense-form-container">
            <h2>Add Expense</h2>
            <form action="addexpenses.php" method="POST">
                <label for="date">Date of Expense</label>
                <input type="date" id="date" name="date" required>

                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="Food & Dining">Food & Dining</option>
                    <option value="Transportation">Transportation</option>
                    <option value="Housing & Utilities">Housing & Utilities</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Shopping">Shopping</option>
                    <option value="Health & Fitness">Health & Fitness</option>
                    <option value="Bills & Subscriptions">Bills & Subscriptions</option>
                    <option value="Miscellaneous">Miscellaneous</option>
                </select>

                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                </select>

                <label for="description">Description</label>
                <input type="text" id="description" name="description" placeholder="Enter description" required>

                <label for="amount">Amount (₱)</label>
                <input type="number" id="amount" name="amount" step="0.01" placeholder="Enter amount" required>

                <button type="submit">Add Expense</button>
            </form>
        </div>

        </div>
    </div>
</body>
</html>
