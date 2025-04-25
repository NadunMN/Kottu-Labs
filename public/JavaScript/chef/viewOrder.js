let chefId = null;

const mealDescriptions = {
    1: "All",
    2: "Classic Kottu",
    3: "Dolphin Kottu",
    4: "Cheese Kottu",
    5: "String Hopper Kottu",
    6: "KL Special Fried Rice",
    7: "Pasta",
    8: "Appetizers",
    9: "KL Inventions",
    10: "Wraps & Rotti Sandwiches",
    11: "Parata",
    12: "Devilled Portions",
    13: "Mocktails",
    14: "Beverages"
};

async function fetchOrders() {
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
        const currentDate = new Date().toLocaleDateString('en-CA');
        const todayOrders = data;

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
                mealName: order.meal_name,
                quantity: order.quantity,
                meal_id: order.meal_id,
                om_id: order.om_id,
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
            switch (order.order_status) {
                case 0:
                    // If order_status is 0 and chef is not assigned, show "Not Accepted"
                    if (!order.chef_id) {
                        statusText = "Not Accepted";
                    } else {
                        // If chef is assigned but status is still 0, it's "Preparing"
                        statusText = "Preparing";
                    }
                    break;
                case 1:
                    statusText = "Ready";
                    break;
                default:
                    statusText = "Completed";
            }
            

            const mealsDropdown = order.meals.map((meal) => `
                <li>
                    ${meal.mealName} - ${meal.quantity}
                    <button class="meal-done-btn" om-id="${meal.om_id}">Done</button>
                    ${meal.meal_id}
                </li>
            `).join("");
            
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
                                ${order.chef_id ? 'disabled' : ''}>
                            Accept
                        </button>
                        <button class="done-btn" 
                                data-order-id="${order.order_id}"
                                ${order.order_status == 0 && order.chef_id ? '' : 'disabled'}>
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
                
                console.log("Accept Payload:", { order_id: orderId, order_status: 0, chef_id: chefId });
                
                try {
                    const response = await fetch(`/order/confirm`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ 
                            order_id: orderId, 
                            order_status: 0, // Update status to 'Preparing'
                            chef_id: chefId 
                        })
                    });
                    
                    if (response.ok) {

                         // Also update the order meals
                         const response2 = await fetch(`/order/confirm/orderMeals/accept`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({ order_id: orderId })
                        });
                        
                        if (response2.ok) {
                            showToast("Order status updated to Preparing!", { type: 'success' });
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

        // Add event listener for Done buttons
        document.querySelectorAll(".done-btn").forEach(button => {
            button.addEventListener("click", async (event) => {
                const orderId = event.target.getAttribute("data-order-id");
                if (!chefId) {
                    alert("Chef ID is not available. Please try again.");
                    return;
                }
                
                console.log("Done Payload:", { order_id: orderId, order_status: 1 });
                
                try {
                    const response = await fetch(`/order/confirm`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ 
                            order_id: orderId, 
                            order_status: 1 // Update status to 'Ready'
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
                            showToast("Order status updated to Ready!", { type: 'success' });
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



        // Add event listener for meal Done buttons
        
            document.querySelectorAll(".meal-done-btn").forEach(button => {
                button.addEventListener("click", async (event) => {
                const omId = event.target.getAttribute("om-id");
                console.log("Meal Done Payload:", { om_id: omId });

                try {
                    const response = await fetch(`/order/confirm/mealDone`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ om_id: omId })
                    });

                    if (response.ok) {
                    showToast("Meal marked as done!", { type: 'success' });
                    fetchOrders();
                    } else {
                    console.error("Failed to update meal status");
                    alert("Error updating meal status. Please try again.");
                    }
                } catch (error) {
                    console.error("Error:", error);
                    alert("Error updating meal status. Please try again.");
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



// First, add this CSS to your stylesheet or in a <style> tag in your HTML head
const style = document.createElement('style');
style.textContent = `
 .toast-container {
  position: fixed;
  top: 75px;
  right: 20px;
  z-index: 9999;
  display: flex;
  flex-direction: column;
  gap: 12px;
  pointer-events: none;
}

.toast-notification {
  color: #ffffff;
  padding: 16px 20px;
  border-radius: 12px;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
  display: flex;
  align-items: center;
  min-width: 300px;
  max-width: 400px;
  transform: translateX(120%);
  transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
  border-left: 5px solid transparent;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
  opacity: 0;
  pointer-events: auto;
  overflow: hidden;
  position: relative;
}

.toast-notification.show {
  transform: translateX(0);
  opacity: 1;
}

.toast-notification.hide {
  transform: translateX(120%);
  opacity: 0;
}

.toast-icon {
  margin-right: 16px;
  font-size: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
}

.toast-content {
  flex: 1;
}

.toast-message {
  margin: 0;
  font-size: 0.95rem;
  font-weight: 500;
  line-height: 1.4;
}

.toast-close {
  background: none;
  border: none;
  color: rgba(255, 255, 255, 0.8);
  cursor: pointer;
  font-size: 18px;
  padding: 0 5px;
  margin-left: 16px;
  opacity: 0.8;
  transition: opacity 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 24px;
  width: 24px;
  border-radius: 50%;
}

.toast-close:hover {
  opacity: 1;
  background-color: rgba(255, 255, 255, 0.15);
}

.toast-close:focus {
  outline: none;
  box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

/* Toast types with matching background colors */
.toast-success {
  background-color: #4CAF50;
  border-left-color: #388E3C;
}

.toast-error {
  background-color: #ef5350;
  border-left-color: #d32f2f;
}

.toast-warning {
  background-color: #ff9800;
  border-left-color: #f57c00;
}

.toast-info {
  background-color: #2196F3;
  border-left-color: #1976D2;
}

/* Responsive adjustments */
@media (max-width: 576px) {
  .toast-container {
    top: auto;
    bottom: 20px;
    left: 20px;
    right: 20px;
    align-items: stretch;
  }
  
  .toast-notification {
    min-width: unset;
    max-width: unset;
    width: 100%;
  }
}

/* Accessibility improvements */
@media (prefers-reduced-motion: reduce) {
  .toast-notification {
    transition: none;
  }
}
`;
document.head.appendChild(style);

// Create toast container if it doesn't exist
function getToastContainer() {
  let container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
  }
  return container;
}

// Function to show toast notification
function showToast(message, options = {}) {
  const {
    type = 'success',
    duration = 3000,
    showClose = true
  } = options;
  
  const container = getToastContainer();
  
  // Create toast element
  const toast = document.createElement('div');
  toast.className = `toast-notification toast-${type}`;
  
  // Create icon based on type
  const icon = document.createElement('div');
  icon.className = 'toast-icon';
  let iconSymbol = '';
  
  switch(type) {
    case 'success':
      iconSymbol = '✓';
      break;
    case 'error':
      iconSymbol = '✕';
      break;
    case 'warning':
      iconSymbol = '!';
      break;
    case 'info':
      iconSymbol = 'i';
      break;
  }
  
  icon.textContent = iconSymbol;
  
  // Create content
  const content = document.createElement('div');
  content.className = 'toast-content';
  
  const messageElement = document.createElement('p');
  messageElement.className = 'toast-message';
  messageElement.textContent = message;
  
  content.appendChild(messageElement);
  
  // Add close button if needed
  let closeBtn;
  if (showClose) {
    closeBtn = document.createElement('button');
    closeBtn.className = 'toast-close';
    closeBtn.textContent = '×';
    closeBtn.addEventListener('click', () => {
      hideToast(toast);
    });
  }
  
  // Assemble toast
  toast.appendChild(icon);
  toast.appendChild(content);
  if (closeBtn) toast.appendChild(closeBtn);
  
  // Add to container
  container.appendChild(toast);
  
  // Show the toast (with a slight delay to allow the transition to work)
  setTimeout(() => {
    toast.classList.add('show');
  }, 10);
  
  // Hide and remove the toast after the specified duration
  if (duration !== 0) {
    setTimeout(() => {
      hideToast(toast);
    }, duration);
  }
  
  return toast;
}

// Function to hide toast
function hideToast(toast) {
  toast.classList.add('hide');
  toast.classList.remove('show');
  
  // Remove from DOM after animation
  setTimeout(() => {
    if (toast.parentNode) {
      toast.parentNode.removeChild(toast);
    }
  }, 400);
}

// Usage:
// showToast('Added to cart successfully!');
// OR with options:
// showToast('Added to cart successfully!', { type: 'success', duration: 5000 });
// Types: 'success', 'error', 'warning', 'info'