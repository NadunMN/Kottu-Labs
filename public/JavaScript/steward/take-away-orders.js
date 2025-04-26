let stewardId = null;

async function fetchOrders(filterReservationNo = null) {
    try {
        // Fetch order data
        const response = await fetch("/order/takeAwayData");
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
            orderContent.innerHTML = `<div id="orderContent" class="empty-state">
        <div class="icon-container">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
        </div>
        <h2>No Orders Yet</h2>
        <p>It looks like Branch haven't any orders yet.</p>
        
    </div>`;
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
                stewardId = userData.id;
            }
        } catch (error) {
            console.error('Error fetching user data:', error);
        }

        const branchName = branch_id === 1 ? 'Wattala' : branch_id === 2 ? 'Kelaniya' : 'Kotahena';
        const currentDate = new Date().toLocaleDateString('en-CA');
        const todayOrders = data;

        // Sort reservations
        todayOrders.sort((a, b) => {
            const priority = { 1: 0, 0: 1, 2: 2 }; // Define priority mapping
            if (priority[a.order_status] !== priority[b.order_status]) {
                return priority[a.order_status] - priority[b.order_status];
            }
            return a.order_time.localeCompare(b.order_time);
        });

        const readyOrders = new Set(
            todayOrders.filter(order => order.order_status == 1).map(order => order.order_id)
        ).size;
        const uniqueAvailableOrders = new Set(
            todayOrders.filter(order => order.order_status !== 2).map(order => order.order_id)
        );
        const availableOrders = uniqueAvailableOrders.size;

        // Group meals
        const ordersGroupedByOrderId = {};
        const groupedOrdersArray = [];

        todayOrders.forEach(order => {
            if (!ordersGroupedByOrderId[order.order_id]) {
                ordersGroupedByOrderId[order.order_id] = {
                    ...order,
                    meals: []
                };
                groupedOrdersArray.push(ordersGroupedByOrderId[order.order_id]); // Maintain sorted order
            }

            ordersGroupedByOrderId[order.order_id].meals.push({
                mealName: order.meal_name,
                quantity: order.quantity
            });
        });

        // Render order content
        orderContent.innerHTML = `
            <div class="main-section">
                <div class="topic-bar">
                    <div class="topic-bar-text">
                        <h2>Order Status - ${branchName} </h2>
                        <span>${currentDate}</span>
                        <h4>Available orders - ${availableOrders} &emsp; Ready orders - ${readyOrders}</h4>
                    </div>
                    <div class="filter-section">
                        <input type="text" id="reservation-input" placeholder="Enter Reservation No" />
                        <button id="filter-btn">Filter</button>
                </div> 
                
                <table class="menu-table" id="menu-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Order ID</th>
                            <th>Time</th>
                            <th>Meal Name</th>
                            <th>Reservation No</th>
                            <th>Status</th>
                            <th>Arrival</th>
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

        // Clear existing rows before appending new ones
        tableContent.innerHTML = "";

        // FILTER orders if reservation number provided
        let ordersToRender = groupedOrdersArray;
        if (filterReservationNo) {
            ordersToRender = groupedOrdersArray.filter(order => 
                order.reservation_no && order.reservation_no.toString() === filterReservationNo.toString()
            );
        }

         // Render rows directly from the grouped orders
        ordersToRender.forEach(order => {
            const row = document.createElement("tr");
            row.classList.add("order-item");

            const mealsDropdown = order.meals.map((meal) => `<li>${meal.mealName} - ${meal.quantity}</li>`).join("");
            row.innerHTML = `
                <td class="name">${order.reservation_name ?? "Unknown"}</td>
                <td class="order_id">${order.order_id ?? "N/A"}</td> 
                <td>${order.order_time ?? "N/A"}</td>
                <td>
                    <details>
                        <summary>View Meals</summary>
                        <ul>${mealsDropdown}</ul>
                    </details>
                </td>
                <td>${order.reservation_no ?? "N/A"}</td>
                <td class="status">
                    <span class="status-${order.order_status ?? "unknown"}">
                        ${order.order_status == 1 ? "Ready" : order.order_status == 2 ? "Completed" :  "Processing"}
                    </span>
                </td>
                <td class="arrival">
                <span class="status-${order.confirmation_status ?? "unknown"}">
                            ${order.confirmation_status === 0 ? "NO" : "YES"}
                        </span>
                    ${order.order_status === 1 && order.confirmation_status === 1 ? `<button class="confirm-btn" data-order-id="${order.order_id}">Confirm</button>` : ""}
                </td>

            `;
            tableContent.appendChild(row);
        });

        // Add event listener for confirm buttons
        document.querySelectorAll(".confirm-btn").forEach(button => {
            button.addEventListener("click", async (event) => {
                const orderId = event.target.getAttribute("data-order-id");
                if (!stewardId) {
                    alert("Steward ID is not available. Please try again.");
                    return;
                }
                try {
                    const response = await fetch(`/order/confirm`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ order_id: orderId, order_status: 2, steward_id: stewardId }) // Update status to 'Completed'
                    });
                    
                    if (response.ok) {
                        fetchOrders();
                    } else {
                        console.error("Failed to update order status");
                    }
                } catch (error) {
                    console.error("Error:", error);
                }
            });
        });

        // Add event listener for the Filter button
        document.getElementById("filter-btn").addEventListener("click", () => {
            const reservationInput = document.getElementById("reservation-input").value.trim();
            fetchOrders(reservationInput);
        });

    } catch (error) {
        console.error("Fetch error:", error);
        document.getElementById("main-content").innerHTML = "<p>Error loading reservations.</p>";
    }
}

// Refresh orders
setInterval(() => {
    fetchOrders();
}, 30000);

fetchOrders();