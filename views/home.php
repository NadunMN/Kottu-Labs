<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NavBar</title>
    <link rel="stylesheet" href="/CSS/NavBar.css">
    <link rel="stylesheet" href="/CSS/userdashboard.css">
</head>
<body>



    <div class="home-top-main">
        <div class="first-background-img">
            <div class="first-background-overlay">
                <p class="Header-text">Enjoy your,<br/> SL Comfort Food Kottu</p>
                <p class="Sub-text">
                Experience the authentic taste of Sri Lanka with our signature Kottu dishes!</br>
                we’re ready to serve you with freshly made Kottu that's packed with flavor.
                </p>
                <div class="button-div">
                <div class="button-container button-container-second">

                    <button onclick="window.location.href='#topic-head'">BOOKING</button>
                <?php if (\app\core\Application::$app->user ==null): ?>
                        <button onclick="window.location.href='/register'">SIGN UP</button>
                    <?php else: ?>
                        <button onclick="window.location.href='#'">MENU</button>
                        <?php endif; ?>
                    
                    <!-- <button onclick="window.location.href='/login'">SIGN UP</button> -->
                </div>
               
                </div>
            </div>
        </div>
    </div>

    <div class="offers-section">
        <div class="topic-head">
            <p class="card-head-topic">Special Offers</p>
            <button>View all</button>
        </div>
        <hr class="styled-hr">
        <?php include __DIR__ . '../carousel.php'; ?>
    </div>

    <div class="description-section description-section-second" id="topic-head">
        <div class="description-section-part description-section-part-second">
        <div class="description-text-section description-text-section-second">
                <div class="description-head-topic description-head-topic-second">
                    <p>Reserve Your <br/><span>Dining Experience</span></p>
                </div>
                <div class="description-content description-content-second">
                    <p>Discover a dining experience that blends tradition and innovation. Our dishes are crafted with passion, 
                      offering rich flavors in a cozy atmosphere. 
                      Whether you're here for a special occasion or a casual meal, we aim to make your visit unforgettable.</p>
                </div>

                <div class="topic-head">
                    <!-- <button>LEARN MORE</button> -->
                    <button onclick="window.location.href='/selectBranch'">TAKE AWAY</button>
                    <button onclick="window.location.href='/dinein'">DINE IN</button>
                </div>
            </div>

            <div class="description-card-section description-card-section-second">
              <div class="text-of-image whatever">
                <p>"Feel the Heat with Spicy Kottu!🌶️"</p>
              </div>
              <div class="text-of-image text-of-image2">
              <p>"Hot & Spicy Kottu Bliss!🌶️🌶️🌶️"</p>
              </div>
              <img src="/Photo/kottu.png">
            </div>
            
        </div>
    </div>


    

    


    <div class="description-section">
        <div class="description-section-part">

        <div class="description-card-section">
                <div class="card1"><img src="/Photo/online-booking.png" alt="Online Booking"/></div>
                <div class="card1"><img src="/Photo/online-ordering.png" alt="Online Ordering"/></div>
                <div class="card1"><img src="/Photo/online-pay.png" alt="Online Pay"/></div>
                <div class="card1"><img src="/Photo/real-time-bill-update.png" alt="Real-time Bill Update"/></div>
            </div>
            <div class="description-text-section">
                <div class="description-head-topic">
                    <p>Our Culinary journey<br/><span>And Services</span></p>
                </div>
                <div class="description-content">
                    <p>Kottu Lab blends tradition with innovation, offering a unique twist on Sri Lankan cuisine. 
                    From our signature Kottu to diverse menu options, we serve authentic flavors crafted with passion. 
                    Whether dining in, ordering takeaway, 
                    or catering an event, our goal is to provide you with delicious food and a memorable experience.</p>
                </div>
                <div class="topic-head">
                    <button>LEARN MORE</button>
                </div>
            </div>
            
        </div>
    </div>



    <div class="main-review-wrapper">
    <div class="review-list-container">

                <div class="review-list-topic">
                    <h2>Reviews</h2>
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
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
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





    

    




</body>
</html>

