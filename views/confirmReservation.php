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
            <!-- <h1>Enter Your Reservation Number</h1> -->
            <p style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #2c3e50; text-align: center; margin: 2rem auto; width:80%; max-width:1000px; line-height: 1.6; font-size: 1.1rem;  padding: 1.5rem; border-radius: 12px;  animation: fadeIn 0.8s ease-in-out;">
  <span style="display: block; margin-bottom: 0.8rem; font-weight: 600; font-size: 1.3rem; color: #007bff; text-transform: uppercase; letter-spacing: 0.5px;">🔐 Verification Code Sent!</span>
  We've dispatched a special verification key to your inbox! <span style="font-weight: 600; color: #343a40;">Please check your email</span> for the Reservation numbers that will unlock your next step.
  <span style="display: block; margin-top: 1rem; padding: 0.6rem; background-color: rgba(0, 123, 255, 0.1); border-radius: 8px; font-style: italic;">Don't forget to keep this verification code handy — you'll need it to confirm your arrival!</span>
</p>
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
                        <form id="reservationConfirmationForm" class="reservation-form" method="POST">
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
                            <button type="submit" class="submit-button-enter">Confirm Reservation</button>
                           </form>
                        <div id="modalMessage"></div>
                    </div>
                </div>
            </section>
    </div>
    <script src="/JavaScript/confirmationReservation.js"></script>
</body>
</html>