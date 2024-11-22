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
                <h2>Order History</h2>
                
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
                    <!-- <div class="review-list-button">
            <button>Add Review</button>
        </div> -->
                </div>


                <div class="review-list-number">
                    <!-- first part -->
                    <div class="first-part">
                        <h1>4.5</h1>
                        <div class="starts">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <h4>35K reviews</h4>

                    </div>
                    <!-- second part -->
                    <div class="second-part">
                        <div class="part">
                            <div></div>
                            <h4>4.0</h4>
                            <h5>35K reviews</h5>
                        </div>


                        <div class="part">
                            <div></div>
                            <h4>4.0</h4>
                            <h5>35K reviews</h5>
                        </div>


                        <div class="part">
                            <div></div>
                            <h4>4.0</h4>
                            <h5>35K reviews</h5>
                        </div>


                        <div class="part">
                            <div></div>
                            <h4>4.0</h4>
                            <h5>35K reviews</h5>
                        </div>


                        <div class="part">
                            <div></div>
                            <h4>4.0</h4>
                            <h5>35K reviews</h5>
                        </div>


                        <div class="part">
                            <div></div>
                            <h4>4.0</h4>
                            <h5>35K reviews</h5>
                        </div>


                    </div>
                </div>

                <div class="review-subject">

                    <div>
                        <h5>4.0</h5>
                        <h5>cleanliness</h5>
                    </div>

                    <div>
                        <h5>4.0</h5>
                        <h5>safety & security</h5>
                    </div>

                    <div>
                        <h5>4.0</h5>
                        <h5>staff</h5>
                    </div>

                    <div>
                        <h5>4.0</h5>
                        <h5>amenties</h5>
                    </div>

                    <div>
                        <h5>4.0</h5>
                        <h5>location</h5>
                    </div>

                </div>

                <div class="reviews-content">

                    <div class="review">
                        <div class="review-header">
                            <div class="review-name">
                                <div></div>
                                <h4>Nadun Madusankan</h4>
                                <h6>4 months ago</h6>
                            </div>

                            <div class="review-rate">
                                <h5>4.5</h5>
                                <div class="starts">
                                    <div class='review-rate-start'></div>
                                    <div class='review-rate-start'></div>
                                    <div class='review-rate-start'></div>
                                    <div class='review-rate-start'></div>
                                    <div class='review-rate-start'></div>
                                </div>
                            </div>
                        </div>

                        <div class="review-body">
                            <p>I had an amazing experience at this restaurant! The ambiance was warm and inviting,
                                and the staff was incredibly attentive and friendly. Each dish was beautifully presented and bursting with flavor
                                you can tell they use fresh, quality ingredients. From appetizers to dessert, everything was perfect.
                                I highly recommend this place for anyone looking for a memorable dining experience. Can't wait to come back!</p>
                        </div>

                    </div>

                    <div class="review">
                        <div class="review-header">
                            <div class="review-name">
                                <div></div>
                                <h4>Ranuga Lekawasam</h4>
                                <h6>4 months ago</h6>
                            </div>

                            <div class="review-rate">
                                <h5>3.8</h5>
                                <div class="starts">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>

                        <div class="review-body">
                            <p>"The food here is fantastic! Every dish is fresh, full of flavor, and presented with care. The menu has something for everyone,
                                from classic favorites to unique options that surprise and delight. Perfect for anyone who loves a great meal!"</p>
                        </div>

                    </div>

                </div>
            </div>



        </div>
    </div>
    </div>

    <script src="/JavaScript/addReview.js"></script>


</body>

</html>