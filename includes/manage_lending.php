<?php
session_start();
include 'database.php';

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
$user_name = $_SESSION['name'] ?? 'Guest';

// Fetch all lending records for the user
$query = "SELECT id, date_lent, description, amount, borrower, due_date, status FROM lending WHERE user_id = ? ORDER BY date_lent DESC";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$lending_records = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Lending</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <link href="css/mediaquery.css" rel="stylesheet" type="text/css" >
    <script defer src="js/manage_lending.js"></script>
</head>
<style>
    body{background:#0d1b2a;color:#fff}.main-content{background:#1b263b}h1,h2,h3{color:#e0e1dd}.edit-btn{background:#04c101;color:#fff;border:none;padding:5px 10px;cursor:pointer;border-radius:5px;transition:background 0.3s,transform .2s}.edit-btn:hover{background:#04c101;transform:scale(1.05)}.delete-btn{background:#d9534f;color:#fff;border:none;padding:5px 10px;cursor:pointer;border-radius:5px;transition:background 0.3s,transform .2s}.delete-btn:hover{background:#c9302c;transform:scale(1.05)}.filters{display:flex;gap:10px;margin-bottom:15px}.filters label{color:#e0e1dd}.filters input,.filters select{background:#25374a;border:1px solid #415a77;color:#fff;padding:5px;border-radius:5px}.filters button{background:#415a77;color:#fff;border:none;padding:5px 10px;cursor:pointer;border-radius:5px;transition:background .3s}.filters button:hover{background:#2f4863}#lendingTable{width:100%;border-collapse:collapse}#lendingTable th{background:#415a77;color:#fff;padding:10px}#lendingTable tbody tr:nth-child(even){background-color:#415a77}#lendingTable tbody tr:nth-child(odd){background-color:#415a7799}#lendingTable tbody tr:hover{background-color:#e6f7ff;color:#000}#lendingSearch{width:100%;padding:10px;font-size:16px;border:2px solid #415a77;border-radius:8px;background:#25374a;color:#fff;outline:none;transition:all .3s ease-in-out}#lendingSearch::placeholder{color:#a0a9b8;opacity:.8}#lendingSearch:focus{border-color:#2f4863;box-shadow:0 0 8px #415a77cc}.modal{background:#000000b3}.modal-content{background:#1d2e46;color:#fff;border-radius:8px;padding:20px}.modal-content h2{color:#fff}.modal-content input,.modal-content select{background:#25374a;color:#fff;border:1px solid #415a77;padding:5px;border-radius:5px}.modal-content button{background:#415a77;color:#fff;border:none;padding:8px 12px;cursor:pointer;border-radius:5px;transition:background .3s}.modal-content button:hover{background:#2f4863}
</style>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        <div class="main-content">
            <h1>Manage Lending</h1>
                <div class="filters">
                    <label for="status">Status:</label>
                    <select id="status">
                        <option value="">All</option>
                        <option value="Pending">Pending</option>
                        <option value="Paid">Paid</option>
                    </select>

                    <label for="amount-sort">Sort Amount:</label>
                    <select id="amount-sort">
                        <option value="">None</option>
                        <option value="asc">Increasing</option>
                        <option value="desc">Decreasing</option>
                    </select>
                    
                    <button id="filter-btn">Filter</button>
                </div>

            
            <h3>Search Lending Records</h3>
            <input type="text" id="lendingSearch" placeholder="Search transactions..." />
            <table id="lendingTable">
                <thead>
                    <tr>
                        <th>Borrower</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Date Lent</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $lending_records->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['borrower']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td>₱<?php echo number_format($row['amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['date_lent']); ?></td>
                            <td><?php echo htmlspecialchars($row['due_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <button class="edit-btn" onclick="openEditModal(
                                    '<?php echo $row['id']; ?>',
                                    '<?php echo $row['date_lent']; ?>',
                                    '<?php echo $row['description']; ?>',
                                    '<?php echo $row['amount']; ?>',
                                    '<?php echo $row['borrower']; ?>',
                                    '<?php echo $row['due_date']; ?>',
                                    '<?php echo $row['status']; ?>'
                                )">Edit</button>

                                <form action="delete_lending.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button class="delete-btn" type="submit" onclick="return confirm('Are you sure you want to delete this lending record?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Lending Record</h2>
            <form id="edit-form" action="update_lending.php" method="POST">
                <input type="hidden" id="edit-id" name="id">
                <label for="edit-borrower">Borrower:</label>
                <input type="text" id="edit-borrower" name="borrower">
                <label for="edit-description">Description:</label>
                <input type="text" id="edit-description" name="description">
                <label for="edit-amount">Amount:</label>
                <input type="number" id="edit-amount" name="amount" step="0.01">
                <label for="edit-date">Date Lent:</label>
                <input type="date" id="edit-date" name="date_lent">
                <label for="edit-due-date">Due Date:</label>
                <input type="date" id="edit-due-date" name="due_date">
                <label for="edit-status">Status:</label>
                <select id="edit-status" name="status">
                    <option value="Pending">Pending</option>
                    <option value="Paid">Paid</option>
                </select>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, borrower, description, amount, date_lent, due_date, status) {
            document.getElementById("edit-id").value = id;
            document.getElementById("edit-borrower").value = borrower;
            document.getElementById("edit-description").value = description;
            document.getElementById("edit-amount").value = amount;
            document.getElementById("edit-date").value = date_lent;
            document.getElementById("edit-due-date").value = due_date;
            document.getElementById("edit-status").value = status;
            document.getElementById("edit-modal").style.display = "flex"; 
        }

        function closeEditModal() {
            document.getElementById("edit-modal").style.display = "none";
        }
    </script>
    <script src="js/manage_lending.js"></script>
    <script src="js/searchbar.js"></script>
</body>
</html>
