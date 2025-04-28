<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NavBar</title>
    <link rel="stylesheet" href="/CSS/NavBar.css">
    <link rel="stylesheet" href="/CSS/userdashboard.css">
    <!-- <link rel="stylesheet" href="/CSS/menuhome.css"> -->
</head>
<body>


    <div class="home-top-main" id="home-top-main">
        <div class="first-background-img">
            <div class="first-background-overlay">
              <!-- <div class="kottuplate">
                <img src="/Photo/kottu_main.png" alt="Kottu Plate" class="kottuplate-img">
              </div> -->
              <!-- <div class="square"></div> -->
                <!-- <div class="red-squre"></div> -->
                <div class="back-white-circle"></div>
                <!-- <div class="pic-1">
                    <img src="/Photo/download (1).jpeg" alt="">
                </div> -->
                
                <p class="Header-text">Enjoy your, SL <br/><span class="under-text-part"> Comfort Food <span>Kottu</span></span></p>
                


                <p class="Sub-text">
                Experience the authentic taste of Sri Lanka with our signature Kottu dishes!</br>
                we’re ready to serve you with freshly made Kottu that's packed with flavor.
                </p>
                <div class="button-div">
                <div class="button-container button-container-second">

                    <button class="button1" onclick="window.location.href='#topic-head'">BOOKING
                        <div class="button-circle-1">
                            <img src="/Photo/icon/right-arrow.png" alt="">
                        </div>
                    </button>

                    

                    
                <?php if (\app\core\Application::$app->user ==null): ?>
                        <button onclick="window.location.href='/register'">SIGN UP</button>
                        
                    <?php else: ?>
                        <button onclick="window.location.href='/homeMenu'">MENU</button>
                        
                        <?php endif; ?>
                    
                     <!-- <button onclick="window.location.href='/login'">SIGN UP</button>  -->
                </div>
               
                </div>
            </div>
        </div>
    </div>

    <div class="offers-section">
        <div class="topic-head">
            <p class="card-head-topic">Special Offers</p>
            <!-- <button onclick="window.location.href='/offer'">View All</button> -->
            
            <!-- From Uiverse.io by Creatlydev --> 
            <button class="cta" onclick="window.location.href='/offer'">
            <span class="hover-underline-animation"> View all </span>
            <svg
                id="arrow-horizontal"
                xmlns="http://www.w3.org/2000/svg"
                width="30"
                height="10"
                viewBox="0 0 46 16"
            >
                <path
                id="Path_10"
                data-name="Path 10"
                d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z"
                transform="translate(30)"
                ></path>
            </svg>
            </button>



        </div>
        <!-- <hr class="styled-hr"> -->
        <?php include __DIR__ . '../carousel.php'; ?>
    </div>

    <div class="description-section description-section-second" id="topic-head">
        <div class="description-section-part description-section-part-second">
        <div class="description-text-section description-text-section-second">
                <div class="description-head-topic description-head-topic-second">
                    <p>Lock in your <br/><span class="dooo">dining spot Now!</span></p>
                </div>
                <div class="description-content description-content-second">
                    <p>Discover a dining experience that blends tradition and innovation. Our dishes are crafted with passion, 
                      offering rich flavors in a cozy atmosphere. 
                      Whether you're here for a special occasion or a casual meal, we aim to make your visit unforgettable.</p>
                </div>

                <div class="topic-head">
                    <!-- <button>LEARN MORE</button> -->
                    <!-- <button onclick="window.location.href='/selectBranch'">TAKE AWAY</button> -->
                    <!-- From Uiverse.io by Creatlydev --> 
                    <button href="#" class="button takeaway" style="--clr:rgb(0, 0, 0)" >
                    <span class="button__icon-wrapper">
                        <svg
                        viewBox="0 0 14 15"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="button__icon-svg"
                        width="10"
                        >
                        <path
                            d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"
                            fill="currentColor"
                        ></path>
                        </svg>

                        <svg
                        viewBox="0 0 14 15"
                        fill="none"
                        width="10"
                        xmlns="http://www.w3.org/2000/svg"
                        class="button__icon-svg button__icon-svg--copy"
                        >
                        <path
                            d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"
                            fill="currentColor"
                        ></path>
                        </svg>
                    </span>
                    TAKE AWAY
                    </button>


                    <button href="#" class="button dinein" style="--clr:rgb(0, 0, 0)" >
                    <span class="button__icon-wrapper">
                        <svg
                        viewBox="0 0 14 15"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="button__icon-svg"
                        width="10"
                        >
                        <path
                            d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"
                            fill="currentColor"
                        ></path>
                        </svg>

                        <svg
                        viewBox="0 0 14 15"
                        fill="none"
                        width="10"
                        xmlns="http://www.w3.org/2000/svg"
                        class="button__icon-svg button__icon-svg--copy"
                        >
                        <path
                            d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"
                            fill="currentColor"
                        ></path>
                        </svg>
                    </span>
                    DINE IN
                    </button>



                    
                    
                    <!-- <button onclick="window.location.href='/dinein'">DINE IN</button> -->
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


    

    <!-- service -->
    <section class="ezy__service2_NrYFSVFQ">
	<div class="container">
		<div class="row justify-content-center mb-md-5">
			<div class="col-lg-6 text-center">
				<h2 class="ezy__service2_NrYFSVFQ-heading mb-4">Services We Provide</h2>
				<p class="ezy__service2_NrYFSVFQ-sub-heading mb-0">Kottu Lab blends tradition with innovation, offering a unique twist on Sri Lankan cuisine. 
                     our goal is to provide you with delicious food and a memorable experience.</p>
			</div>
		</div>
		<div class="row text-center ezy__service2_NrYFSVFQ-card">
			<div class="col-md-4 mt-5 mt-md-0">
				<div class="card ezy__service2_NrYFSVFQ-item">
					<div class="card-body px-lg-4 py-lg-5">
						<div class="ezy__service2_NrYFSVFQ-icon mb-4"><i class="fa-solid fa-utensils"></i></div>
						<h4 class="ezy__service2_NrYFSVFQ-title fs-4 mb-3">Online Booking</h4>
						<p class="ezy__service2_NrYFSVFQ-content mb-0">Convenient online booking for 
                            hassle-free reservation at Kottu Lab</p>
					</div>
				</div>
			</div>
			<div class="col-md-4 mt-5 mt-md-0">
				<div class="card ezy__service2_NrYFSVFQ-item">
					<div class="card-body px-lg-4 py-lg-5">
						<div class="ezy__service2_NrYFSVFQ-icon mb-4"><i class="fa-solid fa-burger"></i></div>
						<h4 class="ezy__service2_NrYFSVFQ-title fs-4 mb-3">Online Ordering</h4>
						<p class="ezy__service2_NrYFSVFQ-content mb-0">Order your favorite dishes online for quick and easy takeaway or delivery.</p>
					</div>
				</div>
			</div>
			<div class="col-md-4 mt-5 mt-md-0">
				<div class="card ezy__service2_NrYFSVFQ-item">
					<div class="card-body px-lg-4 py-lg-5">
						<div class="ezy__service2_NrYFSVFQ-icon mb-4"><i class="fa-solid fa-credit-card"></i></div>
						<h4 class="ezy__service2_NrYFSVFQ-title fs-4 mb-3">Online Pay</h4>
						<p class="ezy__service2_NrYFSVFQ-content mb-0">Seamless and secure online payment option for your convenience.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
    <!-- service -->



    
    <!-- new section -->
    <section class="ezy__team-section">
  <div class="container">

