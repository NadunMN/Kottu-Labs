async function fetchOrders(selectedDate = null, selectedTime = null) {
    try {
        // Fetch order data
        const response = await fetch("/order/data");
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }

        const text = await response.text();
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error("Response is not valid JSON:", text);
            document.getElementById("main-content").innerHTML = "<p>Error: Invalid data format</p>";
            return;
        }
        
        if (!Array.isArray(data)) {
            console.error("Data is not an array");
            document.getElementById("main-content").innerHTML = "<p>Error: Invalid data format</p>";
            return;
        }

        const orderContent = document.getElementById("main-content");
        if (!data || data.length === 0) {
            orderContent.innerHTML = "<p>No orders available</p>";
            return;
        }

        // Fetch user branch ID before rendering
        let branch_id = null;
        try {
            const userResponse = await fetch('/user/data');
            if (!userResponse.ok) {
                throw new Error("Network response was not ok");
            }
            const userData = await userResponse.json();
            if (userData.error) {
                console.error(userData.error);
            } else {
                branch_id = userData.branch_id;
            }
        } catch (error) {
            console.error('Error fetching user data:', error);
        }

        const branchName = branch_id === 1 ? 'Wattala' : branch_id === 2 ? 'Kelaniya' : 'Kotahena';
        const currentDate = selectedDate || new Date().toISOString().split('T')[0];
        const todayOrders = data.filter(order => order.order_date === currentDate);
        const readyOrders = todayOrders.filter(order => order.order_status == 1).length;

        // Render order content
        orderContent.innerHTML = `
            <div class="main-section">
                <div class="topic-bar">
                    <div class="topic-bar-text">
                        <h2>Order Status - ${branchName} </h2>
                        <span>${currentDate}</span>
                        <h4>Available orders - ${todayOrders.length} &emsp; Ready orders - ${readyOrders}</h4>
                    </div>
                    <div class="filter-section">
                        <input type="text" id="tableFilter" placeholder="Filter by Table No...">
                        <button onclick="filterOrders()">Filter</button>
                        <button onclick="resetFilter()">Reset</button>
                    </div>
                </div> 
                
                <table class="menu-table" id="menu-table">
                    <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Meal Name</th>
                            <th>Quantity</th>
                            <th>Table No</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="table-content"></tbody>
                </table>
            </div>
        `;

        const tableContent = document.getElementById("table-content");
        if (!tableContent) {
            console.error("Table content element not found.");
            return;
        }

        // Sort reservations: pending first, then confirmed, sorted by time
        todayOrders.sort((a, b) => {
            // Prioritize pending reservations over ready ones
            if (a.order_status !== b.order_status) {
                return a.order_status === 1 ? -1 : b.order_status === 1 ? 1 : a.order_status - b.order_status;
            }
    
            // If both have the same status, sort by time
            return a.order_time.localeCompare(b.order_time);
        });

        // Clear existing rows before appending new ones
        tableContent.innerHTML = "";
        // Populate table with today's order data
        todayOrders.forEach((order) => {
            const row = document.createElement("tr");
            row.classList.add("order-item"); // Add class for filtering
            row.setAttribute("data-table-number", order.table_number); // Use data attribute for filtering
            row.innerHTML = `
                <td class="order-id">${order.order_id}</td>
                <td>${order.mealName}</td>
                <td>${order.quantity}</td>
                <td>${order.type === 'dinein' ? order.table_number : 'Null'}</td>
                <td>${order.type === 'dinein' ? 'Dine In' : 'Take Away'}</td>
                <td class="status">
                    <span class="status-${order.order_status}">
                        ${order.order_status == 1 ? "Ready" : order.order_status == 2 ? "Completed" :  "Processing"}
                    </span>
                    ${order.order_status === 1 ? `<button class="confirm-btn" data-order-id="${order.order_id}">Confirm</button>` : ""}
                </td>
            `;
            tableContent.appendChild(row);
        });

        // Add event listener for confirm buttons
        document.querySelectorAll(".confirm-btn").forEach(button => {
            button.addEventListener("click", async (event) => {
                const orderId = event.target.getAttribute("data-order-id");
                try {
                    const response = await fetch(`/order/confirm`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({order_id: orderId, order_status: 2 }) // Update status to 'Completed'
                    });
                    console.log("Response:", response);

                    if (response.ok) {
                        alert("Order status updated to Completed!");
                        fetchOrders(); // Refresh the orders
                    } else {
                        console.error("Failed to update order status");
                        alert("Error updating order status. Please try again.");
                    }
                } catch (error) {
                    console.error("Error:", error);
                    alert("Error updating order status. Please try again.");
                }
            });
        });

    } catch (error) {
        console.error("Fetch error:", error);
        document.getElementById("main-content").innerHTML = "<p>Error loading reservations.</p>";
    }
}

function filterOrders() {
    const input = document.getElementById("tableFilter").value.trim();
    const orders = document.querySelectorAll(".order-item");
    
    orders.forEach(order => {
        const tableNo = order.getAttribute("data-table-number"); // Use data attribute
        if (tableNo && tableNo.includes(input)) {
            order.style.display = "";
        } else {
            order.style.display = "none";
        }
    });
}

function resetFilter() {
    document.getElementById("tableFilter").value = "";
    const orders = document.querySelectorAll(".order-item");
    orders.forEach(order => {
        order.style.display = "";
    });
}




// Refresh orders every minute
setInterval(() => {
    fetchOrders();
}, 60000);

fetchOrders();
