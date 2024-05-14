<?php
// Guard
require_once 'avengers.php';
Guard::adminOnly();

$todaySales = Sales::getTodaySales();
$totalSales = Sales::getTotalSales();
$transactions = OrderItem::all(); // Assuming this fetches transactions with 'created_at' field
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Point of Sale System :: Sales</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <link rel="stylesheet" type="text/css" href="./css/util.css">
    <link rel="icon" href="uploads/logo-circle.png" type="image/png">

    <!-- Datatables Library -->
    <link rel="stylesheet" type="text/css" href="./css/datatable.css">
    <script src="./js/datatable.js"></script>
    <script src="./js/main.js"></script>
    <!-- Update the <script> tag for including jsPDF with async attribute -->
    <script src="https://unpkg.com/html2pdf.js/dist/html2pdf.bundle.js"></script>
</head>

<body>
    <?php require 'templates/admin_header.php' ?>

    <div class="flex">
        <?php require 'templates/admin_navbar.php' ?>
        <main>
            <div class="flex">
                <div style="flex: 2; padding: 16px;">
                    <div class="subtitle">Sales Information</div>
                    <hr />

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Today's Sales</div>
                        </div>
                        <div class="card-content">
                            <?= $todaySales ?> PHP
                        </div>
                    </div>

                    <div class="card mt-16">
                        <div class="card-header">
                            <div class="card-title">Total Sales</div>
                        </div>
                        <div class="card-content">
                            <?= $totalSales ?> PHP
                        </div>
                    </div>
                </div>
                <div style="flex: 5; padding: 16px">
                    <div class="subtitle">Transactions</div>
                    <hr />

                    <!-- Date Filter -->
                    <label for="startDate">Start Date: </label>
                    <input type="date" id="startDate" name="startDate">
                    <label for="endDate">End Date: </label>
                    <input type="date" id="endDate" name="endDate">
                    <button id="filterButton">Filter</button>
                    <button id="generatePdfButton">Generate PDF</button>
                    <br /><br />

                    <table id="transactionsTable">
                        <thead>
                            <tr>
                                <td>Product</td>
                                <td>Quantity</td>
                                <td>Price</td>
                                <td>Subtotal</td>
                                <td>Created At</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr>
                                    <td><?= $transaction->product_name ?></td>
                                    <td><?= $transaction->quantity ?></td>
                                    <td><?= $transaction->price ?></td>
                                    <td><?= $transaction->quantity * $transaction->price ?> PHP</td>
                                    <td><?= date('Y-m-d', strtotime($transaction->created_at)) ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <br />
                    <div id="filteredTransactions"></div> <!-- Empty div for the new filtered table -->
                </div>
            </div>
        </main>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize DataTable
            var dataTable = new simpleDatatables.DataTable("#transactionsTable");

            // Add event listener to the filter button
            document.getElementById('filterButton').addEventListener('click', function () {
                filterTransactions();
            });

            // Add event listener to the generate PDF button
            document.getElementById('generatePdfButton').addEventListener('click', function () {
                generatePDF();
            });

            // Function to filter transactions based on date range and create a new table
            function filterTransactions() {
                var startDate = document.getElementById('startDate').value;
                var endDate = document.getElementById('endDate').value;

                if (!startDate || !endDate) {
                    alert("Please select both start and end dates.");
                    return;
                }

                var rows = document.querySelectorAll('#transactionsTable tbody tr');
                var filteredTransactions = [];

                rows.forEach(function (row) {
                    var dateCell = row.querySelector('td:nth-child(5)');
                    var date = new Date(dateCell.textContent);

                    var start = new Date(startDate);
                    var end = new Date(endDate);

                    if (date >= start && date <= end) {
                        filteredTransactions.push({
                            product: row.querySelector('td:nth-child(1)').textContent,
                            quantity: row.querySelector('td:nth-child(2)').textContent,
                            price: row.querySelector('td:nth-child(3)').textContent,
                            subtotal: row.querySelector('td:nth-child(4)').textContent,
                            createdAt: dateCell.textContent
                        });
                    }
                });

                createFilteredTable(filteredTransactions);
            }

            // Function to create a new table with filtered transactions
            function createFilteredTable(filteredTransactions) {
                var container = document.getElementById('filteredTransactions');
                container.innerHTML = ''; // Clear previous content

                if (filteredTransactions.length === 0) {
                    container.innerHTML = '<p>No transactions found for the selected date range.</p>';
                    return;
                }

                var table = document.createElement('table');
                table.innerHTML = `
                    <thead>
                        <tr>
                            <td>Product</td>
                            <td>Quantity</td>
                            <td>Price</td>
                            <td>Subtotal</td>
                            <td>Created At</td>
                        </tr>
                    </thead>
                    <tbody>
                        ${filteredTransactions.map(transaction => `
                            <tr>
                                <td>${transaction.product}</td>
                                <td>${transaction.quantity}</td>
                                <td>${transaction.price}</td>
                                <td>${transaction.subtotal}</td>
                                <td>${transaction.createdAt}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                `;

                container.appendChild(table);
            }

            // Function to generate PDF
            function generatePDF() {
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                const generatedAt = new Date().toLocaleString();

                const filteredTransactions = document.querySelector('#filteredTransactions tbody');
                if (!filteredTransactions) {
                    alert("No transactions to generate PDF.");
                    return;
                }

                // Fetch the template
                fetch('pdf_template.html')
                    .then(response => response.text())
                    .then(template => {
                        // Create a temporary DOM element
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = template;

                        // Set date period and generated at
                        tempDiv.querySelector('#datePeriod').textContent = `${startDate} to ${endDate}`;
                        tempDiv.querySelector('#generatedAt').textContent = generatedAt;

                        // Append transactions
                        tempDiv.querySelector('#transactionsBody').innerHTML = filteredTransactions.innerHTML;

                        // Generate PDF from the template
                        html2pdf().from(tempDiv).save('sales_information.pdf');
                    })
                    .catch(error => {
                        console.error('Error fetching the PDF template:', error);
                    });
            }
        });
    </script>
</body>

</html>
