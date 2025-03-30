<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['id']; 
$user_name = $_SESSION['name'] ?? 'Guest'; 

include 'database.php';

// Fetch expenses grouped by category
$query_expenses = "SELECT category, SUM(amount) AS total FROM expenses WHERE user_id = ? GROUP BY category";
$stmt = $db->prepare($query_expenses);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result_expenses = $stmt->get_result();

$categories = [];
$totals = [];

while ($row = $result_expenses->fetch_assoc()) {
    $categories[] = $row['category'];
    $totals[] = $row['total'];
}

// Fetch monthly spending trend
$query_trend = "SELECT DATE_FORMAT(date, '%b') AS month, SUM(amount) AS total FROM expenses WHERE user_id = ? GROUP BY month ORDER BY MIN(date)";
$stmt = $db->prepare($query_trend);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result_trend = $stmt->get_result();

$months = [];
$monthly_totals = [];

while ($row = $result_trend->fetch_assoc()) {
    $months[] = $row['month'];
    $monthly_totals[] = $row['total'];
}

// Convert PHP arrays to JSON
$categories_json = json_encode($categories);
$totals_json = json_encode($totals);
$months_json = json_encode($months);
$monthly_totals_json = json_encode($monthly_totals);

// Get total expenses for the current month
$query_total = "SELECT SUM(amount) AS total FROM expenses WHERE user_id = ? AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())";
$stmt = $db->prepare($query_total);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_expenses = $result->fetch_assoc()['total'] ?? 0;

// Get highest expense category
$query_highest = "SELECT category, SUM(amount) AS total FROM expenses WHERE user_id = ? GROUP BY category ORDER BY total DESC LIMIT 1";
$stmt = $db->prepare($query_highest);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$highest_category = $result->fetch_assoc()['category'] ?? 'N/A';

// Get average daily expenses
$query_avg_daily = "SELECT SUM(amount) / DAY(CURRENT_DATE()) AS avg_daily FROM expenses WHERE user_id = ? AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())";
$stmt = $db->prepare($query_avg_daily);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$avg_daily = $result->fetch_assoc()['avg_daily'] ?? 0;

// Get largest single transaction
$query_largest = "SELECT MAX(amount) AS largest FROM expenses WHERE user_id = ?";
$stmt = $db->prepare($query_largest);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$largest_transaction = $result->fetch_assoc()['largest'] ?? 0;


// Get total transactions for the current month
$query_transactions = "SELECT COUNT(*) AS total_transactions FROM expenses WHERE user_id = ? AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())";
$stmt = $db->prepare($query_transactions);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_transactions = $result->fetch_assoc()['total_transactions'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Analytics</title>

    <!-- Icons & Styles -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <link href="css/mediaquery.css" rel="stylesheet" type="text/css" >
    <!-- Bootstrap & Chart.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
    body{background:#0d1b2a;color:#fff;font-family:Arial,sans-serif}.analytics-container{display:flex}.main-content{flex-grow:1;padding:20px;background:#1b263b;border-radius:8px;box-shadow:0 4px 8px #415a7799}.summary-cards{display:flex;flex-wrap:wrap;gap:20px}.summary-card{background:#25374a;padding:15px;border-radius:8px;box-shadow:0 4px 8px #415a7799;flex:1;min-width:200px;text-align:center}.summary-card h4,.summary-card p{color:#fff}.chart-flex{display:flex;flex-wrap:wrap;gap:20px;margin-top:20px}.analytics-card{background:#25374a;padding:15px;border-radius:8px;box-shadow:0 4px 8px #415a7799;flex:1;min-width:300px}.analytics-card-header{font-size:1.2rem;font-weight:700;color:#fff;margin-bottom:10px}.analytics-chart-container{padding:10px;background:#1b263b;border-radius:8px}table{width:100%;border-collapse:collapse;margin-top:20px;background:#1b263b;box-shadow:0 4px 8px #415a7799;border-radius:8px;overflow:hidden;color:#fff}th,td{padding:12px;text-align:left;border-bottom:1px solid #415a77;color:#fff}th{background:#415a77;color:#fff}tbody tr:nth-child(even){background-color:#415a7799}tbody tr:nth-child(odd){background-color:#415a77}tbody tr:hover{background-color:#e6f7ff;color:#000;transition:background 0.3s,color .3s}h1,h2,h3,h4,h5,h6,p,span,label,td,th,canvas,.analytics-card-header{color:#fff!important}
</style>
<body>

    <div class="analytics-container">
        <?php include 'sidebar.php'; ?> <!-- Sidebar -->

        <div class="main-content">
            <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
            <p>Here is an overview of your expenses.</p>

            <div class="summary-cards d-flex flex-wrap gap-3">
                <div class="summary-card p-3 border rounded">
                    <h4>Total Expenses (This Month)</h4>
                    <p>₱<?php echo number_format($total_expenses, 2); ?></p>
                </div>
                <div class="summary-card p-3 border rounded">
                    <h4>Highest Expense Category</h4>
                    <p><?php echo htmlspecialchars($highest_category); ?></p>
                </div>
                <div class="summary-card p-3 border rounded">
                    <h4>Average Daily Expenses</h4>
                    <p>₱<?php echo number_format($avg_daily, 2); ?></p>
                </div>
                <div class="summary-card p-3 border rounded">
                    <h4>Largest Single Transaction</h4>
                    <p>₱<?php echo number_format($largest_transaction, 2); ?></p>
                </div>
            </div>

            <div class="chart-flex">
                <!-- Expense Overview Card -->
                <div class="analytics-card">
                    <div class="analytics-card-header">
                        <h4>Expense Trends</h4>
                    </div>
                    <div class="analytics-chart-container expense-trends-class">
                        <canvas id="expenseTrendChart"></canvas>
                    </div>
                </div>

                <!-- Expense Category Distribution -->
                <div class="analytics-card">
                    <div class="analytics-card-header">
                        <h4>Expense Breakdown</h4>
                    </div>
                    <div class="analytics-chart-container">
                        <canvas id="expenseCategoryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="summary-cards d-flex flex-wrap gap-3 mt-4">
                <div class="summary-card p-3 border rounded">
                    <h4>Total Transactions (This Month)</h4>
                    <p><?php echo number_format($total_transactions); ?></p>
                </div>
            </div>

        </div>

    </div>

    <!-- Pass PHP Data to JavaScript -->
    <script>
        const expenseCategories = <?php echo $categories_json; ?>;
        const expenseTotals = <?php echo $totals_json; ?>;
        const months = <?php echo $months_json; ?>;
        const monthlyTotals = <?php echo $monthly_totals_json; ?>;
    </script>

    <script src="js/analytics.js"></script> <!-- External JavaScript file -->
</body>
</html>
