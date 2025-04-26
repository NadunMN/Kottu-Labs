<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/customerProfile.css">
    <link rel="stylesheet" href="/CSS/reviews.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </head>

  <body>
      <!-- profile name -->
    <div class="profile-container">
      <div class="profile-header">
        <div class="account-info">
          <div class="profile-avatar">
            <img src="/Photo/OE612P0.jpg" alt="User Avatar" class="avatar">
          </div>
          <div class="profile-details">
            <h1 id= "user-name" class="profile-name"></h1>
            <p id="user-email" class="profile-email"></p>
            <span class="profile-status">Active Member</span>
          </div>
        </div>
        <button id="view-profile" class="edit-profile-btn"></button>
      </div>
    </div>
      <!-- profile name -->

    <div class="horizontal-line"></div>
    <div class="order-history">
            
      <!-- order list -->
      <div class="order-list-container">
        <h2>Reservation History</h2>
        <div class="order-list-button">
          <button id="add-reservation" >Add Reservation</button>
        </div>
      </div>

      <div class="table-container" id="table-container">


        <!-- Table Header -->
        <div class="table-header">
          <div>Reservation Number</div>
          <div>Reservation Name</div>
          <div>Reservation Date</div>
          <div>TYPE</div>
          <div>STATUS</div>
          <div>Action</div>
        </div>   
      </div>
    </div>

    <!--Add reviews -->
    <div class="add-review-list-container">
      <div class="add-review-list-topic">
        <h2>Add Reviews</h2>
        <div class="review-list-button"></div>
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
    
    <!-- delete button -->
    <div id="popup" class="popup-overlay">
      <div class="popup-content">
        <div class="popup-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            <line x1="10" y1="11" x2="10" y2="17"></line>
            <line x1="14" y1="11" x2="14" y2="17"></line>
          </svg>
        </div>
        <p id="popup-message">Are you sure?</p>
        <div class="popup-buttons">
            <button id="popup-cancel">Cancel</button>
            <button id="popup-confirm" id="popup-delete">Delete</button>
        </div>
      </div>
    </div>
    
    <script src="/JavaScript/addReview.js"></script>
    <script src="/JavaScript/useDashboard.js"></script>
      
  </body>
</html>