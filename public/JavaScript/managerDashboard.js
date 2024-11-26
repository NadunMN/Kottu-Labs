document.addEventListener("DOMContentLoaded", () => {
    // Select all sidebar list items
    const sidebarOptions = document.querySelectorAll(".sidebar ul li");
    const mainContent = document.getElementById("main-content");

    // Default selection to "view-users"
    document.getElementById("view-users").classList.add("selected");
    
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
                case "view-users":
                    mainContent.innerHTML = `
                        <div class="view-users-section">
                            <h2>View Users</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Contact No.</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>John Doe</td>
                                        <td>johndoe@example.com</td>
                                        <td>Admin</td>
                                        <td>027282</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Edit</button>
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jane Smith</td>
                                        <td>janesmith@example.com</td>
                                        <td>User</td>
                                        <td>023456</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Edit</button>
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Michael Brown</td>
                                        <td>michaelb@example.com</td>
                                        <td>Manager</td>
                                        <td>078945</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Edit</button>
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Linda Lee</td>
                                        <td>lindalee@example.com</td>
                                        <td>Admin</td>
                                        <td>031298</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Edit</button>
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>`;
                    break;

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
                                            <div class="topic-bar">
                                                <div>
                                                    <h2>Nawala</h2>
                                                    <h5>36 meals available</h5>
                                                </div>

                                                <div>
                                                    <button class="add-item-btn">Add New Item</button>
                                                </div>

                                            </div>

                                            <div id="add-item-form" class="add-item-form hidden">
                                            <form id="add-form" action="">
                                            <h3>Add New Menu Item</h3>
                                                    <div class="form-group">
                                                        <label for="item-id">Meal Id</label>
                                                        <input type="text" id="item-id" name="meal_id" placeholder="Enter Meal id">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="item-name">Meal Name</label>
                                                        <input type="text" id="item-name" name="meal_name" placeholder="Enter item name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="item-price">Meal Price</label>
                                                        <input type="number" id="item-price" name="meal_price" placeholder="Enter price" min="0" step="0.01">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="meal_description">Description</label>
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

                                                    <div class="form-group">
                                                        <button class="cancel-item-btn">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                               
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
                                        </div>

                                `;

                                let mealId;
                                // Dynamically generate meal elements
                                data.forEach(meal => {
                                    // Create a new table row
                                    const row = document.createElement('tr');
                                
                                    // Populate row HTML
                                    row.innerHTML = `
                                        <td class="meal-id" >${meal.meal_id}</td>
                                        <td>${meal.meal_name}</td>
                                        <td>${meal.meal_description}</td>
                                        <td>Rs.${meal.meal_price}</td>
                                        <td>

                                        <button class="status-btn ${meal.available ? 'available' : 'unavailable'}">
                                                ${meal.available ? 'Available' : 'Unavailable'}
                                            </button>
                                            
                                        </td>
                                        <td>
                                            

                                            <div class="action-buttons">
                                                <button class="edit-btn" meal-id='${meal.meal_id}'>Edit</button>
                                                <button class="delete-btn" meal-id ='${meal.meal_id}'>Delete</button>
                                            </div>
                                        </td>
                                    `;
                                
                                    // Append the row directly to the table body
                                    document.getElementById('table-content').appendChild(row);

                                    
                                });

                                 // Get Elements
                                const openFormBtn = document.querySelector('.add-item-btn');
                                const closeFormBtn = document.querySelector('.cancel-item-btn');
                                const addItemForm = document.getElementById('add-item-form');
                                const addForm = document.getElementById('add-form');
 
                                 // Open the Popup
                                openFormBtn.addEventListener('click', () => {
                                    addItemForm.classList.remove('hidden');
                                    resetForm();
                                    addForm.removeEventListener('submit', updateItem);
                                    addForm.addEventListener('submit', addNewItem);
                                });

                             

                                 // Close the Popup
                                closeFormBtn.addEventListener('click', (event) => {
                                    addItemForm.classList.add('hidden');
                                    event.preventDefault();
                                    resetForm();
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


                                // Edit Button Event Listener
                document.querySelectorAll('.edit-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        mealId = button.getAttribute('meal-id');;
                        console.log(mealId);
                        const row = button.closest('tr');
                        const mealName = row.querySelector('td:nth-child(2)').innerText;
                        const mealDescription = row.querySelector('td:nth-child(3)').innerText;
                        const mealPrice = row.querySelector('td:nth-child(4)').innerText.replace('Rs.', '');

                        // Open the form and fill it with the existing data
                        addItemForm.classList.remove('hidden');
                        document.getElementById('item-id').value = mealId;
                        document.getElementById('item-name').value = mealName;
                        document.getElementById('item-price').value = mealPrice;
                        document.getElementById('meal_description').value = mealDescription;

                        // Change form action to update
                        addForm.removeEventListener('submit', addNewItem);
                        addForm.addEventListener('submit', updateItem);
                    });
                });

                function addNewItem(event) {
                    event.preventDefault();
                    const formData = new FormData(addForm);
                    const data = Object.fromEntries(formData.entries());
                    
                    const requestBody = JSON.stringify(data);
                    console.log('Request Body:', requestBody);
                    fetch("/menuitem/add", {
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
                        addItemForm.classList.add('hidden');
                        resetForm();
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });
                }


                // Function to update an existing item
                function updateItem(event) {
                    event.preventDefault();
                    const formData = new FormData(addForm);
                    let data = Object.fromEntries(formData.entries());
                    data.older_id = mealId;
                    const requestBody = JSON.stringify(data);
                    console.log('Request Body:', requestBody);
                    fetch("/menuitem/update", {
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
                        addItemForm.classList.add('hidden');
                        resetForm();
                        addForm.removeEventListener('submit', updateItem);
                        addForm.addEventListener('submit', addNewItem);
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });
                }

                // Function to reset the form
                function resetForm() {
                    addForm.reset();
                    document.getElementById('item-id').value = '';
                }
                                



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
                                        alert('The meal has been deleted.');
                                        fetchReviews(); // Refresh the reviews
                                    } else {
                                        alert('There was an error deleting the meal: ' + data.message);
                                        console.error('Error:', data.message);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                            }

                        });
                    });

                    
                    // document.getElementById('add-form').addEventListener("submit", function(event) {
                    //     event.preventDefault();
                    //     const formData = new FormData(this);
                    //     const data = Object.fromEntries(formData.entries());
                    //     const requestBody = JSON.stringify(data);
                    //     console.log('Request Body:', requestBody);
                    //     fetch("menuitem/add", {
                    //         method: "POST",
                    //         headers: {
                    //             "Content-Type": "application/json",
                    //         },
                    //         body: requestBody,
                    //     })
                    //     .then(response => {
                    //         if (!response.ok) {
                    //             throw new Error(`HTTP error! status: ${response.status}`);
                    //         }
                    //         return response.json();
                    //     })
                    //     .then(data => {
                    //         console.log("Success:", data);
                    //     })
                    //     .catch(error => {
                    //         console.error("Error:", error);
                    //     });
                    // });

                    

                 }
                });

        
                    break;

                case "view-reservations":
                    mainContent.innerHTML = `
                        <div class="view-reservations-section">
                            <h2>View Reservations</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Reservation No.</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>No. of Heads</th>
                                        <th>Booked By</th>
                                        <th>Table Number</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>R001</td>
                                        <td>2024-11-25</td>
                                        <td>19:00</td>
                                        <td>4</td>
                                        <td>John Doe</td>
                                        <td>12</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Edit</button>
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>R002</td>
                                        <td>2024-11-26</td>
                                        <td>20:30</td>
                                        <td>2</td>
                                        <td>Jane Smith</td>
                                        <td>5</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Edit</button>
                                                <button>Delete</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>R003</td>
                                            <td>2024-11-27</td>
                                            <td>18:45</td>
                                            <td>6</td>
                                            <td>Michael Brown</td>
                                            <td>8</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button>Edit</button>
                                                    <button>Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>R004</td>
                                            <td>2024-11-28</td>
                                            <td>21:00</td>
                                            <td>3</td>
                                            <td>Linda Lee</td>
                                            <td>3</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button>Edit</button>
                                                    <button>Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>`;
                        break;

                case "update-offers":
                    mainContent.innerHTML = `
                        <div class="update-offers-section">
                            <h2>Update Offers</h2>

                            <!-- Add New Offer -->
                            <div class="add-new-offer">
                                <h3>Add New Offer</h3>
                                <form class="update-offer-form">
                                    <div class="form-group">
                                        <label for="offer-image">Upload Offer Image</label>
                                        <input type="file" id="offer-image" name="offer-image" accept="image/*" />
                                    </div>
                                    <div class="form-group">
                                        <label for="offer-description">Offer Description</label>
                                        <textarea id="offer-description" name="offer-description" rows="5" placeholder="Describe the offer..."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn submit-offer-btn">Add Offer</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Existing Offers -->
                            <div class="existing-offers">
                                <h3>Existing Offers</h3>
                                <div class="offers-container">
                                    <!-- Example Offer Cards -->
                                    <div class="offer-card">
                                        <img src="path/to/image1.jpg" alt="Offer Image 1" class="offer-image" />
                                        <div class="offer-content">
                                            <h4>50% Off on All Kottu</h4>
                                            <p>Enjoy half-price Kottu this weekend!</p>
                                            <button class="btn delete-btn">Delete</button>
                                        </div>
                                    </div>
                                    <div class="offer-card">
                                        <img src="path/to/image2.jpg" alt="Offer Image 2" class="offer-image" />
                                        <div class="offer-content">
                                            <h4>Free Drink with Any Meal</h4>
                                            <p>Get a free drink with every meal purchase over $10.</p>
                                            <button class="btn delete-btn">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr />

                            <!-- Add New Special Notice -->
                            <div class="add-new-special-notice">
                                <h3>Add New Special Notice</h3>
                                <form class="special-notice-form">
                                    <div class="form-group">
                                        <label for="special-notice-image">Upload Notice Image</label>
                                        <input type="file" id="special-notice-image" name="special-notice-image" accept="image/*" />
                                    </div>
                                    <div class="form-group">
                                        <label for="special-notice-description">Notice Description</label>
                                        <textarea id="special-notice-description" name="special-notice-description" rows="5" placeholder="Add a description for the notice..."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn submit-notice-btn">Add Special Notice</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Existing Special Notices -->
                            <div class="existing-special-notices">
                                <h3>Existing Special Notices</h3>
                                <div class="notices-container">
                                    <!-- Example Notice Cards -->
                                    <div class="notice-card">
                                        <img src="path/to/special-image1.jpg" alt="Special Notice 1" class="notice-image" />
                                        <div class="notice-content">
                                            <h4>Maintenance Notice</h4>
                                            <p>The Nawala branch will be closed for maintenance on Dec 5th.</p>
                                            <button class="btn delete-btn">Delete</button>
                                        </div>
                                    </div>
                                    <div class="notice-card">
                                        <img src="path/to/special-image2.jpg" alt="Special Notice 2" class="notice-image" />
                                        <div class="notice-content">
                                            <h4>Special Event</h4>
                                            <p>Join us for a live music night on Nov 30th at Wattala!</p>
                                            <button class="btn delete-btn">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    break;

                case "staff":
                    mainContent.innerHTML = `
                        <div class="staff-section">
                            <h2>Staff</h2>
                            <p>Manage staff details and roles here.</p>
                        </div>`;
                    break;

                case "feedbacks":
                    mainContent.innerHTML = `
                        <div class="feedbacks-section">
                            <h2>Customer Feedbacks</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Rating</th>
                                        <th>Review</th>
                                        <th>Customer Name</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>5/5</td>
                                        <td>Excellent service and amazing food!</td>
                                        <td>John Doe</td>
                                        <td>2024-11-20</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4/5</td>
                                        <td>Great experience, but waiting time was long.</td>
                                        <td>Jane Smith</td>
                                        <td>2024-11-21</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5/5</td>
                                        <td>The kottu was out of this world!</td>
                                        <td>Michael Brown</td>
                                        <td>2024-11-22</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3/5</td>
                                        <td>Food was good, but the drinks could be better.</td>
                                        <td>Linda Lee</td>
                                        <td>2024-11-23</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>`;
                    break;

                case "order-history":
                    mainContent.innerHTML = `
                        <div class="order-history-section">
                            <h2>Order History</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Customer Name</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#1001</td>
                                        <td>2024-11-20</td>
                                        <td>18:30</td>
                                        <td>John Doe</td>
                                        <td>$45.00</td>
                                        <td>Completed</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>View</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#1002</td>
                                        <td>2024-11-21</td>
                                        <td>19:00</td>
                                        <td>Jane Smith</td>
                                        <td>$25.00</td>
                                        <td>Pending</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>View</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#1003</td>
                                        <td>2024-11-22</td>
                                        <td>20:15</td>
                                        <td>Michael Brown</td>
                                        <td>$60.00</td>
                                        <td>Completed</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>View</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#1004</td>
                                        <td>2024-11-23</td>
                                        <td>17:45</td>
                                        <td>Linda Lee</td>
                                        <td>$30.00</td>
                                        <td>Cancelled</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>View</button>
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



