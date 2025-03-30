<?php
include 'database.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = intval($_POST['id']); 

        $sql = "DELETE FROM lending WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: manage_lending.php?delete=success");
            exit();
        } else {
            header("Location: manage_lending.php?delete=error");
            exit();
        }

        $stmt->close();
        $db->close();
    }
}

header("Location: manage_lending.php?delete=invalid");
exit();
?>
