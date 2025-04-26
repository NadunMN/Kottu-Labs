<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>String Validation</title>
    <link rel="stylesheet" href="/CSS/enterpin.css">

    <style>

/* General styling and reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}


.container-mainwraaper {
  width: 100%;
    height: 90vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.container-aa {
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  padding: 40px;
  width: 90%;
  max-width: 600px;
  text-align: center;
}

/* Header styling */
h1 {
  color: #2c3e50;
  margin-bottom: 30px;
  font-weight: 600;
  font-size: 28px;
}

/* Setup section styling */
.setup-section {
  display: flex;
  gap: 12px;
  margin-bottom: 30px;
}

.input-field {
  flex: 1;
  padding: 14px 16px;
  border: 2px solid #e0e5ec;
  border-radius: 8px;
  font-size: 16px;
  transition: border-color 0.3s, box-shadow 0.3s;
  outline: none;
}

.input-field:focus {
  border-color: black;
  box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
}

.input-field::placeholder {
  color: #b2b9c5;
}

.action-btn {
  background-color: black;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 14px 28px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.2s;
}

.action-btn:hover {
  background-color: #ee3e3f;
}

.action-btn:active {
  transform: translateY(2px);
}

/* Verification messages styling */
.verification-message {
  padding: 16px;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 500;
  margin-top: 10px;
  display: none; /* Hidden by default */
}

.success {
  background-color: #e8f8f5;
  color: #27ae60;
  border-left: 4px solid #27ae60;
}

.error {
  background-color: #fdedeb;
  color: #e74c3c;
  border-left: 4px solid #e74c3c;
}

/* Responsive adjustments */
@media (max-width: 600px) {
  .container-aa {
    padding: 30px 20px;
  }
  
  .setup-section {
    flex-direction: column;
  }
  
  .action-btn {
    width: 100%;
  }
}
    </style>
</head>
<body>

<div class="container-mainwraaper" id="container-mainwraaper" style="display: flex;">
    <div class="container-aa">
        <h1>Reservation Validation</h1>
        
        <div class="setup-section">
            <input type="text" id="input-string" class="input-field" placeholder="Enter Reservation Number">
            <button id="verify-btn" class="action-btn">Verify</button>
        </div>
        
        <div class="verification-message success" id="success-message">
            Validation successful!
        </div>
        
        <div class="verification-message error" id="error-message">
            Invalid string. Please try again.
        </div>
    </div>
    </div>


    <div id="reservationModal" style="display:none ;">
        <div class="pin-topic">
            <h1>Reservation Details</h1>
            <h3 id="date"></h3>
            <h3 id="clock"></h3>
        </div>
        <div class="pin-container">
            <div class="confirmation-box">
                <form id="reservationConfirmationForm" class="reservation-form" method="POST">
                    <div class="form-layout">
                        <div class="details-section">
                            <h2 id="fullname"></h2>
                            <div class="date-time">
                                <span id="reservationDate"></span>
                                <span id="reservationTime"></span>
                            </div>
                            <h3><span id="type-user"></span></h3>
                            <h4><span id="branch"></span> Branch</h4>
                            <div class="dining-option">
                                <span id="reservationTypeLabel"></span>
                            </div>
                            <div>
                                <h4>Number of Guests: <span id="numberOfGuests"></span></h4>
                            </div>
                        </div>
                        <div class="table-assignment-section">
                            <select name="table_number" id="tableNumber" class="form-input" required>
                                <option value="" disabled selected>Select a table</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                    </div>
                    <div id="orderDetails" style="display: none;">
                        <p><strong>Order Number:</strong> <span id="orderNumber"></span></p>
                        <p><strong>Order Items:</strong> <span id="orderItems"></span></p>
                        <p><strong>Total Price:</strong> <span id="totalPrice"></span></p>
                    </div>
                    <div class="buttons">
                        <button type="submit" class="confirm-button">Confirm Reservation</button>
                        <span class="confirmed-text">Already Confirmed!</span>
                        <button type="button" class="close-button">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="successMessage" class="success-pop">
        <p>Table added successfully!</p>
    </div>












    
    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    </style>

    <script src="/JavaScript/menuaccess.js"></script>
    <!-- <script src="/JavaScript/enterpin.js"></script> -->

</body>
</html>