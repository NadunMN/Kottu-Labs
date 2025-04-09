<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page - Blue Burton Backpack</title>
    <link rel="stylesheet" href="/CSS/offerView.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/CSS/menu.css">

</head>
<body>
    

    <div class="product-container">
        <div class="product-gallery">
            <img src="/Photo/Snapinst.app_461933561_586941926993289_4010305730132216112_n_1080.jpg" class="main-image" alt="Blue Burton Backpack">
        </div>

        <div class="product-info">
            <h1 class="product-title">Blue Burton Backpack</h1>
            <div class="price">$223.00 <span class="original-price">$345.00</span></div>
            <div class="reviews">★★★★☆ (3 Reviews)</div>
            <p class="description">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
            </p>

            

            <div class="quantity-selector">
                <span class="quantity-label">Quantity:</span>
                <div class="quantity-input">
                    <button class="quantity-btn minus">-</button>
                    <input type="number" class="quantity-number" value="1" min="1">
                    <button class="quantity-btn plus">+</button>
                </div>
            </div>

            <div class="action-buttons">
                <button class="btn btn-cart">ADD TO CART</button>
                <!-- <button class="btn btn-wishlist">ADD TO WISHLIST</button> -->
            </div>

            <div class="product-tabs">
                <div class="tab active" data-tab="details">Details</div>
                <div class="tab" data-tab="features">Features</div>
                <div class="tab" data-tab="shipping">Shipping</div>
                <div class="tab" data-tab="care">Care Instruction</div>
            </div>

            <div id="details" class="tab-content active">
                Product details information...
            </div>
            <div id="features" class="tab-content">
                Product features description...
            </div>
            <div id="shipping" class="tab-content">
                Shipping information and policies...
            </div>
            <div id="care" class="tab-content">
                Care instructions and maintenance...
            </div>
        </div>
    </div>

    <!-- Add this section after the product-container div -->
<section class="related-products">
    <h2 class="h2-product">Exclusive Meal Deals</h2>
    
    <div class="product-grid">
        <!-- Product Card 1 -->
        <div class="card">
            <div class="image-div">
            <img src="/Photo/offers/_Start your forever with a delightful symphony of flavors at our wedding breakfast!.jpg" alt="Product Image" class="card-image">
            </div>
            <div class="card-label-wrapper">
            <div class="card-label">
                <p>Available</p>
            </div>

            <div class="card-label-2">
                <p>Classic Kottu</p>
            </div>
            </div>
            <div class="card-content">
            <h2 class="card-title">Product Name</h2>
            <div class="card-price">Rs. 2500/=</div>
            <button class="view-button"><img src="/Photo/icon/shopping-cart.png" alt="">ADD TO CART</button>
            </div>
        </div>

        <!-- Add more product cards as needed -->
    </div>
</section>

    <script src="/JavaScript/offerView.js"></script>
</body>
</html>