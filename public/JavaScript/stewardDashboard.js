document.addEventListener("DOMContentLoaded", () => {
    // Sample data arrays
    const orderStatusData = [
        { orderId: "097", name: "John Doe", order: "Prawns Dolphin Kottu", tableNo: "04", status: "Ready" },
        { orderId: "101", name: "Michael Brown", order: "Sea Food Kottu", tableNo: "02", status: "Ready" },
        { orderId: "097", name: "Jane Smith", order: "Chicken Cheese Kottu", tableNo: "04", status: "Processing" },
        { orderId: "102", name: "Linda Lee", order: "Mutton String Hopper Kottu", tableNo: "03", status: "Processing" },
        { orderId: "102", name: "Linda Lee", order: "2L Coca Cola Bottle", tableNo: "03", status: "Processing" }
    ];

    const arrivalsData = [
        { reservationNo: "R001", time: "19:00", heads: "4", bookedBy: "John Doe", tableNumber: "12", arrived: "YES" },
        { reservationNo: "R002", time: "20:30", heads: "2", bookedBy: "Jane Smith", tableNumber: "5", arrived: "YES"  },
        { reservationNo: "R003", time: "18:45", heads: "6", bookedBy: "Michael Brown", tableNumber: "8", arrived: "NO"  },
        { reservationNo: "R004", time: "21:00", heads: "3", bookedBy: "Linda Lee", tableNumber: "3", arrived: "NO"  }
    ];

    const paymentsData = [
        { orderId: "#1001", time: "18:30", customerName: "John Doe", totalAmount: "$45.00", paymentMethod: "Cash", tableNo: "02", status: "Pending", isReadyToPay: true },
        { orderId: "#1002", time: "21:20", customerName: "Tom Starc", totalAmount: "$60.00", paymentMethod: "Cash", tableNo: "04", status: "Pending", isReadyToPay: true },
        { orderId: "#1003", time: "19:00", customerName: "Jane Smith", totalAmount: "$25.00", paymentMethod: "-", tableNo: "01", status: "Pending", isReadyToPay: false },
        { orderId: "#1004", time: "20:15", customerName: "Michael Brown", totalAmount: "$60.00", paymentMethod: "Cash", tableNo: "02", status: "Completed", isReadyToPay: true },
        { orderId: "#1005", time: "17:45", customerName: "Linda Lee", totalAmount: "$30.00", paymentMethod: "Card", tableNo: "03", status: "Completed", isReadyToPay: true }
    ];

    //select table for cusstomer arrivals
    const availableTables = Array.from({length: 8}, (_, i) => (i + 1).toString().padStart(2, '0')); 
    
    // Select all sidebar list items
    const sidebarOptions = document.querySelectorAll(".sidebar ul li");
    const mainContent = document.getElementById("main-content");

    // Default selection to "view-order-status"
    const defaultOption = document.getElementById("view-order-status");
    defaultOption.classList.add("selected");
    
    // Render default content for "view-order-status"
    mainContent.innerHTML = `
        <div class="view-users-section">
            <h2>Order Status</h2>
            <div class="filter-section">
                <input type="text" id="tableFilter" placeholder="Filter by Table No...">
                <button onclick="filterOrders()">Filter</button>
                <button onclick="resetFilter()">Reset</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Name</th>
                        <th>Order</th>
                        <th>Table No.</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="order-status-body">
                </tbody>
            </table>
        </div>`;

    // Populate default content
    const defaultTableBody = document.getElementById("order-status-body");
    orderStatusData.forEach(order => {
        const row = document.createElement("tr");
        const statusColor = order.status === "Ready" ? "green" : "red";
        row.innerHTML = `
            <td>${order.orderId}</td>
            <td>${order.name}</td>
            <td>${order.order}</td>
            <td>${order.tableNo}</td>
            <td style="color: ${statusColor};">${order.status}</td>
            <td>
                ${order.status === "Ready" ? '<button class="done-btn">Done</button>' : ''}
            </td>
        `;
        defaultTableBody.appendChild(row);
    });

    // Event listener for each sidebar option
    sidebarOptions.forEach(option => {
        option.addEventListener("click", () => {
            // Remove 'selected' class from all options
            sidebarOptions.forEach(opt => opt.classList.remove("selected"));
            // Add 'selected' class to the clicked option
            option.classList.add("selected");

            // Render appropriate content
            const optionId = option.id;

            switch (optionId) {
                case "view-order-status":
                    mainContent.innerHTML = `
                        <div class="view-users-section">
                            <h2>Order Status</h2>
                            <div class="filter-section">
                                <input type="text" id="tableFilter" placeholder="Filter by Table No...">
                                <button onclick="filterOrders()">Filter</button>
                                <button onclick="resetFilter()">Reset</button>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Name</th>
                                        <th>Order</th>
                                        <th>Table No.</th>
                                        <th>Status</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody id="order-status-body">
                                </tbody>
                            </table>
                        </div>`;

                    const orderStatusBody = document.getElementById("order-status-body");
                    orderStatusData.forEach(order => {
                        const row = document.createElement("tr");
                        const statusColor = order.status === "Ready" ? "green" : "red";
                        row.innerHTML = `
                            <td>${order.orderId}</td>
                            <td>${order.name}</td>
                            <td>${order.order}</td>
                            <td>${order.tableNo}</td>
                            <td style="color: ${statusColor};">${order.status}</td>
                            <td>
                                ${order.status === "Ready" ? '<button class="done-btn">Done</button>' : ''}
                            </td>
                        `;
                        orderStatusBody.appendChild(row);
                    });
                    break;

                case "customer-arrivals":
                    mainContent.innerHTML = `
                        <div class="customer-arrivals-section">
                            <h2>Customer Arrivals</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Reservation No.</th>
                                        <th>Time</th>
                                        <th>No. of Heads</th>
                                        <th>Booked By</th>
                                        <th>Table Number</th>
                                        <th>Arrived</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody id="arrivals-body">
                                </tbody>
                            </table>
                        </div>`;

                    const arrivalsBody = document.getElementById("arrivals-body");
                    arrivalsData.forEach(arrival => {
                        const row = document.createElement("tr");
                        const arrivalColor = arrival.arrived === "YES" ? "green" : "red";
                        row.innerHTML = `
                            <td>${arrival.reservationNo}</td>
                            <td>${arrival.time}</td>
                            <td>${arrival.heads}</td>
                            <td>${arrival.bookedBy}</td>
                            <td>
                                <select class="table-select" data-reservation="${arrival.reservationNo}">
                                    <option value="">Select Table</option>
                                    ${availableTables.map(table => 
                                        `<option value="${table}" ${arrival.tableNumber === table ? 'selected' : ''}>
                                            ${table}
                                        </option>`
                                    ).join('')}
                                </select>
                            </td>
                            <td style="color: ${arrivalColor};">${arrival.arrived}</td>
                            <td>
                                ${arrival.arrived === "YES" ? 
                                    '<button class="confirm-btn">Confirm</button>' : 
                                    '<button class="delete-btn">Delete</button>'}
                            </td>
                        `;
                        arrivalsBody.appendChild(row);
                    });
                    break;

                case "customer-payments":
                    const currentDate = new Date().toISOString().slice(0, 10);
                    mainContent.innerHTML = `
                        <div class="customer-payment-section">
                            <div>
                                <h2>Customer Payments</h2>
                                <span>${currentDate}</span>
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
                
                    const tableBody = document.getElementById("payment-table-body");
                    paymentsData.forEach(payment => {
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
                                ${
                                    payment.status === "Pending" && payment.isReadyToPay
                                        ? `<button class="confirm-btn">Confirm</button>`
                                        : ""
                                }
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                    break;

                default:
                    mainContent.innerHTML = `<h2>${optionId.replace("-", " ")}</h2><p>Content for this section will go here.</p>`;
                    break;
            }
        });
    });
});