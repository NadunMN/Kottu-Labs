<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>String Validation</title>
    <link rel="stylesheet" href="/CSS/enterpin.css">

    <style>

        .container-mainwraaper{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 90vh;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
       
        
        .container-aa {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            margin: 0 auto;
        }
        
        h1 {
            color: #333;
            margin-bottom: 1.5rem;
        }
        
        .setup-section {
            margin-bottom: 1.5rem;
        }
        
        .input-field {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            border: 2px solid #ddd;
            border-radius: 5px;
            margin-bottom: 1rem;
            box-sizing: border-box;
        }
        
        .input-field:focus {
            border-color: #4285f4;
            outline: none;
            box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
        }
        
        .action-btn {
            background-color: #4285f4;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .action-btn:hover {
            background-color: #3367d6;
        }
        
        .verification-message {
            margin-top: 1rem;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            display: none;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            display: none;
        }
    </style>
</head>
<body>

<div class="container-mainwraaper" id="container-mainwraaper">
    <div class="container-aa">
        <h1>String Validation</h1>
        
        <div class="setup-section">
            <input type="text" id="input-string" class="input-field" placeholder="Enter your string">
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


    <div id="reservationModal" style="display:none;">
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
                            <h3><span id="type-user"></span> Branch</h3>
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
        <p>Reservation added successfully!</p>
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