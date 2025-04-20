<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/customerProfile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Table Styles */
.menu-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  background-color: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  margin-top: 2rem;
}

.menu-table thead {
  background-color: #f1f5f9;
}

.menu-table th {
  padding: 1.2rem 1rem;
  text-align: left;
  font-weight: 600;
  color: #334155;
  border-bottom: 2px solid #e2e8f0;
  white-space: nowrap;
}

.menu-table td {
  padding: 1rem;
  border-bottom: 1px solid #e2e8f0;
  color: #475569;
  text-align: left;
  vertical-align: middle;
}

.menu-table tbody tr {
  transition: background-color 0.15s ease;
}

.menu-table tbody tr:hover {
  background-color: #f8fafc;
}

.menu-table tbody tr:last-child td {
  border-bottom: none;
}

/* Staff photo container styling */
.staff-photo-container {
  width: 65px;
  height: 65px;
  border-radius: 50%;
  overflow: hidden;
  position: relative;
}

.staff-photo {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Action Buttons styles */
.action-buttons {
  display: flex;
  gap: 0.5rem;
}

.action-btn button {
  padding: 0.5rem 0.9rem;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  font-size: 0.85rem;
  font-weight: 500;
  transition: all 0.2s ease;
}

.edit-btn {
  background-color: #3b82f6;
  color: white;
}

.edit-btn:hover {
  background-color: #2563eb;
}

.delete-btn {
  background-color: #ef4444;
  color: white;
}

.delete-btn:hover {
  background-color: #dc2626;
}

/* Responsive Adjustments */
@media (max-width: 1024px) {
  .menu-table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }
}

@media (max-width: 768px) {
  .action-buttons {
    flex-direction: column;
    gap: 0.5rem;
  }
  
  .action-btn button {
    width: 100%;
  }
}


/* Base styling for all staff-created divs */
.staff-created {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  border-radius: 5px;
  padding: 5px 10px;
  font-size: 1rem;
  font-weight: 500;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Position-specific colors */
/* Manager - Green theme */
.staff-created[data-position='1'] {
  background-color: #e6f7ed;
  color: #0a6c40;
  border-left: 3px solid #0f9d58;
}

/* Chef - Orange theme */
.staff-created[data-position='0'] {
  background-color: #fff0e6;
  color: #b35900;
  border-left: 3px solid #ff9800;
}

/* Steward - Purple theme */
.staff-created[data-position="2"] {
  background-color: #f0e6ff;
  color: #6200b3;
  border-left: 3px solid #9c27b0;
}

/* Hover effects */
.staff-created:hover {
  opacity: 0.9;
}




/* Confirmation Dialog - Updated Styling */
.popup-overlay {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* Centers the element */
    z-index: 1000; /* Ensures it appears above other elements */
    width: 100%; /* Optional: Adjust width if needed */
    height: 100%; /* Optional: Adjust height if needed */
    backdrop-filter: blur(5px); /* Adds a blur effect to the background */
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    animation: popup-fade-in 0.3s ease-in-out; /* Animation for fade-in effect */
    overflow: hidden; /* Prevents scrolling when popup is open */
    
}


/* Popup content box */
.popup-content {
  background-color: white;
  padding: 2.5rem 2rem 2rem;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  max-width: 500px;
  width: 90%;
  text-align: center;
  animation: popup-fade-in 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  position: relative;
}

/* Icon container */
.popup-icon {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background-color: rgba(255, 59, 78, 0.1);
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto 1.5rem;
}

/* Icon styling */
.popup-icon svg {
  width: 28px;
  height: 28px;
  color: #FF3B4E;
}

/* Popup message text */
#popup-message {
  margin-bottom: 2rem;
  font-size: 1.1rem;
  color: #333;
  line-height: 1.5;
  font-weight: 500;
}

/* Description text */
.popup-description {
  margin-bottom: 2rem;
  color: #666;
  font-size: 0.95rem;
}

/* Buttons container */
.popup-buttons {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-top: 0.5rem;
}

/* Button styling */
.popup-buttons button {
  padding: 0.85rem 1.75rem;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.2s ease;
  min-width: 120px;
}

/* Delete button */
#popup-delete {
  background-color: #FF3B4E;
  color: white;
}

#popup-delete:hover {
  background-color: #e6354a;
  box-shadow: 0 4px 12px rgba(255, 59, 78, 0.25);
}

/* Cancel button */
#popup-cancel {
  background-color: #f2f2f2;
  color: #444;
}

#popup-cancel:hover {
  background-color: #e8e8e8;
}

/* Accessibility focus styles */
.popup-buttons button:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(59, 153, 252, 0.5);
}

/* Responsive adjustments for smaller screens */
@media (max-width: 480px) {
  .popup-content {
    padding: 2rem 1.5rem 1.5rem;
  }
  
  .popup-buttons {
    flex-direction: column;
  }
  
  .popup-buttons button {
    width: 100%;
  }
}

    </style>

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
                    <h1 id= "user-name" class="profile-name">John Doe</h1>
                    <p id="user-email" class="profile-email">john.doe@example.com</p>
                    <span class="profile-status">Active Member</span>
                </div>
            </div>
            <button id="view-profile" class="edit-profile-btn">
                
                Edit Profile
            </button>
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

                <!-- Table Rows -->
                <div class="table-row">
                    <div>001</div>
                    <div>Nadun Madusanka</div>
                    <div>2025-02-25</div>
                    <div>Dine in</div>
                    <div>Pending</div>
                    <div>
                        <button>Edit</button>
                        <button>Delete</button>
                    </div>
                </div>

                <div class="table-row">
                    <div>002</div>
                    <div>Dinuka Sahan</div>
                    <div>2025-02-22</div>
                    <div>Dine in</div>
                    <div>confirmed</div>
                    <div>
                        <button>Edit</button>
                        <button>Delete</button>
                    </div>
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

    <script >

      let currentPath = window.location.pathname;
    console.log('Current Path:', currentPath);
    
    // Select the button element
    const button = document.getElementById("view-profile");

    // Check the current path and update the button accordingly
    if (currentPath === '/profile') {
      button.textContent = "View Profile";
      button.onclick = () => { window.location.href = '/myaccount'; };
    } else if (currentPath === '/myaccount') {
      button.textContent = "View Dashboard";
      button.onclick = () => { window.location.href = '/profile'; };
    }

    const button2 = document.getElementById("add-reservation");
    // Check the current path and update the button accordingly
    if (currentPath === '/profile') {
      // button2.textContent = "View Profile";
      button2.onclick = () => { window.location.href = '/#topic-head'; };
    }





    </script>

    
</body>

</html>