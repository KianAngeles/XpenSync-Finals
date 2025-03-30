document.addEventListener("DOMContentLoaded", function () {
    // Ensure the modal is hidden on page load
    document.getElementById("edit-modal").style.display = "none";

    // Get filter elements
    const filterBtn = document.getElementById("filter-btn");
    const statusFilter = document.getElementById("status");
    const amountSort = document.getElementById("amount-sort");
    const lendingRows = document.querySelectorAll("#lendingTable tbody tr");

    // Filter function
    function filterLendingRecords() {
        let selectedStatus = statusFilter.value;
        let sortOrder = amountSort.value;
        let rowsArray = Array.from(lendingRows);

        rowsArray.forEach(row => {
            let status = row.children[5].textContent.trim(); // Get Status from column
            let showRow = true;

            // Check status filter
            if (selectedStatus && status !== selectedStatus) {
                showRow = false;
            }

            row.style.display = showRow ? "" : "none";
        });

        // Sort by amount
        if (sortOrder) {
            rowsArray.sort((a, b) => {
                let amountA = a.children[2].textContent.replace(/[^0-9.]/g, ""); // Remove non-numeric characters
                let amountB = b.children[2].textContent.replace(/[^0-9.]/g, ""); // Remove non-numeric characters
        
                amountA = parseFloat(amountA) || 0;
                amountB = parseFloat(amountB) || 0;
        
                return sortOrder === "desc" ? amountA - amountB : amountB - amountA;
            });
        
            let tbody = document.querySelector("#lendingTable tbody");
            tbody.innerHTML = ""; // Clear table
            rowsArray.forEach(row => tbody.appendChild(row)); // Append sorted rows
        }
    }

    // Attach filter function to button click
    filterBtn.addEventListener("click", filterLendingRecords);
});

// Function to open the edit modal
function openEditModal(id, date_lent, description, amount, borrower, due_date, status) {
    document.getElementById("edit-id").value = id;
    document.getElementById("edit-date").value = date_lent;
    document.getElementById("edit-description").value = description;
    document.getElementById("edit-amount").value = amount;
    document.getElementById("edit-borrower").value = borrower;
    document.getElementById("edit-due-date").value = due_date;
    document.getElementById("edit-status").value = status;

    // Show the modal
    document.getElementById("edit-modal").style.display = "flex"; 
}

// Function to close the edit modal
function closeEditModal() {
    document.getElementById("edit-modal").style.display = "none";
}
