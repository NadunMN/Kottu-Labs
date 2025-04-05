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
        const todayOrders = data.filter(order => order.order_date === currentDate && order.branch_id === branch_id);
        const readyOrders = todayOrders.filter(order => order.order_status !== 0).length;

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
                            <th>Time</th>
                            <th>Reservation No</th>
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
            // Prioritize pending reservations over confirmed ones
            if (a.order_status !== 1 && b.order_status === 1) return -1;
            if (a.order_status === 1 && b.order_status !== 1) return 1;
    
            // If both have the same status, sort by time
            return a.order_time.localeCompare(b.order_time);
        });

        // Populate table with today's order data
        todayOrders.forEach((order) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td class="order-id">${order.order_id}</td>
                <td>${order.order_time}</td>
                <td>${order.reservation_no}</td>
                <td>${order.order_type === 'dinein' ? 'Dine In' : 'Take Away'}</td>
                <td class="status">
                    <span class="status-${order.order_status}">
                        ${order.order_status === 1 ? "Ready" : "Processing"}
                    </span>
                </td>
            `;
            tableContent.appendChild(row);
        });

    } catch (error) {
        console.error("Fetch error:", error);
        document.getElementById("main-content").innerHTML = "<p>Error loading reservations.</p>";
    }
}

// Refresh orders every minute
setInterval(() => {
    fetchOrders();
}, 60000);

fetchOrders();
