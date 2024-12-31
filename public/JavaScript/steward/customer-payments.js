document.addEventListener("DOMContentLoaded", () => {
    // Sample data array
    const paymentsData = [
        { orderId: "#1001", time: "18:30", customerName: "Thirani Imanya", totalAmount: "$45.00", paymentMethod: "Cash", tableNo: "02", status: "Pending", isReadyToPay: true },
        { orderId: "#1002", time: "21:20", customerName: "Abdul Raheem", totalAmount: "$60.00", paymentMethod: "Cash", tableNo: "04", status: "Pending", isReadyToPay: true },
        { orderId: "#1003", time: "19:00", customerName: "Gihan Perera", totalAmount: "$25.00", paymentMethod: "-", tableNo: "01", status: "Pending", isReadyToPay: false },
        { orderId: "#1004", time: "20:15", customerName: "Kevin Silva", totalAmount: "$60.00", paymentMethod: "Cash", tableNo: "02", status: "Completed", isReadyToPay: true },
        { orderId: "#1005", time: "17:45", customerName: "Jehan Fonseka", totalAmount: "$30.00", paymentMethod: "Card", tableNo: "03", status: "Completed", isReadyToPay: true }
    ];

    const mainContent = document.getElementById("main-content");

    function renderCustomerPayments() {
        const currentDate = new Date().toISOString().slice(0, 10);
        
        mainContent.innerHTML = `
            <div class="customer-payment-section">
                <div class="payment-header">
                    <h2>Customer Payments</h2>
                    <span>${currentDate}</span>
                </div>
                <div class="filter-section">
                    <input type="text" id="tableFilter" placeholder="Filter by Table No...">
                    <button onclick="filterPayments()">Filter</button>
                    <button onclick="resetFilter()">Reset</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Time</th>
                            <th>Customer Name</th>
                            <th>Total Amount</th>
                            <th>Payment Method</th>
                            <th>Table No.</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="payment-table-body">
                    </tbody>
                </table>
            </div>`;

        populatePaymentsTable(paymentsData);
        addEventListeners();
    }

    function populatePaymentsTable(data) {
        const tableBody = document.getElementById("payment-table-body");
        tableBody.innerHTML = ''; // Clear existing content

        data.forEach(payment => {
            const row = document.createElement("tr");
            const statusColor = payment.status === "Completed" ? "green" : "red";
            row.innerHTML = `
                <td>${payment.orderId}</td>
                <td>${payment.time}</td>
                <td>${payment.customerName}</td>
                <td>${payment.totalAmount}</td>
                <td>${payment.paymentMethod}</td>
                <td>${payment.tableNo}</td>
                <td style="color: ${statusColor};">${payment.status}</td>
                <td>
                    ${payment.status === "Pending" && payment.isReadyToPay
                        ? `<button class="confirm-btn" data-order="${payment.orderId}">Confirm</button>`
                        : ""}
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    function addEventListeners() {
        // Handle confirm button clicks
        document.querySelectorAll('.confirm-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const orderId = e.target.dataset.order;
                handlePaymentConfirmation(orderId, e.target.closest('tr'));
            });
        });
    }

    function handlePaymentConfirmation(orderId, row) {
        // Here you would typically make an API call to confirm the payment
        console.log(`Confirming payment for order ${orderId}`);

        // Update the row to show completed status
        row.querySelector('td:nth-child(7)').innerHTML = `<span style="color: green;">Completed</span>`;
        row.querySelector('td:last-child').innerHTML = ''; // Remove confirm button

        // Update the data
        const payment = paymentsData.find(p => p.orderId === orderId);
        if (payment) {
            payment.status = "Completed";
        }
    }

    // Filter payments by table number
    window.filterPayments = function() {
        const filterValue = document.getElementById("tableFilter").value;
        const filteredPayments = paymentsData.filter(payment => 
            payment.tableNo.includes(filterValue)
        );
        populatePaymentsTable(filteredPayments);
    };

    // Reset filter
    window.resetFilter = function() {
        document.getElementById("tableFilter").value = '';
        populatePaymentsTable(paymentsData);
    };

    // Calculate daily totals
    function calculateDailyTotals() {
        const completedPayments = paymentsData.filter(payment => payment.status === "Completed");
        const totalAmount = completedPayments.reduce((sum, payment) => {
            const amount = parseFloat(payment.totalAmount.replace('$', ''));
            return sum + amount;
        }, 0);
        
        const cashPayments = completedPayments.filter(payment => payment.paymentMethod === "Cash");
        const cardPayments = completedPayments.filter(payment => payment.paymentMethod === "Card");

        return {
            totalAmount: totalAmount.toFixed(2),
            cashCount: cashPayments.length,
            cardCount: cardPayments.length
        };
    }

    // Initial render
    renderCustomerPayments();

    // You might want to add a function to update the view periodically
    // Uncomment the following line if you want auto-refresh every 5 minutes
    // setInterval(renderCustomerPayments, 300000);
});