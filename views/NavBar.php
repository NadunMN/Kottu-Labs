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

            <ul class="nav-links">
            <li><a href="/"> <img src="/Photo/icon/home.png" alt="">HOME</a></li>
            <hr class="horizonal-line" style="width: 100%; height: 1px;  margin: auto; opacity:0.1;">

            <li><a href="/homeMenu"><img src="/Photo/icon/burger-bar.png" alt="">MENU</a></li>

            <li><a href="/about"><img src="/Photo/icon/info.png" alt="">ABOUT</a></li>

            <li><a href="/staff"><img src="/Photo/icon/receptionist.png" alt="">OUR STAFF</a></li>
            <hr class="horizonal-line" style="width: 100%; height: 1px;  margin: auto; opacity:0.1;">

            <li><a href="/contact"><img src="/Photo/icon/phone-call.png" alt="">CONTACT</a></li>
        </ul>
           
        </div>
        
        <div class="menu-iconbox">
        <div class="icon-box">
            <a href="/cart"><img src="/Photo/icon/shopping-cart.png" alt="Cart"></a>

            <div class="drop-down">
                <a href="#" onclick="toggleMenuprofile()"><img src="/Photo/icon/user.png" alt="Profile"></a>
                <div class="dropdown-content">
                    <a href="/profile"> <img src="/Photo/icon/dashboard - Copy.png" alt=""> DASHBOARD </a>
                    <hr style="width: 100%; height: 1px;  margin: auto; opacity:0.1;">
                    <a href="/offer"> <img src="/Photo/icon/shopping-basket - Copy.png" alt=""> SPECIAL OFFERS</a>
                    <?php if (\app\core\Application::$app->user !== null && \app\core\Application::$app->user->position === 'steward'): ?>
                        <a href="/enterpin"> <img src="/Photo/icon/key.png" alt=""> ENTER PIN</a>
                    <?php endif; ?>
                    <?php if (\app\core\Application::$app->user ==null): ?>
                        <a href="/login"> <img src="/Photo/icon/enter.png" alt=""> LOG IN</a>
                        <?php else: ?>
                            <a href="/logout"> <img src="/Photo/icon/logout.png" alt=""> LOG OUT</a>
                    <?php endif; ?>
                    <hr style="width: 100%; height: 1px;  margin: auto;opacity:0.1; ">
                    <a onclick="window.location.href='/about#container3'"> WHY CREATE AN ACCOUNT?</a>

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