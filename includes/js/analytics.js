document.addEventListener("DOMContentLoaded", function () {
    // Expense Trend Chart (Line Chart)
    const ctx1 = document.getElementById("expenseTrendChart").getContext("2d");
    new Chart(ctx1, {
        type: "line",
        data: {
            labels: months, // Dynamic from PHP
            datasets: [{
                label: "Total Expenses",
                data: monthlyTotals, // Dynamic from PHP
                borderColor: "#C5BAFF",
                backgroundColor: "rgba(197, 186, 255, 0.5)",
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Expense Breakdown Chart (Pie Chart)
    const ctx2 = document.getElementById("expenseCategoryChart").getContext("2d");
    new Chart(ctx2, {
        type: "pie",
        data: {
            labels: expenseCategories, // Dynamic from PHP
            datasets: [{
                data: expenseTotals, // Dynamic from PHP
                backgroundColor: ["#E8F9FF", "#C4D9FF", "#C5BAFF", "#FF9AA2", "#F8B400", "#91C483", "#28A745", "#6F42C1"]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
