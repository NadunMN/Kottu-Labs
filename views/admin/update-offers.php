<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/managerDashboard.css">
</head>

<body>

    <div class="view-branch-menu-section" id="main-content"> 

                        <div class="update-offers-section">
                            <h2>Update Offers</h2>

                            <!-- Add New Offer -->
                            <div class="add-new-offer">
                                <h3>Add New Offer</h3>
                                <form class="update-offer-form ">
                                    <div class="form-group">
                                        <label for="offer-image">Upload Offer Image</label>
                                        <input type="file" id="offer-image" name="offer-image" accept="image/*" />
                                    </div>
                                    <div class="form-group">
                                        <label for="offer-description">Offer Description</label>
                                        <textarea id="offer-description" name="offer-description" rows="5" placeholder="Describe the offer..."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn submit-offer-btn">Add Offer</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Existing Offers -->
                            <div class="existing-offers">
                                <h3>Existing Offers</h3>
                                <div class="offers-container">
                                    <!-- Example Offer Cards -->
                                    <div class="offer-card">
                                        <img src="path/to/image1.jpg" alt="Offer Image 1" class="offer-image" />
                                        <div class="offer-content">
                                            <h4>50% Off on All Kottu</h4>
                                            <p>Enjoy half-price Kottu this weekend!</p>
                                            <button class="btn delete-btn">Delete</button>
                                        </div>
                                    </div>
                                    <div class="offer-card">
                                        <img src="path/to/image2.jpg" alt="Offer Image 2" class="offer-image" />
                                        <div class="offer-content">
                                            <h4>Free Drink with Any Meal</h4>
                                            <p>Get a free drink with every meal purchase over $10.</p>
                                            <button class="btn delete-btn">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            
    </div>

    <script src="/JavaScript/admin/updateOffers.js"></script>
</body>

</html>