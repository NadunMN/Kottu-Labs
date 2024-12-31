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
                        ['id' => 'viewOrderStatus', 'icon' => '/Photo/icon/orderstatus.png', 'text' => 'View Order Status'],
                        ['id' => 'customerArrivals', 'icon' => '/Photo/icon/customerarrival.png', 'text' => 'Customer Arrivals'],
                        ['id' => 'customerPayments', 'icon' => '/Photo/icon/payment.png', 'text' => 'Customer Payments']
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

    <script src="/JavaScript/stewardDashboard.js"></script>
</body>
</html>
