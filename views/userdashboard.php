<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

            <div class="horizontal-line"></div>
        <div class="order-history">
            <!-- order list -->
            <div class="order-list-container">
                <h2>Reservation History</h2>
                
            </div>


            <div class="table-container">


                <!-- Table Header -->
                <div class="table-header">
                    <div>CODE</div>
                    <div>NAME</div>
                    <div>QUANTITY</div>
                    <div>TYPE</div>
                    <div>STATUS</div>
                    <div>UNIT PRICE</div>
                </div>

                <!-- Table Rows -->
                <div class="table-row">
                    <div>001</div>
                    <div>Product A</div>
                    <div>10</div>
                    <div>Dine in</div>
                    <div>In Stock</div>
                    <div>$15.00</div>
                </div>
                <div class="table-row">
                    <div>002</div>
                    <div>Product B</div>
                    <div>5</div>
                    <div>Take away</div>
                    <div>Out of Stock</div>
                    <div>$25.00</div>
                </div>
                <div class="table-row">
                    <div>003</div>
                    <div>Product C</div>
                    <div>12</div>
                    <div>Take away</div>
                    <div>Low Stock</div>
                    <div>$18.00</div>
                </div>

            </div>

            <div class="order-list-container order-list-container-down">
                <!-- <h2>Order History</h2> -->
                <div class="order-list-button">
                    <button>View More</button>
                    <button>Add Reservation</button>
                </div>
            </div>

        </div>


            <!--Add reviews -->
            <div class="add-review-list-container">

                <div class="add-review-list-topic">
                    <h2>Add Reviews</h2>
                    <div class="review-list-button">
                    </div>
                </div>
                <form class="form" id="add-form" action="" method="POST">
                    <div class="add-reviews-body-container">

                        <div class="add-review-header">
                            <div class="review-name">

                                <div class="review-rate add">
                                    <div class="starts s">
                                        <div class="box"></div>
                                        <div class="box"></div>
                                        <div class="box"></div>
                                        <div class="box"></div>
                                        <div class="box"></div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <hr style="border: 1px solid #ccc; width: 100%; margin-top: 20px; opacity:0.5; width: 90%;">


                        <div class="add-review-body">
                            <textarea id="review-content" name='review' placeholder="Write your review here..."></textarea>
                        </div>

                    </div>

                    <div class="add-review-submit">
                        <div class="order-list-button add-review-cancel">
                            <!-- <button id="submit">Cancel</button> -->
                            <button type="submit" id="add-review" name="submit"  value="Submit"> submit </button>
                        </div>
                    </div>

                </form>


            </div>


            <!-- reviews -->
            <div class="review-list-container">

                <div class="review-list-topic">
                    <h2>My Reviews</h2>
                    
                </div>


                <div class="review-list-number">
                    <!-- first part -->
                    <div class="first-part">
                        <h1 id="Main-rating-value">0</h1>
                        <div class="starts" id="Main-rating-stars"></div>
                        <h4 id="rating-quantity">35K Reviews</h4>

                    </div>
                    <!-- second part -->
                    <div class="second-part">
                        <div class="part">
                            <div>
                                <div id="line-1" class="line" style="height:100%; background-color:#EE3E3F"></div>
                            </div>
                            <h4 id="rating-line-1">0</h4>
                            <h5 id="rating-quantity-line" class="rating-quantity-line">0 reviews</h5>
                        </div>


                        <div class="part">
                        <div>
                                <div id="line-2" class="line" style="height:100%; background-color:#EE3E3F"></div>
                        </div>
                            <h4 id="rating-line-2">0</h4>
                            <h5 class="rating-quantity-line">0 reviews</h5>
                        </div>


                        <div class="part">
                            <div>
                                <div id="line-3" class="line" style="height:100%; background-color:#EE3E3F"></div>
                            </div>
                            <h4 id="rating-line-3">0</h4>
                            <h5  class="rating-quantity-line">0 reviews</h5>
                        </div>


                        <div class="part">
                            <div>
                                <div id="line-4" class="line" style="height:100%; background-color:#EE3E3F"></div>
                            </div>
                            <h4 id="rating-line-4">0</h4>
                            <h5  class="rating-quantity-line">0 reviews</h5>
                        </div>


                        <div class="part">
                            <div>
                                <div id="line-5" class="line" style="height:100%; background-color:#EE3E3F"></div>
                            </div>
                            <h4 id="rating-line-5">0</h4>
                            <h5  class="rating-quantity-line">0 reviews</h5>
                        </div>



                    </div>
                </div>

                <div class="review-subject">

                    <div>
                        <h5 id="revire-subject-1">0.0</h5>
                        <h5>Cleanliness</h5>
                    </div>

                    <div>
                        <h5 id="revire-subject-2">0.0</h5>
                        <h5>Safety & Security</h5>
                    </div>

                    <div>
                        <h5 id="revire-subject-3">0.0</h5>
                        <h5>Staff</h5>
                    </div>

                    <div>
                        <h5 id="revire-subject-4">0.0</h5>
                        <h5>Amenties</h5>
                    </div>

                    <div>
                        <h5 id="revire-subject-5">0.0</h5>
                        <h5>Location</h5>
                    </div>

                </div>


                <div class="reviews-content" id="reviewsContent"></div>

            </div>



        </div>
    </div>
    </div>

    <script src="/JavaScript/addReview.js"></script>


</body>

</html>