<?php
session_start();
include 'database.php';

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
$user_name = $_SESSION['name'] ?? 'Guest';

// Fetch categories for filtering
$categories = [];
$category_query = "SELECT name FROM categories";
$stmt = $db->prepare($category_query);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['name'];
}
$stmt->close();

// Fetch all expenses for the user
$query = "SELECT id, date, category, description, amount, type FROM expenses WHERE user_id = ? ORDER BY date DESC";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$expenses = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Expenses</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <link href="css/mediaquery.css" rel="stylesheet" type="text/css" >
    <script defer src="js/manage_expenses.js"></script>
</head>
<style>
    body{background:#0d1b2a;color:#fff}.main-content{background:#1b263b}h1,h2,h3{color:#e0e1dd}.action-btn{background:#415a77;color:#fff;transition:transform 0.3s,box-shadow .3s}.action-btn:hover{transform:scale(1.1);box-shadow:0 5px 15px #415a7799}.expense-card{background:#25374a;border:2px solid #415a77;box-shadow:0 4px 8px #415a7799;transition:transform 0.3s,box-shadow .3s}.expense-card:hover{transform:translateY(-5px);box-shadow:0 5px 15px #415a77cc}.amount{color:#e0e1dd}.recent-transactions{background:#1b263b;border-radius:8px;padding:10px;box-shadow:0 4px 8px #415a7799}#expensesTable th{background:#415a77;color:#fff}#expensesTable tbody tr:nth-child(even){background-color:#415a77}#expensesTable tbody tr:nth-child(odd){background-color:#415a7799}#expensesTable tbody tr:hover{background-color:#e6f7ff;color:#000}.edit-btn{background:#415a77;color:#fff;border:none;padding:5px 10px;cursor:pointer;border-radius:5px;transition:background 0.3s,transform .2s}.edit-btn:hover{background:#2f4863;transform:scale(1.05)}.delete-btn{background:#d9534f;color:#fff;border:none;padding:5px 10px;cursor:pointer;border-radius:5px;transition:background 0.3s,transform .2s}.delete-btn:hover{background:#c9302c;transform:scale(1.05)}.filters{display:flex;gap:10px;margin-bottom:15px}.filters label{color:#e0e1dd}.filters input,.filters select{background:#25374a;border:1px solid #415a77;color:#fff;padding:5px;border-radius:5px}.filters button{background:#415a77;color:#fff;border:none;padding:5px 10px;cursor:pointer;border-radius:5px;transition:background .3s}.filters button:hover{background:#2f4863}#expenseSearch{width:100%;padding:10px;font-size:16px;border:2px solid #415a77;border-radius:8px;background:#25374a;color:#fff;outline:none;transition:all .3s ease-in-out}#expenseSearch::placeholder{color:#a0a9b8;opacity:.8}#expenseSearch:focus{border-color:#2f4863;box-shadow:0 0 8px #415a77cc}.modal{background:#000000b3}.modal-content{background:#1d2e46;color:#fff;border-radius:8px;padding:20px}.modal-content input,.modal-content select{background:#25374a;color:#fff;border:1px solid #415a77;padding:5px;border-radius:5px}.modal-content button{background:#415a77;color:#fff;border:none;padding:8px 12px;cursor:pointer;border-radius:5px;transition:background .3s}.modal-content button:hover{background:#2f4863}.edit-btn{background:#04c101;color:#fff}.edit-btn:hover{background:#04c101}.modal-content h2{color:#fff}
</style>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        <div class="main-content">
            <h1>Manage Expenses</h1>
            <div class="filters">
                <label for="start-date">Start Date:</label>
                <input type="date" id="start-date" placeholder="Start Date">
                
                <label for="end-date">End Date:</label>
                <input type="date" id="end-date" placeholder="End Date">
                
                <label for="category-filter">Category:</label>
                <select id="category-filter">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                    <?php endforeach; ?>
                </select>
                
                <button id="filter-btn">Filter</button>
            </div>
            
            <h3>Search Expenses</h3>
            <input type="text" id="expenseSearch" placeholder="Search transactions..." />
            <div class="table-container">
                <table id="expensesTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $expenses->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['category']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td>₱<?php echo number_format($row['amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars($row['type']); ?></td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="edit-btn" onclick="openEditModal(
                                        '<?php echo $row['id']; ?>',
                                        '<?php echo $row['date']; ?>',
                                        '<?php echo $row['category']; ?>',
                                        '<?php echo $row['description']; ?>',
                                        '<?php echo $row['amount']; ?>',
                                        '<?php echo $row['type']; ?>'
                                    )">Edit</button>

                                    <!-- Delete Form -->
                                    <form action="delete_expense.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button class="delete-btn" type="submit" onclick="return confirm('Are you sure you want to delete this expense?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Expense</h2>
            <form id="edit-form" action="update_expense.php" method="POST">
                <input type="hidden" id="edit-id" name="id">

                <!-- Date -->
                <label for="edit-date">Date:</label>
                <input type="date" id="edit-date" name="date">

                <!-- Category Dropdown -->
                <label for="edit-category">Category:</label>
                <select id="edit-category" name="category">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                    <?php endforeach; ?>
                </select>


                <!-- Description -->
                <label for="edit-description">Description:</label>
                <input type="text" id="edit-description" name="description">

                <!-- Amount -->
                <label for="edit-amount">Amount:</label>
                <input type="number" id="edit-amount" name="amount" step="0.01">

                <!-- Type Dropdown (Income / Expense) -->
                <label for="edit-type">Type:</label>
                <select id="edit-type" name="type">
                    <option value="Income">Income</option>
                    <option value="Expense">Expense</option>
                </select>

                <!-- Submit Button -->
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, date, category, description, amount, type) {
        document.getElementById("edit-id").value = id;
        document.getElementById("edit-date").value = date;
        document.getElementById("edit-category").value = category;
        document.getElementById("edit-description").value = description;
        document.getElementById("edit-amount").value = amount;
        document.getElementById("edit-type").value = type;

        let modal = document.getElementById("edit-modal");
        modal.style.display = "flex"; 
    }

    function closeEditModal() {
        document.getElementById("edit-modal").style.display = "none";
    }

    </script>
    <script src="js/manage_expenses.js"></script>
    <script src="js/searchbar.js"></script>
</body>
</html>
