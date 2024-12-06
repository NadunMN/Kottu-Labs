<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Kottu Labs</title>
    <link rel="stylesheet" href="/CSS/menu.css">
</head>
<body>
  
    
    <div class="search-container">
        <input type="text" id="search" placeholder="Search menu items...">
        <div class="menu-icon">
            <a href="#" id="menu-icon">
                <img src="/Photo/icon/sidebar.png" alt="Menu">
            </a>
            
        </div>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-close">
            <a href="#" id="close-icon">
                <img src="/Photo/icon/close.png" alt="close">
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

    <div class="category-dropdown">
    <select id="category-select">
        <option value="Appetizers">Appetizers</option>
        <option value="Pasta">Pasta</option>
        <option value="Dolphin Kottu">Dolphin Kottu</option>
        <option value="KL Inventions">KL Inventions</option>
        <option value="Wraps & Rotti Sandwiches">Wraps & Rotti Sandwiches</option>
        <option value="Parata">Parata</option>
        <option value="Devilled Portions">Devilled Portions</option>
        <option value="KL Special Fried Rice">KL Special Fried Rice</option>
        <option value="Classic Kottu">Classic Kottu</option>
        <option value="Cheese Kottu">Cheese Kottu</option>
        <option value="String Hopper Kottu">String Hopper Kottu</option>
        <option value="Mocktails">Mocktails</option>
        <option value="Beverages">Beverages</option>
    </select>
    </div>
=
    <div class="menu-container">
        <h1>Our Menu</h1>
        <div class="menu-items"></div>
    </div>



    <script src="/JavaScript/menu.js"></script>
    
</body>
</html>
