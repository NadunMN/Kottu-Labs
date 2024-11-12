<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NavBar</title>
    <link rel="stylesheet" href="/CSS/NavBar.css">
</head>
<body>
    <div class="main-div">
        <div class="logo">
            <div class="logo-img">
                
            </div>
           
        </div>
        <ul class="nav-links">
            <li><a href="/">HOME</a></li>
            <li><a href="#">MENU</a></li>
            <li><a href="#">ABOUT</a></li>
            <li><a href="#">OUR STAFF</a></li>
            <li><a href="contact">CONTACT</a></li>
        </ul>
        <div class="menu-iconbox">
        <div class="icon-box">
            <a href="#"><img src="/Photo/icon/search.png" alt="Search"></a>
            <a href="#"><img src="/Photo/icon/shopping-cart.png" alt="Cart"></a>

            <div class="drop-down">
                <a href="#" onclick="toggleMenuprofile()"><img src="/Photo/icon/user.png" alt="Profile"></a>
                <div class="dropdown-content">
                    <a href="/profile">DASHBOARD</a>
                    <a href="/myaccount">MY ACCOUNT</a>
                    <a href="#">WHY CREATE AN ACCOUNT?</a>
                    <?php if (\app\core\Application::$app->user ==null): ?>
                        <a href="/login">LOG IN</a>
                        <?php else: ?>
                            <a href="/logout">LOG OUT</a>
                    <?php endif; ?>
                </div>
            </div>

                <?php if (\app\core\Application::$app->user ==null): ?>
                    <button class="login-button-special" onclick="window.location.href = '/login'">SIGN IN</button>                <?php endif; ?>

        </div>
        <button class="menu-icon" onclick="toggleMenu()">&#9776;</button> <!-- Menu Icon -->
        </div>
    </div>
    <script src="/JavaScript/NavBar.js"></script>
</body>
</html>