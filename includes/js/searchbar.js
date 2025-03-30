document.addEventListener("DOMContentLoaded", function () {
    function setupSearch(inputId, tableId) {
        let searchInput = document.getElementById(inputId);
        if (searchInput) {
            searchInput.addEventListener("keyup", function () {
                let searchQuery = this.value.toLowerCase();
                let rows = document.querySelectorAll(`#${tableId} tbody tr`);

                rows.forEach(row => {
                    let rowText = row.textContent.toLowerCase();
                    row.style.display = rowText.includes(searchQuery) ? "" : "none";
                });
            });
        }
    }

    // Apply search to both pages
    setupSearch("expenseSearch", "expensesTable"); // For Manage Expenses
    setupSearch("lendingSearch", "lendingTable");  // For Lending Management
});
