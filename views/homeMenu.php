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

    <div class="menu-container">
        <h1>Our Menu</h1>
        <div class="menu-items"></div>
    </div>

    <script src="/JavaScript/homeMenu.js"></script>
</body>
</html>

