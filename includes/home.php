<?php
session_start();
include 'database.php';

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// Fetch username
$user_name = $_SESSION['name'] ?? 'Guest';

// Fetch recent transactions
$query = "SELECT date, category, description, amount, type FROM expenses WHERE user_id = ? ORDER BY date DESC LIMIT 5";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $_SESSION['id']); // Bind user ID to only fetch their expenses
$stmt->execute();
$result = $stmt->get_result();

// Get total expenses per category in the past 30 days
$query_expenses = "
    SELECT category, SUM(amount) AS total_amount 
    FROM expenses 
    WHERE user_id = ? 
    AND date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
    GROUP BY category
";

$stmt_expenses = $db->prepare($query_expenses);
$stmt_expenses->bind_param("i", $_SESSION['id']);
$stmt_expenses->execute();
$result_expenses = $stmt_expenses->get_result();

// Store category expenses in an associative array
$category_expenses = [];
while ($row = $result_expenses->fetch_assoc()) {
    $category_expenses[$row['category']] = $row['total_amount'];
}

// Function to display formatted expense (default to 0 if category doesn't exist)
function get_expense($category, $category_expenses) {
    return isset($category_expenses[$category]) ? "₱" . number_format($category_expenses[$category], 2) : "₱0.00";
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
    body{background:#0d1b2a;color:#fff}.main-content{background:#1b263b}h1,h2,h3{color:#e0e1dd}.action-btn{background:#415a77;color:#fff;transition:transform 0.3s,box-shadow .3s}.action-btn:hover{transform:scale(1.1);box-shadow:0 5px 15px #415a7799}.expense-card{background:#25374a;border:2px solid #415a77;box-shadow:0 4px 8px #415a7799;transition:transform 0.3s,box-shadow .3s}.expense-card:hover{transform:translateY(-5px);box-shadow:0 5px 15px #415a77cc}.amount{color:#e0e1dd}.recent-transactions{background:#1b263b;border-radius:8px;padding:10px;box-shadow:0 4px 8px #415a7799}#transactionsTable th{background:#415a77;color:#fff}#transactionsTable tr:hover{background:#415a7799;transition:background .3s}.dashboard-separator{background:#415a77}#transactionsTable tbody tr:nth-child(even){background-color:#415a77}#transactionsTable tbody tr:nth-child(odd){background-color:#415a7799}#transactionsTable tbody tr:hover{background-color:#e6f7ff;color:#000}
</style>
<body>
    <div class="container">
    <?php include 'sidebar.php'; ?> <!-- Sidebar -->

        <div class="main-content">
            <h1>Dashboard</h1>
            <p>Welcome, <strong><?php echo htmlspecialchars($user_name); ?></strong></p>

            <div class="quick-actions">
                <a href="addexpenses.php" class="action-btn">
                    <img src="images/add-button-img.png" alt="Add Expense">
                    <span>Add Expense</span>
                </a>
                <a href="manage_expenses.php" class="action-btn">
                    <img src="images/manage-button-img.png" alt="Manage Expense">
                    <span>Manage Expense</span>
                </a>
                <a href="addlending.php" class="action-btn">
                    <img src="images/add-button-img.png" alt="Add Lending">
                    <span>Add Lending</span>
                </a>
                <a href="manage_lending.php" class="action-btn">
                    <img src="images/manage-button-img.png" alt="Manage Lending">
                    <span>Manage Lending</span>
                </a>
            </div>

            <hr class="dashboard-separator">

            <h2>Expense Summary of the Month</h2>
                <div class="expense-dashboard">
                    <div class="expense-card">
                        <h3>Food & Dining</h3>
                        <p class="amount"><?php echo get_expense('Food & Dining', $category_expenses); ?></p>
                        <img src="images/food-img.png" class="db-card-icons" alt="food icon">
                    </div>

                    <div class="expense-card">
                        <h3>Transportation</h3>
                        <p class="amount"><?php echo get_expense('Transportation', $category_expenses); ?></p>
                        <img src="images/transportation-img.png" class="db-card-icons" alt="Car icon">
                    </div>

                    <div class="expense-card">
                        <h3>Housing & Utilities</h3>
                        <p class="amount"><?php echo get_expense('Housing & Utilities', $category_expenses); ?></p>
                        <img src="images/house-img.png" class="db-card-icons" alt="house icon">
                    </div>

                    <div class="expense-card">
                        <h3>Entertainment</h3>
                        <p class="amount"><?php echo get_expense('Entertainment', $category_expenses); ?></p>
                        <img src="images/entertainment-img.png" class="db-card-icons" alt="Entertainment icon">
                    </div>
                </div>

                <div class="expense-dashboard">
                    <div class="expense-card">
                        <h3>Shopping</h3>
                        <p class="amount"><?php echo get_expense('Shopping', $category_expenses); ?></p>
                        <img src="images/shopping-img.png" class="db-card-icons" alt="Shopping icon">
                    </div>

                    <div class="expense-card">
                        <h3>Health & Fitness</h3>
                        <p class="amount"><?php echo get_expense('Health & Fitness', $category_expenses); ?></p>
                        <img src="images/health-img.png" class="db-card-icons" alt="Heart icon">
                    </div>

                    <div class="expense-card">
                        <h3>Bills & Subscriptions</h3>
                        <p class="amount"><?php echo get_expense('Bills & Subscriptions', $category_expenses); ?></p>
                        <img src="images/bill-img.png" class="db-card-icons" alt="money icon">
                    </div>

                    <div class="expense-card">
                        <h3>Miscellaneous</h3>
                        <p class="amount"><?php echo get_expense('Miscellaneous', $category_expenses); ?></p>
                        <img src="images/miscellaneous-img.png" class="db-card-icons" alt="item things">
                    </div>
                </div>



            <hr class="dashboard-separator">

            <section class="recent-transactions">
                <h2>Recent Transactions</h2>
                <table id="transactionsTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['date']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td>₱<?php echo number_format($row['amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['type']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>

        </div>
    </div>
        </div>
    </div>
</body>
</html>
