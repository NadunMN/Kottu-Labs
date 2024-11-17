<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Kottu Labs</title>
    <link rel="stylesheet" href="/CSS/menu.css">
</head>
<body>
    <!-- Include the navbar -->
    <?php include 'navbar.php'; ?>
    
    <div class="search-container">
        <input type="text" id="search" placeholder="Search menu items...">
        <div class="menu-icon">
            <a href="#" id="menu-icon">
                <img src="/Photo/icon/menu.png" alt="Menu">
            </a>
            <span>0</span>
        </div>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-close">
            <a href="#" id="close-icon">
                <img src="/Photo/icon/close-icon.png" alt="close">
            </a>
        </div>
        <div class="cart-menu">
            <h3>My Cart</h3>
            <div class="cart-items" id="cart-items"></div>
        </div>
        
        <div class="sidebar--footer">
            <div class="total--amount">
                <h5>TOTAL</h5>
                <div class="cart-total">Rs 00.00</div>
            </div>
            <button class="checkout-btn">Checkout</button>
        </div>
    </div>

    <div class="category-tabs">
        <button class="tab active" data-category="Appetizers">Appetizers</button>
        <button class="tab" data-category="Pasta">Pasta</button>
        <button class="tab" data-category="Dolphin Kottu">Dolphin Kottu</button>
        <button class="tab" data-category="KL Inventions">KL Inventions</button>
        <button class="tab" data-category="Wraps & Rotti Sandwiches">Wraps & Rotti Sandwiches</button>
        <button class="tab" data-category="Parata">Parata</button>
        <button class="tab" data-category="Devilled Portions">Devilled Portions</button>
        <button class="tab" data-category="KL Special Fried Rice">KL Special Fried Rice</button>
        <button class="tab" data-category="Classic Kottu">Classic Kottu</button>
        <button class="tab" data-category="Cheese Kottu">Cheese Kottu</button>
        <button class="tab" data-category="String Hopper Kottu">String Hopper Kottu</button>
        <button class="tab" data-category="Mocktails">Mocktails</button>
        <button class="tab" data-category="Beverages">Beverages</button>

    </div>

    <div class="menu-container">
        <h1>Our Menu</h1>
        <div class="menu-items"></div>
    </div>

    <div id="footer"></div>

    <script src="/JavaScript/menu.js"></script>
    
</body>
</html>
