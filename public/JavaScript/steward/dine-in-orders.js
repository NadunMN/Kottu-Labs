let stewardId = null;

async function fetchOrders(filterTableNumber = null) {
    try {
        // Fetch order data
        const response = await fetch("/order/dineInData");
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
                groupedOrdersArray.push(ordersGroupedByOrderId[order.order_id]);
            }

            const meal = {
                mealName: order.meal_name,
                quantity: order.quantity,
                status: order.meal_status,
                meal_id: order.meal_id,
                om_id: order.om_id
            };
        
            ordersGroupedByOrderId[order.order_id].meals.push(meal);
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
                        <input type="text" id="table-input" placeholder="Enter Table No" />
                        <button id="filter-btn">Filter</button>
                    </div>
                </div> 
                
                <table class="menu-table" id="menu-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Order ID</th>
                            <th>Meal Name</th>
                            <th>Table No</th>
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

        tableContent.innerHTML = "";

        // FILTER orders if table number provided
        let ordersToRender = groupedOrdersArray;
        if (filterTableNumber) {
            ordersToRender = groupedOrdersArray.filter(order => 
                order.table_number.toString() === filterTableNumber.toString()
            );
        }

        // Render rows
        ordersToRender.forEach(order => {
            const row = document.createElement("tr");
            row.classList.add("order-item");

            const mealsList = order.meals.map((meal) => {
                let actionElement = "";
                if (meal.status === "ready" && order.order_status === 0) {
                    actionElement = `<button class="confirm-meal-btn" data-order-id="${meal.om_id}">Confirm</button>`;
                } else if (meal.status === "completed" && order.order_status === 0) {
                    actionElement = `<span class="meal-done-text">Done</span>`;
                }

                return `<li>${meal.mealName} - ${meal.quantity} ${actionElement}</li>`;
            }).join("");

            row.innerHTML = `
                <td class="name">${order.reservation_name}</td>
                <td class="order_id">${order.order_id}</td> 
                <td><ul>${mealsList}</ul></td>
                <td>${order.table_number}</td>
                <td class="status">
                    <span class="status-${order.order_status}">
                        ${order.order_status == 1 ? "Ready" : order.order_status == 2 ? "Completed" : "Processing"}
                    </span>
                    ${order.order_status === 1 ? `<button class="confirm-btn" data-order-id="${order.order_id}">Confirm</button>` : ""}
                </td>
            `;
            tableContent.appendChild(row);
        });

        // Event listeners for Confirm buttons
        document.querySelectorAll(".confirm-meal-btn").forEach(button => {
            button.addEventListener("click", async (event) => {
                const omId = event.target.getAttribute("data-order-id");

                if (!stewardId) {
                    console.error("Steward ID is not available.");
                    return;
                }
                
                try {
                    const response = await fetch(`/order/confirm`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ om_id: omId, meal_status: 'completed', steward_id: stewardId })
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

        document.querySelectorAll(".confirm-btn").forEach(button => {
            button.addEventListener("click", async (event) => {
                const orderId = event.target.getAttribute("data-order-id");
                if (!stewardId) {
                    console.error("Steward ID is not available.");
                    return;
                }
                try {
                    const response = await fetch(`/order/confirm`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ order_id: orderId, order_status: 2, steward_id: stewardId })
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
            const tableInput = document.getElementById("table-input").value.trim();
            fetchOrders(tableInput);
        });

    } catch (error) {
        console.error("Fetch error:", error);
        document.getElementById("main-content").innerHTML = "<p>Error loading reservations.</p>";
    }
}

// Refresh orders every 30 seconds
setInterval(() => {
    fetchOrders();
}, 30000);

fetchOrders();
