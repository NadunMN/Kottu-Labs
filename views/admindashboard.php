<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/CSS/managerDashboard.css">

    <style>
    /* Hide scrollbar for iframe in all modern browsers */
    iframe {
        -ms-overflow-style: none; /* For Internet Explorer 10+ */
        scrollbar-width: none;    /* For Firefox */
        overflow: hidden;         /* For other browsers (prevents scrolling on iframe itself) */
    }

    iframe::-webkit-scrollbar {
        display: none;  /* For Chrome, Safari */
    }

</style>

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
                        ['id' => 'updatemenu', 'icon' => '/Photo/icon/menu.png', 'text' => 'Update Menu'],
                        ['id' => 'viewreservations', 'icon' => '/Photo/icon/booking (1).png', 'text' => 'View Reservations'],
                        ['id' => 'updateoffers', 'icon' => '/Photo/icon/shopping-basket.png', 'text' => 'Update Offers'],
                        ['id' => 'feedbacks', 'icon' => '/Photo/icon/review.png', 'text' => 'Feedbacks'],
                        ['id' => 'orderhistory', 'icon' => '/Photo/icon/shopping-bag.png', 'text' => 'Order History'],
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
        <div class="main-content admin-main-content" id="main-content">
            <iframe id="dynamicIframe" src="" width="100%" height="100%" frameborder="0"></iframe>
        </div>
    </div>

    <script src="/JavaScript/adminDashboard.js"></script>
</body>
</html>
