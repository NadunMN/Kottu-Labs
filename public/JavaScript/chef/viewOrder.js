async function fetchOrders(selectedDate = null, selectedTime = null) {
    try {
        const response = await fetch("/order/data");
        if (!response.ok) throw new Error("Network response was not ok");

        const text = await response.text();
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error("Invalid JSON:", text);
            document.getElementById("main-content").innerHTML = "<p>Error: Invalid data format</p>";
            return;
        }

        if (!Array.isArray(data)) {
            document.getElementById("main-content").innerHTML = "<p>Error: Invalid data format</p>";
            return;
        }

        const orderContent = document.getElementById("main-content");
        if (!data || data.length === 0) {
            orderContent.innerHTML = `<div class="no-offers-container" 
            style="text-align: center; 
                    display: flex; 
                    flex-direction: column; 
                    align-items: center; 
                    justify-content: center; 
                    width: 100%;
                    height: 85vh;
                    border-radius: 10px; 
                    ">
            <i class="fa-solid fa-utensils" 
            style="font-size: 3rem; 
                    color: #6c757d; 
                    margin-bottom: 1rem;"></i>
            <h3 style="font-size: 1.5rem; 
                    color: #343a40; 
                    margin-bottom: 0.5rem; 
                    font-weight: 600;">
                No Orders Found!
            </h3>
            <p style="color: #6c757d; 
                    font-size: 1rem; 
                    max-width: 400px; 
                    line-height: 1.5;">
                We'll notify you when new orders arrive!
            </p>
        </div>`;
            return;
        }

        // Get user branch info (keep existing implementation)
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
        
        // Group orders by order_id
        const groupedOrders = data.reduce((acc, order) => {
            const key = order.order_id;
            if (!acc[key]) {
                acc[key] = {
                    ...order,
                    meals: []
                };
            }
            acc[key].meals.push({ mealName: order.mealName, quantity: order.quantity });
            return acc;
        }, {});

        const ordersArray = Object.values(groupedOrders);
        const todayOrders = ordersArray.filter(order => order.order_date === currentDate);

        // Status counts
        const acceptedOrders = todayOrders.filter(o => o.order_status === 1).length;
        const preparingOrders = todayOrders.filter(o => o.order_status === 2).length;
        const cookedOrders = todayOrders.filter(o => o.order_status === 3).length;

        orderContent.innerHTML = `
            <div class="main-section">
                <div class="topic-bar">
                    <div class="topic-bar-text">
                        <h2>Order Status - ${branchName}</h2>
                        <span>${currentDate}</span>
                        <h4>Total: ${todayOrders.length} | Accepted: ${acceptedOrders} | Preparing: ${preparingOrders} | Cooked: ${cookedOrders}</h4>
                    </div>
                    <div class="filter-section">
                        <input type="text" id="tableFilter" placeholder="Filter by Table No...">
                        <button onclick="filterOrders()">Filter</button>
                        <button onclick="resetFilter()">Reset</button>
                    </div>
                </div>
                <div class="orders-container" id="orders-container"></div>
            </div>
        `;

        const container = document.getElementById("orders-container");
        todayOrders.sort((a, b) => a.order_time.localeCompare(b.order_time));

        todayOrders.forEach(order => {
            const orderCard = document.createElement("div");
            orderCard.className = "order-card";
            orderCard.setAttribute("data-table-number", order.type === 'dinein' ? order.table_number : 'TA');
            orderCard.innerHTML = `
                <div class="order-header">
                    <div>
                        <h3>Order #${order.order_id}</h3>
                        <p class="order-time">${order.order_time}</p>
                    </div>
                    <button class="toggle-meals">▼</button>
                </div>
                <div class="order-meta">
                    <span class="order-type">${order.type === 'dinein' ? 'Dine In' : 'Take Away'}</span>
                    <span class="table-number">${order.type === 'dinein' ? `Table ${order.table_number}` : ''}</span>
                </div>
                <div class="meals-list" style="display:none">
                    ${order.meals.map(meal => `
                        <div class="meal-item">
                            <span>${meal.mealName}</span>
                            <span class="meal-qty">x${meal.quantity}</span>
                        </div>
                    `).join('')}
                </div>
                <div class="status-actions">
                    <button class="status-btn ${order.order_status === 1 ? 'active' : ''}" data-status="1">
                        Accepted
                    </button>
                    <button class="status-btn ${order.order_status === 2 ? 'active' : ''}" data-status="2">
                        Preparing
                    </button>
                    <button class="status-btn ${order.order_status === 3 ? 'active' : ''}" data-status="3">
                        Cooked
                    </button>
                </div>
            `;
            container.appendChild(orderCard);
        });

        // Add toggle functionality
        document.querySelectorAll('.toggle-meals').forEach(button => {
            button.addEventListener('click', () => {
                const mealsList = button.closest('.order-card').querySelector('.meals-list');
                mealsList.style.display = mealsList.style.display === 'none' ? 'block' : 'none';
                button.textContent = mealsList.style.display === 'none' ? '▼' : '▲';
            });
        });

        // Add status update functionality
        document.querySelectorAll('.status-btn').forEach(button => {
            button.addEventListener('click', async (e) => {
                const orderId = e.target.closest('.order-card').querySelector('h3').textContent.split('#')[1];
                const newStatus = parseInt(e.target.dataset.status);

                try {
                    const response = await fetch(`/order/update-status`, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ order_id: orderId, status: newStatus })
                    });

                    if (response.ok) {
                        fetchOrders(); // Refresh orders
                    } else {
                        alert("Error updating status");
                    }
                } catch (error) {
                    console.error("Error:", error);
                    alert("Update failed");
                }
            });
        });

    } catch (error) {
        console.error("Fetch error:", error);
        orderContent.innerHTML = "<p>Error loading orders</p>";
    }
}

// Update filter functions
function filterOrders() {
    const input = document.getElementById("tableFilter").value.trim().toLowerCase();
    document.querySelectorAll('.order-card').forEach(card => {
        const tableNumber = card.getAttribute('data-table-number').toLowerCase();
        card.style.display = tableNumber.includes(input) ? 'block' : 'none';
    });
}

function resetFilter() {
    document.getElementById("tableFilter").value = '';
    document.querySelectorAll('.order-card').forEach(card => {
        card.style.display = 'block';
    });
}

// Keep existing interval and initial call
setInterval(fetchOrders, 60000);
fetchOrders();