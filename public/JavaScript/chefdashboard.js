document.addEventListener("DOMContentLoaded", () => {
    // Select all sidebar list items
    const sidebarOptions = document.querySelectorAll(".sidebar ul li");
    const mainContent = document.getElementById("main-content");

    // Default selection to "view-users"
    // document.getElementById("view-users").classList.add("selected");
    
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
                case "update-menu":

                    fetch('/menuitem/data')
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                console.error('Error:', data.error);
                            } else {
                                // Get the meal content container
                                const mealContent = document.getElementById('main-content');
                                console.log(data)

                                if (data == null || data.length === 0) {
                                    mealContent.innerHTML = 'No meals available'; // Show a message if there are no meals
                                } else {
                                    mealContent.innerHTML = ''; // Clear previous content if data is available
                                }

                                mealContent.innerHTML =`

                                    <div class="view-branch-menu-section">
                                            <h2>Branch: Nawala</h2>
                                            <table class="menu-table" id="menu-table">
                                                <thead>
                                                    <tr>
                                                        <th>Meal ID</th>
                                                        <th>Name</th>
                                                        <th>Type</th>
                                                        <th>Price</th>
                                                        <th>Actions</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-content"></tbody>
                                            </table>
                                            
                                            <button class="add-item-btn">Add New Item</button>

                                            <div id="add-item-form" class="add-item-form hidden">
                                                <h3>Add New Menu Item</h3>
                                                <form id="add-form" action="">
                                                    <div class="form-group">
                                                        <label for="item-name">Name</label>
                                                        <input type="text" id="item-name" name="meal_name" placeholder="Enter item name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="item-price">Price</label>
                                                        <input type="number" id="item-price" name="meal_price" placeholder="Enter price" min="0" step="0.01">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="meal_description">Category</label>
                                                        <select id="meal_description" name="meal_description" required>
                                                            <option value="Appetizers">Appetizers</option>
                                                            <option value="Pasta">Pasta</option>
                                                            <option value="Dolphin Kottu">Dolphin Kottu</option>
                                                            <option value="KL Inventions">KL Inventions</option>
                                                            <option value="Wraps & Rotti Sandwiches">Wraps & Rotti Sandwiches</option>
                                                            <option value="Parata">Parata</option>
                                                            <option value="Devilled Portions">Devilled Portions</option>
                                                            <option value="KL Special Fried Rice">KL Special Fried Rice</option>
                                                            <option value="Classic Kottu">Classic Kottu</option>
                                                            <option value="Cheese Kottu">Cheese Kottu</option>
                                                            <option value="String Hopper Kottu">String Hopper Kottu</option>
                                                            <option value="Mocktails">Mocktails</option>
                                                            <option value="Beverages">Beverages</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="submit" name="submit" class="save-item-btn" placeholder="Submit">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                `;


                                // Dynamically generate meal elements
                                data.forEach(meal => {
                                    // Create a new table row
                                    const row = document.createElement('tr');
                                
                                    // Populate row HTML
                                    row.innerHTML = `
                                        <td class="meal-id">${meal.meal_id}</td>
                                        <td>${meal.meal_name}</td>
                                        <td>${meal.meal_description}</td>
                                        <td>${meal.price}</td>
                                        <td>

                                        <button class="status-btn ${meal.available ? 'available' : 'unavailable'}">
                                                ${meal.available ? 'Available' : 'Unavailable'}
                                            </button>
                                            
                                        </td>
                                        <td>
                                            

                                            <div class="action-buttons">
                                                <button class="edit-btn">Edit</button>
                                                <button class="delete-btn" meal-id ='${meal.meal_id}'>Delete</button>
                                            </div>
                                        </td>
                                    `;
                                
                                    // Append the row directly to the table body
                                    document.getElementById('table-content').appendChild(row);
                                });
                                
                                // Toggle the Add New Item Form visibility
                                document.querySelector('.add-item-btn').addEventListener('click', () => {
                                    const form = document.querySelector('.add-item-form');
                                    form.classList.toggle('hidden');
                                });

                                // Add event listeners to the status buttons to toggle availability
                    const statusButtons = document.querySelectorAll('.status-btn');
                    statusButtons.forEach(button => {
                        button.addEventListener('click', () => {
                            if (button.classList.contains('available')) {
                                button.classList.remove('available');
                                button.classList.add('unavailable');
                                button.textContent = 'Unavailable';
                            } else {
                                button.classList.remove('unavailable');
                                button.classList.add('available');
                                button.textContent = 'Available';
                            }
                        });
                    });


                    // Add event listeners to delete buttons
                    const deleteButtons = document.querySelectorAll('.delete-btn');
                    deleteButtons.forEach(button => {
                        button.addEventListener('click', () => {
                            // const row = button.closest('tr');
                            // row.remove();

                            if (confirm('Are you sure you want to delete this meal? This action cannot be undone.')) {
                                const mealId = button.getAttribute('meal-id');
                                console.log(mealId);

                                const requestBody = JSON.stringify({ meal_id: mealId });
                                console.log('Request Body:', requestBody);
        
                                fetch('/mealitem/delete', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: requestBody
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('The review has been deleted.');
                                        fetchReviews(); // Refresh the reviews
                                    } else {
                                        alert('There was an error deleting the review: ' + data.message);
                                        console.error('Error:', data.message);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                            }

                        });
                    });

                    document.getElementById('add-form').addEventListener("submit", function(event) {
                        event.preventDefault();
                        const formData = new FormData(this);
                        const data = Object.fromEntries(formData.entries());
                        const requestBody = JSON.stringify(data);
                        console.log('Request Body:', requestBody);
                        fetch("menuitem/add", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: requestBody,
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log("Success:", data);
                        })
                        .catch(error => {
                            console.error("Error:", error);
                        });
                    });





                            }
                        });

        
                    break;

                case "view-orders":
                    mainContent.innerHTML = `
                        <div class="order-history-section">
                            <h2>View Orders</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Customer Name</th>
                                        <th>Food Items</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#1001</td>
                                        <td>2024-11-20</td>
                                        <td>18:30</td>
                                        <td>Thirani Imanya</td>
                                        <td>Chicken Kottu</td>
                                        <td>Completed</td>
                                        
                                    </tr>
                                    <tr>
                                        <td>#1002</td>
                                        <td>2024-11-21</td>
                                        <td>19:00</td>
                                        <td>Abdul Raheem</td>
                                        <td>Redbull</td>
                                        <td>Pending</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Accept</button>
                                                <button>Reject</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#1003</td>
                                        <td>2024-11-22</td>
                                        <td>20:15</td>
                                        <td>Imeth Methnuka</td>
                                        <td>Chicken Fried Rice</td>
                                        <td>Under Preparation</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Ready</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#1004</td>
                                        <td>2024-11-23</td>
                                        <td>17:45</td>
                                        <td>Nadun Madushanka</td>
                                        <td>Seafood Kottu</td>
                                        <td>Under Preparation</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Ready</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>`;
                    break;

                default:
                    mainContent.innerHTML = `<h2>${optionId.replace("-", " ")}</h2><p>Content for this section will go here.</p>`;
                    break;
            }
        });
    });
});





