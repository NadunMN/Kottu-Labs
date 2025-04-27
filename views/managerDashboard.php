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
                    ['id' => 'update-menu', 'icon' => '/Photo/icon/menu (1).png', 'text' => 'Update Menu'],
                    ['id' => 'view-reservations', 'icon' => '/Photo/icon/reservation.png', 'text' => 'View Reservations'],
                    ['id' => 'feedbacks', 'icon' => '/Photo/icon/review.png', 'text' => 'Feedbacks'],
                    ['id' => 'order-history', 'icon' => '/Photo/icon/history.png', 'text' => 'Order History'],
                    
                ];
                foreach ($menuItems as $item) {
                    echo "<li id='{$item['id']}'>
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
        <div id="branchDisplay" class="branch-display"></div>
        </div>

</div>

       

    <script src="/JavaScript/managerDashboard.js"></script>
</body>
</html>










