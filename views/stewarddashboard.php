<!-- <h1>steward Dashboard</h1>-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/CSS/stewardDashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <?php
                $menuItems = [
                    ['id' => 'view-order-status', 'icon' => '/Photo/icon/orderstatus.png', 'text' => 'View Order Status'],
                    ['id' => 'customer-arrivals', 'icon' => '/Photo/icon/customerarrival.png', 'text' => 'Customer Arrivals'],
                    ['id' => 'customer-payments', 'icon' => '/Photo/icon/payment.png', 'text' => 'Customer Payments']
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
        <div class="main-content" id="main-content">
            <h2>Select an option from the sidebar</h2>
        </div>
    </div>

    <script src="/JavaScript/stewardDashboard.js"></script>
</body>
</html>










