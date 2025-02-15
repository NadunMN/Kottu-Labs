<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/CSS/chefdashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <?php
                $menuItems = [
                    // ['id' => 'view-users', 'icon' => '/Photo/icon/users.png', 'text' => 'View Users'],
                    ['id' => 'update-menu', 'icon' => '/Photo/icon/menu.png', 'text' => 'Update Menu'],
                    // ['id' => 'view-reservations', 'icon' => '/Photo/icon/reservations.png', 'text' => 'View Reservations'],
                    // ['id' => 'update-offers', 'icon' => '/Photo/icon/offers.png', 'text' => 'Update Offers'],
                    // ['id' => 'staff', 'icon' => '/Photo/icon/staff.png', 'text' => 'Staff'],
                    // ['id' => 'feedbacks', 'icon' => '/Photo/icon/feedback.png', 'text' => 'Feedbacks'],
                    ['id' => 'view-orders', 'icon' => '/Photo/icon/orderhistory.png', 'text' => 'View Orders'],
                    // ['id' => 'reports', 'icon' => '/Photo/icon/reports.png', 'text' => 'Reports'],
                    // ['id' => 'new-item', 'icon' => '/Photo/icon/newitem.png', 'text' => 'New Item']
                ];
                foreach ($menuItems as $item) {
                    echo "<li id='{$item['id']}'>
                            <img src='{$item['icon']}' alt='{$item['text']}'>
                            <a href='#'>{$item['text']}</a>
                        </li>";
                }
                ?>
            </ul>
        </div>


        
        <!-- Main Content -->
        <div class="main-content" id="main-content"></div>

    <script src="/JavaScript/chefdashboard.js"></script>
</body>
</html>










