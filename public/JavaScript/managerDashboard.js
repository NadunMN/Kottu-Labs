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
                        <div class="update-menu-section">
                            <h2>Update Menu</h2>
                            <p>Update the restaurant menu here.</p>
                        </div>`;
                    break;

                case "view-reservations":
                    mainContent.innerHTML = `
                        <div class="view-reservations-section">
                            <h2>View Reservations</h2>
                            <p>List of reservations will appear here.</p>
                        </div>`;
                    break;

                case "update-offers":
                    mainContent.innerHTML = `
                        <div class="update-offers-section">
                            <h2>Update Offers</h2>
                            <p>Modify active offers here.</p>
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
                            <h2>Feedbacks</h2>
                            <p>View customer feedback here.</p>
                        </div>`;
                    break;

                case "order-history":
                    mainContent.innerHTML = `
                        <div class="order-history-section">
                            <h2>Order History</h2>
                            <p>List of past orders will appear here.</p>
                        </div>`;
                    break;

                default:
                    mainContent.innerHTML = `<h2>${optionId.replace("-", " ")}</h2><p>Content for this section will go here.</p>`;
                    break;
            }
        });
    });
});





