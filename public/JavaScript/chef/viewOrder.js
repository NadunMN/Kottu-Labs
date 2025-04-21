let chefId = null;

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
                chefId = userData.id;
            }
        } catch (error) {
            console.error('Error fetching user data:', error);
        }

        const branchName = branch_id === 1 ? 'Wattala' : branch_id === 2 ? 'Kelaniya' : 'Kotahena';
        const currentDate = selectedDate || new Date().toISOString().split('T')[0];
        const todayOrders = data.filter(order => order.order_date === currentDate);

        // Sort reservations - updated priority mapping for new status workflow
        // 0: Not Accepted, 1: Preparing, 2: Ready, 3: Completed
        todayOrders.sort((a, b) => {
            const priority = { 0: 0, 1: 1, 2: 2, 3: 3 }; // Updated priority mapping
            if (priority[a.order_status] !== priority[b.order_status]) {
                return priority[a.order_status] - priority[b.order_status];
            }
            return a.order_time.localeCompare(b.order_time);
        });

        const readyOrders = new Set(
            todayOrders.filter(order => order.order_status == 2).map(order => order.order_id)
        ).size;
        const uniqueAvailableOrders = new Set(
            todayOrders.filter(order => order.order_status !== 3).map(order => order.order_id)
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
                mealName: order.mealName,
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
                            <th>Table No</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
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

        // Add CSS for status colors
        const styleElement = document.createElement('style');
        if (!document.getElementById('order-status-styles')) {
            styleElement.id = 'order-status-styles';
            styleElement.textContent = `
                .status-0 { color: red; font-weight: bold; } /* Not Accepted */
                .status-1 { color: #FFA500; font-weight: bold; } /* Preparing */
                .status-2 { color: green; font-weight: bold; } /* Ready */
                .status-3 { color: gray; } /* Completed */
                .action-buttons { display: flex; gap: 8px; }
                .action-buttons button { padding: 5px 10px; cursor: pointer; }
                .action-buttons button:disabled { opacity: 0.5; cursor: not-allowed; }
            `;
            document.head.appendChild(styleElement);
        }

        // Render rows directly from the grouped orders
        groupedOrdersArray.forEach(order => {
            const row = document.createElement("tr");
            row.classList.add("order-item");
            row.setAttribute("data-table-number", order.table_number);

            // Get the status text based on order_status
            let statusText;
            switch(order.order_status) {
                case 0: statusText = "Not Accepted"; break;
                case 1: statusText = "Preparing"; break;
                case 2: statusText = "Ready"; break;
                case 3: statusText = "Completed"; break;
                default: statusText = "Unknown";
            }

            const mealsDropdown = order.meals.map((meal) => `<li>${meal.mealName} - ${meal.quantity}</li>`).join("");
            
            row.innerHTML = `
                <td class="order-id">${order.order_id}</td> 
                <td>
                    <details>
                        <summary>View Meals</summary>
                        <ul>${mealsDropdown}</ul>
                    </details>
                </td>
                <td>${order.type === 'dinein' ? order.table_number : 'Null'}</td>
                <td>${order.type === 'dinein' ? 'Dine In' : 'Take Away'}</td>
                <td class="status">
                    <span class="status-${order.order_status}">
                        ${statusText}
                    </span>
                </td>
                <td class="action-buttons">
                    ${order.order_status < 2 ? `
                        <button class="accept-btn" 
                                data-order-id="${order.order_id}" 
                                ${order.order_status !== 0 ? 'disabled' : ''}>
                            Accept
                        </button>
                        <button class="done-btn" 
                                data-order-id="${order.order_id}"
                                ${order.order_status !== 1 ? 'disabled' : ''}>
                            Done
                        </button>
                    ` : `
                        <button class="accept-btn" 
                                data-order-id="${order.order_id}" 
                                disabled>
                            Accept
                        </button>
                        <button class="done-btn" 
                                data-order-id="${order.order_id}"
                                disabled>
                            Done
                        </button>
                    `}
                </td>
            `;
            tableContent.appendChild(row);
        });

        // Add event listener for Accept buttons
        document.querySelectorAll(".accept-btn").forEach(button => {
            button.addEventListener("click", async (event) => {
                const orderId = event.target.getAttribute("data-order-id");
                if (!chefId) {
                    alert("Chef ID is not available. Please try again.");
                    return;
                }
                
                console.log("Accept Payload:", { order_id: orderId, order_status: 1, chef_id: chefId });
                
                try {
                    const response = await fetch(`/order/confirm`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ 
                            order_id: orderId, 
                            order_status: 1, // Update status to 'Preparing'
                            chef_id: chefId 
                        })
                    });
                    
                    if (response.ok) {
                        alert("Order status updated to Preparing!");
                        fetchOrders();
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

        // Add event listener for Done buttons
        document.querySelectorAll(".done-btn").forEach(button => {
            button.addEventListener("click", async (event) => {
                const orderId = event.target.getAttribute("data-order-id");
                if (!chefId) {
                    alert("Chef ID is not available. Please try again.");
                    return;
                }
                
                console.log("Done Payload:", { order_id: orderId, order_status: 2 });
                
                try {
                    const response = await fetch(`/order/confirm`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ 
                            order_id: orderId, 
                            order_status: 2 // Update status to 'Ready'
                        })
                    });
                    
                    if (response.ok) {
                        // Also update the order meals
                        const response2 = await fetch(`/order/confirm/orderMeals`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({ order_id: orderId })
                        });
                        
                        if (response2.ok) {
                            alert("Order status updated to Ready!");
                            fetchOrders();
                        } else {
                            console.error("Failed to update order meals");
                            alert("Error updating order meals. Please try again.");
                        }
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
        document.getElementById("main-content").innerHTML = "<p>Error loading orders.</p>";
    }
}

function filterOrders() {
    const input = document.getElementById("tableFilter").value.trim();
    const orders = document.querySelectorAll(".order-item");
    
    orders.forEach(order => {
        const tableNo = order.getAttribute("data-table-number");
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

// Refresh orders
setInterval(() => {
    fetchOrders();
}, 30000);

fetchOrders();