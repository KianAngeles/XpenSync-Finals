document.addEventListener("DOMContentLoaded", function () {
    // Ensure the modal is hidden on page load
    document.getElementById("edit-modal").style.display = "none";

    // Get filter elements
    const filterBtn = document.getElementById("filter-btn");
    const startDateInput = document.getElementById("start-date");
    const endDateInput = document.getElementById("end-date");
    const categoryFilter = document.getElementById("category-filter");
    const expenseRows = document.querySelectorAll("#expensesTable tbody tr");

    // Filter function
    function filterExpenses() {
        let startDate = startDateInput.value;
        let endDate = endDateInput.value;
        let selectedCategory = categoryFilter.value;

        expenseRows.forEach(row => {
            let date = row.children[0].textContent.trim(); // Get Date from column
            let category = row.children[1].textContent.trim(); // Get Category from column

            let showRow = true;

            // Check date range filter
            if (startDate && date < startDate) {
                showRow = false;
            }
            if (endDate && date > endDate) {
                showRow = false;
            }

            // Check category filter
            if (selectedCategory && category !== selectedCategory) {
                showRow = false;
            }

            // Show or hide row based on conditions
            row.style.display = showRow ? "" : "none";
        });
    }

    // Attach filter function to button click
    filterBtn.addEventListener("click", filterExpenses);
});

// Function to open the edit modal
function openEditModal(id, date, category, description, amount, type) {
    document.getElementById("edit-id").value = id;
    document.getElementById("edit-date").value = date;
    document.getElementById("edit-description").value = description;
    document.getElementById("edit-amount").value = amount;
    document.getElementById("edit-type").value = type;

    let categoryDropdown = document.getElementById("edit-category");

    // Check if the category exists in the dropdown
    let categoryExists = false;
    for (let option of categoryDropdown.options) {
        if (option.value.trim().toLowerCase() === category.trim().toLowerCase()) {
            categoryDropdown.value = option.value;
            categoryExists = true;
            break;
        }
    }

    // If category is not found, add it to the dropdown
    if (!categoryExists) {
        let newOption = document.createElement("option");
        newOption.value = category;
        newOption.textContent = category;
        newOption.selected = true;
        categoryDropdown.appendChild(newOption);
    }

    // Show the modal
    let modal = document.getElementById("edit-modal");
    modal.style.display = "flex"; 
}

function validateForm() {
    let id = document.getElementById("edit-id").value;
    let dateLent = document.getElementById("edit-date").value;
    let description = document.getElementById("edit-description").value;
    let amount = document.getElementById("edit-amount").value;
    let borrower = document.getElementById("edit-borrower").value;
    let dueDate = document.getElementById("edit-due-date").value;
    let status = document.getElementById("edit-status").value;

    if (!id || !dateLent || !description || !amount || !borrower || !dueDate || !status) {
        alert("Please fill out all fields before submitting.");
        return false;
    }
    return true;
}

// Function to close the edit modal
function closeEditModal() {
    document.getElementById("edit-modal").style.display = "none";

}
