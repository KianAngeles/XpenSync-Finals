<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// Fetch username
$user_name = $_SESSION['name'] ?? 'Guest';
include 'database.php'; 

$user_id = $_SESSION['id']; 
$category1 = $_POST['category1'] ?? '';
$category2 = $_POST['category2'] ?? '';
$start_date = $_POST['start_date'] ?? '';
$end_date = $_POST['end_date'] ?? '';

$expenses1 = [];
$expenses2 = [];
$total1 = array_sum(array_column($expenses1, 'amount'));
$total2 = array_sum(array_column($expenses2, 'amount'));

if ($category1 && $category2 && $start_date && $end_date) {
    $query = "SELECT category, date, amount, description FROM expenses 
          WHERE user_id = ? AND category = ? AND date BETWEEN ? AND ? 
          ORDER BY date ASC";
    
    // Fetch expenses for Category 1
    $stmt = $db->prepare($query);
    $stmt->bind_param("isss", $user_id, $category1, $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $expenses1[] = $row;
    }
    
    // Fetch expenses for Category 2
    $stmt = $db->prepare($query);
    $stmt->bind_param("isss", $user_id, $category2, $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $expenses2[] = $row;
    }
}

// Fetch categories for dropdown
$category_query = "SELECT DISTINCT category FROM expenses WHERE user_id = ?";
$stmt_category = $db->prepare($category_query);
$stmt_category->bind_param("i", $user_id);
$stmt_category->execute();
$category_result = $stmt_category->get_result();

// Fetch all categories with their total amounts
$all_categories_query = "SELECT category, SUM(amount) as total_amount FROM expenses WHERE user_id = ? GROUP BY category";
$stmt_all_categories = $db->prepare($all_categories_query);
$stmt_all_categories->bind_param("i", $user_id);
$stmt_all_categories->execute();
$all_categories_result = $stmt_all_categories->get_result();

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Expenses</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="css/mediaquery.css" rel="stylesheet" type="text/css" >
</head>
<style>
    body{background:#0d1b2a;color:#fff}.container{display:flex}.main-content{background:#1b263b;padding:20px;border-radius:8px;box-shadow:0 4px 8px #415a7799}h1,h2,h3{color:#e0e1dd}.compare-expenses-form{background:#1b263b;padding:15px;border-radius:8px;box-shadow:0 4px 8px #415a7799}.compare-expenses-form .form-group{margin-bottom:10px}.compare-expenses-form label{font-weight:700;color:#fff}.compare-expenses-form select,.compare-expenses-form input{background:#25374a;color:#e0e1dd;border:1px solid #415a77;padding:8px;border-radius:5px}.compare-expenses-form button{background:#415a77;color:#fff;padding:10px 15px;border:none;border-radius:5px;transition:transform 0.3s,box-shadow .3s}.compare-expenses-form button:hover{transform:scale(1.1);box-shadow:0 5px 15px #415a7799}.all-categories-table,.compare-expenses-table{width:100%;border-collapse:collapse;margin-top:20px;background:#1b263b;box-shadow:0 4px 8px #415a7799;border-radius:8px;overflow:hidden}.all-categories-table th,.compare-expenses-table th{background:#415a77;color:#fff;padding:12px;text-align:left}.all-categories-table td,.compare-expenses-table td{padding:12px;text-align:left;border-bottom:1px solid #415a77}.compare-expenses-table tbody tr:nth-child(even),.all-categories-table tbody tr:nth-child(even){background-color:#415a77}.compare-expenses-table tbody tr:nth-child(odd),.all-categories-table tbody tr:nth-child(odd){background-color:#415a7799}.compare-expenses-table tbody tr:hover,.all-categories-table tbody tr:hover{background-color:#e6f7ff;color:#000;transition:background 0.3s,color .3s}.comparison-tables{display:flex;gap:20px;justify-content:space-between;flex-wrap:wrap}.compare-expenses-table{flex:1}
</style>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        <div class="main-content">
            <h2>Compare Expenses</h2>

            <h3>All Categories and Total Amounts</h3>
            <table class="all-categories-table" >
                <tr>
                    <th>Category</th>
                    <th>Total Amount</th>
                </tr>
                <?php while ($row = $all_categories_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td>₱<?= number_format($row['total_amount'], 2) ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <form method="POST" class="compare-expenses-form">
                <div class="form-group">
                    <label for="category1">Category 1:</label>
                    <select name="category1" required>
                        <option value="">Select Category</option>
                        <?php while ($row = $category_result->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['category']) ?>" 
                            <?= ($category1 == $row['category']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['category']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="category2">Category 2:</label>
                    <select name="category2" required>
                        <option value="">Select Category</option>
                        <?php 
                        $category_result->data_seek(0);
                        while ($row = $category_result->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['category']) ?>" 
                            <?= ($category2 == $row['category']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['category']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" value="<?= $start_date ?>" required>
                </div>

                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" value="<?= $end_date ?>" required>
                </div>

                <button type="submit">Compare</button>
            </form>

            <?php if (!empty($expenses1) && !empty($expenses2)): ?>
                <h3>Comparison Results</h3>
                <div class="comparison-tables">
                <table class="compare-expenses-table">
                    <tr>
                        <th colspan="3"><?= htmlspecialchars($category1) ?></th>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                    <?php foreach ($expenses1 as $expense): ?>
                        <tr>
                            <td><?= $expense['date'] ?></td>
                            <td><?= htmlspecialchars($expense['description']) ?></td>
                            <td>₱<?= number_format($expense['amount'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <table class="compare-expenses-table">
                    <tr>
                        <th colspan="3"><?= htmlspecialchars($category2) ?></th>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                    <?php foreach ($expenses2 as $expense): ?>
                        <tr>
                            <td><?= $expense['date'] ?></td>
                            <td><?= htmlspecialchars($expense['description']) ?></td>
                            <td>₱<?= number_format($expense['amount'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
