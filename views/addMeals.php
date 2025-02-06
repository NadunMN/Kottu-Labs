<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Kottu Labs</title>
    <link rel="stylesheet" href="/CSS/menu.css">
</head>
<body>

    <div class="search-container-wrapper">

    <div class="search-container">



        <select class="search-select" id="branch-select">
            <option value="1">Wattala</option>
            <option value="2">Kelaniya</option>
            <option value="3">Kotahena</option>
        </select>


        <select class="search-select-2" id="search-selection-2">
            <option  value="1">All</option>
            <option  value="2">Classic Kottu</option>
            <option  value="3">Dolphin Kottu</option>
            <option  value="4">Cheese Kottu</option>
            <option  value="5">String Hopper Kottu</option>
            <option  value="6">KL Special Fried Rice</option>
            <option  value="7">Pasta</option>
            <option  value="8">Appetizers</option>
            <option  value="9">KL Inventions</option>
            <option  value="10">Wraps & Rotti Sandwiches</option>
            <option  value="11">Parata</option>
            <option  value="12">Devilled Portions</option>
            <option  value="13">Mocktails</option>
            <option  value="14">Beverages</option>
        </select>

        <div class="search-bar">
            <input type="text" id="search" placeholder="Search menu items...">
            <div class="search-icon">
            <img src="/Photo/icon/search.png" alt="">
            <button >Search</button>
            </div>
        </div>

        <button id="done-button" disabled>Done</button>
    

    </div>

    </div>

    

    <div class="menu-container">
        <p class="how-many">Showing 12 Meals</p>
        <div class="menu-items">
        
        </div>
    </div>

    <script src="/JavaScript/addMeals.js"></script>

    

</body>
</html>

