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
        <div class="company-header">
            <div class="company-name">Kottu Labs</div>
            <div class="company-title">
                <div class="logo">K</div>
                <div class="name">Kottu Labs</div>
            </div>
        </div>
        
        <ul>
            <li id="home" class="menu-item">
                <img src="/Photo/icon/home.png" alt="Home">
                <a href="/">Home</a>
            </li>
        </ul>

        <div class="section-header">GENERAL</div>
         <ul>
                <?php use app\core\Application; ?>
                <?php
                    $menuItems = [
                        ['id' => 'dashboard', 'icon' => '/Photo/icon/dahsboard.png', 'text' => 'DashBoard'],
                        ['id' => 'staff', 'icon' => '/Photo/icon/manager.png', 'text' => 'Update Staff'],
                        ['id' => 'updatemenu', 'icon' => '/Photo/icon/menu (1).png', 'text' => 'Update Menu'],
                        ['id' => 'updateoffers', 'icon' => '/Photo/icon/offer.png', 'text' => 'Update Offers'],
                        ['id' => 'feedbacks', 'icon' => '/Photo/icon/review (1).png', 'text' => 'Feedbacks'],
                    ];
                    foreach ($menuItems as $item) {
                        echo "<li id='{$item['id']}' class='menu-item'>
                                <img src='{$item['icon']}' alt='{$item['text']}'>
                                <a href='#'>{$item['text']}</a>
                            </li>";
                    }
                ?>
            </ul>


        <div class="section-header">SETTINGS</div>

        <ul>

            <?php if(Application::$app->user):?>
                <li id="home" class="menu-item">
                <img src="/Photo/icon/user-interface.png" alt="Home">
                <a href="/logout">Logout</a>
                </li>
            <?php else: ?>
            <li id="home" class="menu-item">
                <img src="/Photo/icon/home.png" alt="Home">
                <a href="/">Login</a>
            </li>
            <?php endif; ?>


        </ul>
        

    </div>
    

        <!-- Your main content here -->
          
        <!-- Main Content -->
        <div class="main-content admin-main-content" id="main-content">
            <iframe id="dynamicIframe" src="/initialPage.html"></iframe>
        </div>

</div>

    <script src="/JavaScript/adminDashboard.js"></script>
    
</body>
</html>