<div class="wrapper-action">
  <div class="action-btn-staff">
  <div class="action-topic-staff">
    <h2 class="ezy__team-section-heading">Our Team Members</h2>
    <p class="ezy__team-section-subheading">
    At Kottu Lab, we’re more than just a group of developers and designers — we’re a passionate team driven by creativity, collaboration, ]
    and a shared love for innovation. 
    </p>
  </div>

  <div class="ezy__team-button-container">
      <button class="ezy__team-button" onclick="window.location.href='/staff'">Show More</button>
    </div>

    </div>

    </div>

    <div class="ezy__team-grid">
      
    
      <div class="ezy__team-card">
        <img 
          src="https://cdn.easyfrontend.com/pictures/team/team_square_1.jpeg" 
          alt="Akshay Kumar" 
          class="ezy__team-card-image"
        >
        <div class="ezy__team-card-content">
          <h3 class="ezy__team-member-name">Ranuga Lekamwasam</h3>
          <p class="ezy__team-member-position">Owner of Kottu Labs</p>
        </div>
      </div>

     

      <div class="ezy__team-card">
        <img 
          src="/Photo/Staff/manager3.jpg" 
          alt="Raima Ray" 
          class="ezy__team-card-image"
        >
        <div class="ezy__team-card-content">
          <h3 class="ezy__team-member-name">Mahesh Kumara</h3>
          <p class="ezy__team-member-position">Manager-Watta</p>
        </div>
      </div>

  
      
      <div class="ezy__team-card">
        <img 
          src="/Photo/Staff/manager1.avif" 
          alt="Sarah Johnson" 
          class="ezy__team-card-image"
        >
        <div class="ezy__team-card-content">
          <h3 class="ezy__team-member-name">Thirani Athukorala</h3>
          <p class="ezy__team-member-position">Manager-Kelaniya</p>
        </div>
      </div>


      
      <div class="ezy__team-card">
        <img 
          src="https://cdn.easyfrontend.com/pictures/team/team_square_3.jpeg" 
          alt="Arjun Kapur" 
          class="ezy__team-card-image"
        >
        <div class="ezy__team-card-content">
          <h3 class="ezy__team-member-name">Nadun Mdusanka</h3>
          <p class="ezy__team-member-position">Manager-Kotahena</p>
        </div>
      </div>
    </div>

  </div>
</section>
    <!-- new section -->


    

    
<!-- 

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
                
            </div>
            
        </div>
    </div> -->




    
<script src="/JavaScript/home.js"></script>



</body>
</html>

