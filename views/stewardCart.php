<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Shopping Cart</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/CSS/cart.css" rel="stylesheet">
</head>
<body>
    <div class="container-x">
        <!-- Left Column - Cart -->
        <div class="cart-section">
            <div class="cart-header">
                <h1>Shopping Cart</h1>
                <div class="header-buttons">
                    <button class="btn btn-outline" id="clearCartBtn">Clear Cart</button>
                    <button class="btn btn-dark" id="addItemBtn" onclick="window.location.href='/homeMenu'">Add Item</button>
                </div>
            </div>

            <div class="cart-items" id="cartItemsContainer">
                <!-- Cart items will be dynamically inserted here -->
            </div>
        </div>

        <!-- Right Column - Summary and Booked Items -->
        <div class="summary-section-right">
            <div class="summary-section">
                <h2 class="summary-header">Summary Order</h2>

                <div class="summary-row">
                    <span>Current total</span>
                    <span id="allOrderTotal">Rs.0.00</span>
                </div>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="subtotal">Rs.0.00</span>
                </div>
                <button class="btn btn-dark btn-full" id="bookingBtn">Booking(0)</button>
                <button class="btn btn-dark btn-full" id="payNowBtn">Pay Now</button>
            </div>

            
        </div>
    </div>

    <script src="/JavaScript/cart.js"></script>
</body>
</html>