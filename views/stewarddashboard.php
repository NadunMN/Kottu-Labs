<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/CSS/managerDashboard.css">
    <style>
        /* Ensure the iframe fits the container */
iframe {
    width: 100%;            /* Make the iframe responsive to the container width */
    border: none;           /* Remove default border for a cleaner look */
    overflow: hidden;       /* Prevent scrolling inside the iframe */
    display: block;         /* Remove inline spacing issues */
    height: auto;           /* Allow dynamic height adjustment */
    transition: height 0.3s ease; /* Smooth height transition for dynamic resizing */
    

}

/* Hide scrollbars in WebKit browsers (Chrome, Safari) */
iframe::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbars in Firefox */
iframe {
    scrollbar-width: none;   /* Hides the scrollbar track and thumb */
}

/* Hide scrollbars in IE/Edge */
iframe {
    -ms-overflow-style: none; /* For Internet Explorer and Edge */
}

    </style>

</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
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
            <iframe id="dynamicIframe" src="/initialPage.html"></iframe>
        </div>
    </div>

    <script src="/JavaScript/stewardDashboard.js"></script>
</body>
</html>
