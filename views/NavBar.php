<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NavBar</title>
    <link rel="stylesheet" href="/CSS/NavBar.css">
</head>
<body>
    <div class="main-div home-main-div">
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
            <a id="cart-id" href="/cart"><img src="/Photo/icon/shopping-cart.png" alt="Cart"></a>

            <div class="drop-down">
                <a href="#" onclick="toggleMenuprofile()"><img src="/Photo/icon/user.png" alt="Profile"></a>
                <div class="dropdown-content">
                    <a href="/profile"> <img class="drop-icon" src="/Photo/icon/dahsboard.png" alt=""> Dashboard </a>
                    <!-- <hr style="width: 100%; border:0.5px solid black; background:black; margin: auto; "> -->
                    <a href="/offer"> <img class="drop-icon" src="/Photo/icon/special-offer.png" alt=""> Special Offers</a>
                    <?php if (\app\core\Application::$app->user !== null && \app\core\Application::$app->user->position === 'steward'): ?>
                        <a href="/menuaccess"> <img class="drop-icon" src="/Photo/icon/enterpin.png" alt=""> Enter Pin</a>
                        <a href="/unregmenu"> <img class="drop-icon" src="/Photo/icon/enterpin.png" alt=""> UnRegistered Menu</a>
                        <a href="/unregpayment"> <img class="drop-icon" src="/Photo/icon/enterpin.png" alt=""> Payment Collection</a>

                    <?php endif; ?>
                    <?php if (\app\core\Application::$app->user ==null): ?>
                        <a href="/login"> <img class="drop-icon" src="/Photo/icon/login.png" alt=""> Log In</a>
                        <?php else: ?>
                            <a href="/logout"> <img class="drop-icon" src="/Photo/icon/logout.png" alt=""> Log Out</a>
                    <?php endif; ?>
                    <!-- <hr style="width: 100%; height: 2px; border:2px solid black; background:black; margin: auto; "> -->
                    <a onclick="window.location.href='/about#container3'"> Why create an Account?</a>

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