<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NavBar</title>
    <link rel="stylesheet" href="/CSS/NavBar.css">
</head>
<body>

    <div class="home-top-main">
        <div class="first-background-img">
            <div class="first-background-overlay">
                <p class="Header-text">Enjoy our,<br/> Delicious Meal Kottu</p>
                <p class="Sub-text">
                    <i>We help companies develop the strongest tech teams around. We help<br/>
                    candidates sharpen their tech skills and pursue job opportunities.</i>
                </p>
                <div class="button-container">
                    <button>Booking</button>
                    <button>Sign up</button>
                </div>
            </div>
        </div>
    </div>

    <div class="offers-section">
        <div class="topic-head">
            <p class="card-head-topic">Most Popular Deal</p>
            <button>View all</button>
        </div>
        <hr class="styled-hr">
        <?php include __DIR__ . '../carousel.php'; ?>
    </div>

    <div class="description-section description-section-second">
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
                    <button>View our menu</button>
                </div>
            </div>

            <div class="description-card-section description-card-section-second">
              <div class="text-of-image">
                <p>"Feel the Heat with Spicy Kottu!🌶️"</p>
              </div>
              <div class="text-of-image text-of-image2">
              <p>"Hot & Spicy Kottu Bliss!🌶️🌶️🌶️"</p>
              </div>
              <img src="/Photo/kottu.png">
            </div>
            
        </div>
    </div>


    

    <div class="offers-section">
        <div class="topic-head">
            <p class="card-head-topic">Monthly offers</p>
            <button>View all</button>
        </div>
        <hr class="styled-hr">
        <?php include __DIR__ . '/./carousel.php'; ?>
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
                    <button>Learn More</button>
                </div>
            </div>
            
        </div>
    </div>


    

    




</body>
</html>

