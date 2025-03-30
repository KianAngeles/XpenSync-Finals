<?php
$user_name = $_SESSION['name'] ?? 'Guest';
$profile_picture = $_SESSION['profile_picture'] ?? 'images/xpens_pfp.png';
?>

<!-- Sidebar -->
<div class="sidebar">
    <div class="user-info">
        <img class="sidebar-pfp" src="<?= $profile_picture; ?>" alt="Profile Picture" id="profileImage">
        <p class="username-style"><strong><?php echo htmlspecialchars($user_name); ?></strong></p>
        <p class="status">ONLINE</p>
    </div>

    <ul class="menu">
        <li><a href="home.php">⚙️  Dashboard</a></li>

        <li class="has-submenu">
            <a href="#" class="menu-title">📂 Expenses </a>
            <ul class="submenu">
                <li><a href="addexpenses.php">➜ Add Expenses</a></li>
                <li><a href="manage_expenses.php">➜ Manage Expenses</a></li>
            </ul>
        </li>

        <li class="has-submenu">
            <a href="#" class="menu-title">⛃  Lending</a>
            <ul class="submenu">
                <li><a href="addlending.php">➜ Add Lending</a></li>
                <li><a href="manage_lending.php">➜ Manage Lending</a></li>
            </ul>
        </li>

        <li><a href="compare_expense.php">⚖️    Compare Expenses</a></li>
        <li><a href="analytics.php">📶   Analytics</a></li>
        <li><a href="profile.php">👤   Profile</a></li>
    </ul>
    <div class="logout-btn">
        <a href="logout.php">Logout</a>
    </div>

</div>

<header class="mobile-header">
    <button class="hamburger" id="mobile-hamburger" onclick="toggleSidebar()">☰</button>
    <h1><a class="header-title" href="home.php">XpenSync</a></h1>
</header>



<!-- JavaScript to Enable Click-to-Show Submenus -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const submenuItems = document.querySelectorAll(".has-submenu");

    submenuItems.forEach((item) => {
        const menuTitle = item.querySelector(".menu-title");

        menuTitle.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent the default anchor behavior

            // Toggle the 'active' class to show/hide submenu
            item.classList.toggle("active");

            // Close other open submenus (optional)
            submenuItems.forEach((otherItem) => {
                if (otherItem !== item) {
                    otherItem.classList.remove("active");
                }
            });
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const hamburger = document.getElementById("mobile-hamburger"); // Ensure this ID exists
    const submenuTitles = document.querySelectorAll(".menu-title");

    // Function to toggle sidebar visibility
    function toggleSidebar() {
        sidebar.classList.toggle("mobile-show");

        if (sidebar.classList.contains("mobile-show")) {
            document.addEventListener("click", closeSidebarOnClickOutside);
        } else {
            document.removeEventListener("click", closeSidebarOnClickOutside);
        }
    }

    // Function to close sidebar when clicking outside
    function closeSidebarOnClickOutside(event) {
        if (!sidebar.contains(event.target) && !hamburger.contains(event.target)) {
            sidebar.classList.remove("mobile-show");
            document.removeEventListener("click", closeSidebarOnClickOutside);
        }
    }

    // Attach event listener to hamburger icon
    if (hamburger) {
        hamburger.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevents immediate closing when toggling
            toggleSidebar();
        });
    }

    // Toggle submenu on click
    submenuTitles.forEach(item => {
        item.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default anchor behavior
            this.parentElement.classList.toggle("mobile-active");
        });
    });
});


</script>



<style>
.user-info {
    color: #e0e1dd !important; 
}

.username-style {
    color: black !important; 
    font-weight: normal !important;
}

.status {
    color: #04c101 !important;
}

</style>