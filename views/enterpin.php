<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter PIN</title>
    <link rel="stylesheet" href="/CSS/enterpin.css">
</head>
<body>
    <div id="pinEntrySection">
        <div class="pin-topic" >
            <h1>Enter Confirmation PIN</h1>
            <p>Please enter the PIN to continue</p>
        </div>

        <div class="pin-container" >
            <div class="pin-box">
                <div class="pin-input-container">
                    <input type="text" maxlength="1" class="pin-digit">
                    <input type="text" maxlength="1" class="pin-digit">
                    <input type="text" maxlength="1" class="pin-digit">
                    <input type="text" maxlength="1" class="pin-digit">
                    <input type="text" maxlength="1" class="pin-digit">
                    <input type="text" maxlength="1" class="pin-digit">
                </div>
                <div class="pin-message">
                    <!-- Error or success messages will appear here -->
                </div>
                <button class="submit-button">Submit</button>
            </div>
        </div>
    </div>

    <div class="modal" id="reservationModal" style="display:none;">
        <!-- <div class="modal-content"> -->
            <!-- <span class="close" id="closeModal"></span> -->
            
            <section class="reservation-section">
                <div class="card-content">
                    <div class="card-content-left">
                        <h2 class="form-title">Reservation Confimation</h2>
                        <form id="reservationConfirmationForm" action="/reservationNumber" class="reservation-form" method="POST">
                            <div class="form-group">
                                <label for="fullname" class="form-label" >Full Name</label>
                                <input type="text" id="fullname" name="fullname" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="reservationDate" class="form-label">Reservation Date</label>
                                <div class="input-container">
                                    <input type="text" id="reservationDate" name="reservation_date" class="form-input" readonly>
                                    <span class="date-indicator"></span> <!-- Indicator for date validity -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="reservationTime" class="form-label">Reservation Time</label>
                                <input type="text" id="reservationTime" name="reservation_date" class="form-input" readonly>
                            </div>
                            <div class="form-group">
                                <label for="reservation-branch" class="form-label">Branch</label>
                                <input type="text" id="branch" name="reservation_date" class="form-input" readonly>
                            </div>
                            <div class="form-group">
                                <label for="numberOfGuest" class="form-label">Number of Guests</label>
                                <input type="text" id="numberOfGuests" name="number_of_guests" class="form-input" readonly>
                            </div>
                            <div class="form-group">
                                <label for="tableNumber" class="form-label">Table Number</label>
                                <select name="table_number" id="tableNumber" class="form-input">
                                    <option value="" disabled selected>Select a table</option> <!-- Placeholder option -->
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                </select>
                            </div>
                            <button type="submit" class="submit-button">Confirm Reservation</button>
                           </form>
                        <div id="modalMessage"></div>
                    </div>
                </div>
            </section>
    </div>
    <script src="/JavaScript/enterpin.js"></script>
</body>
</html>