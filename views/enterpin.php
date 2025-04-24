<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter PIN</title>
    <link rel="stylesheet" href="/CSS/enterpin.css">
</head>
<body>

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

    <script src="/JavaScript/enterpin.js"></script>
</body>
</html>