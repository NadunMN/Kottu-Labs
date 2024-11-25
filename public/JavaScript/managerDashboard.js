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
                    mainContent.innerHTML = `
                        <div class="view-branch-menu-section">
                            <h2>Branch: Nawala</h2> <!-- You can dynamically replace 'Nawala' based on the selected branch -->
                            <table class="menu-table">
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
                                <tbody>
                                    <tr>
                                        <td>001</td>
                                        <td>Kottu</td>
                                        <td>Main</td>
                                        <td>$10</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="edit-btn">Edit</button>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="status-btn available">Available</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>002</td>
                                        <td>Rice</td>
                                        <td>Main</td>
                                        <td>$8</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="edit-btn">Edit</button>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="status-btn unavailable">Unavailable</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>003</td>
                                        <td>Roti</td>
                                        <td>Side</td>
                                        <td>$5</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="edit-btn">Edit</button>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="status-btn available">Available</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>004</td>
                                        <td>Beverage</td>
                                        <td>Drink</td>
                                        <td>$3</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="edit-btn">Edit</button>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="status-btn unavailable">Unavailable</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>`;

                    // Add event listeners to the status buttons to toggle availability
                    const statusButtons = document.querySelectorAll('.status-btn');

                    statusButtons.forEach(button => {
                        button.addEventListener('click', () => {
                            // Toggle status class and text between Available/Unavailable
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
                                                </div>
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
                                    <p>Modify active offers here.</p>
                                        
                                    <!-- Update Offer Form -->
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
                                            <button type="submit" class="update-offer-btn">Update Offer</button>
                                        </div>
                                    </form>
                        
                                    <!-- Posted Offers Section -->
                                    <div class="posted-offers">
                                        <h3>Posted Offers</h3>
                                        <div class="offers-container">
                                            <!-- Example Offer Cards -->
                                            <div class="offer-card">
                                                <img src="path/to/image1.jpg" alt="Offer Image 1" class="offer-image" />
                                                <div class="offer-content">
                                                    <h4>50% Off on All Kottu</h4>
                                                    <p>Enjoy half-price Kottu this weekend!</p>
                                                    <button class="delete-btn">Delete</button>
                                                </div>
                                            </div>
                                            <div class="offer-card">
                                                <img src="path/to/image2.jpg" alt="Offer Image 2" class="offer-image" />
                                                <div class="offer-content">
                                                    <h4>Free Drink with Any Meal</h4>
                                                    <p>Get a free drink with every meal purchase over $10.</p>
                                                    <button class="delete-btn">Delete</button>
                                                </div>
                                            </div>
                                            <!-- Add more offer cards dynamically as needed -->
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





