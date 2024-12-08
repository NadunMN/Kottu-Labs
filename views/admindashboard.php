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
                <?php
                    $menuItems = [
                        ['id' => 'dashboard', 'icon' => '/Photo/icon/dashboard.png', 'text' => 'DashBoard'],
                        ['id' => 'staff', 'icon' => '/Photo/icon/receptionist.png', 'text' => 'Update Staff'],
                        ['id' => 'update-menu', 'icon' => '/Photo/icon/menu.png', 'text' => 'Update Menu'],
                        ['id' => 'view-reservations', 'icon' => '/Photo/icon/booking (1).png', 'text' => 'View Reservations'],
                        ['id' => 'update-offers', 'icon' => '/Photo/icon/shopping-basket.png', 'text' => 'Update Offers'],
                        ['id' => 'feedbacks', 'icon' => '/Photo/icon/review.png', 'text' => 'Feedbacks'],
                        ['id' => 'order-history', 'icon' => '/Photo/icon/shopping-bag.png', 'text' => 'Order History'],
                    ];
                    foreach ($menuItems as $item) {
                        echo "<li id='{$item['id']}' class='menu-item'>
                                <img src='{$item['icon']}' alt='{$item['text']}'>
                                <a href='#'>{$item['text']}</a>
                            </li>";
                    }
                    ?>

            </ul>
        </div>
       


        
        <!-- Main Content -->
        <div class="main-content" id="main-content">

        </div>

    <script src="/JavaScript/adminDashboard.js"></script>
</body>
</html>
