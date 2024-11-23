<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/CSS/managerDashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li id="view-users">
                    <img src="/Photo/icon/users.png" alt="View Users">
                    <a href="#viewUsers">View Users</a>
                </li>
                <li id="update-menu">
                    <img src="/Photo/icon/menu.png" alt="Update Menu">
                    <a href="#updateMenu">Update Menu</a>
                </li>
                <li id="view-reservations">
                    <img src="/Photo/icon/reservations.png" alt="View Reservations">
                    <a href="#viewReservations">View Reservations</a>
                </li>
                <li id="update-offers">
                    <img src="/Photo/icon/offers.png" alt="Update Offers">
                    <a href="#updateOffers">Update Offers</a>
                </li>
                <li id="staff">
                    <img src="/Photo/icon/staff.png" alt="Staff">
                    <a href="#staff">Staff</a>
                </li>
                <li id="feedbacks">
                    <img src="/Photo/icon/feedback.png" alt="Feedbacks">
                    <a href="#feedbacks">Feedbacks</a>
                </li>
                <li id="order-history">
                    <img src="/Photo/icon/orderhistory.png" alt="Order History">
                    <a href="#orderHistory">Order History</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <!-- Content will be loaded here via AJAX -->
        </div>
    </div>

    <script src="/JavaScript/managerDashboard.js"></script>
</body>
</html>








