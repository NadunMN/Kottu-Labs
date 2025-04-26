<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Kottu Labs</title>
    <link rel="stylesheet" href="/CSS/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>

    <div class="menu-topic">
        <h1>Kottu Labs Menu</h1>
        <p>Explore the Boundless Possibilities of Taste, One Meal at a Time</p>
    </div>

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
            <button class="search-button-menu" >Search</button>
            </div>
        </div>


    

    </div>

    </div>

    

    <div class="menu-container">
        <p class="how-many">0 Meals Available</p>
        <div class="menu-items">
            
        



        
        </div>
    </div>

    <script src="/JavaScript/stewardMenu.js"></script>

    

</body>
</html>

