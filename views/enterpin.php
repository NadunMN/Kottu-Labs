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

    <div id="reservationModal" style="display:none;">
        <div class="pin-topic">
            <h1>Reservation Details</h1>
            <h3 id="date"></h3>
            <h3 id="clock"></h3>
        </div>
        <div class="pin-container">
            <div class="confirmation-box">
                <form id="reservationConfirmationForm" class="reservation-form" method="POST">
                    <div class="name-table">
                        <h2><span id="fullname"></span></h2>
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
                    <div>
                        <div class="date-time">
                            <span id="reservationDate"></span>
                            <span id="reservationTime"></span>
                        </div>
                        <h4><span id="branch"></span> Branch</h4>
                        <div class="dining-option">
                            <label id="dineInLabel"> Dine In <span class="strike-through"></span></label>
                            <label id="takeAwayLabel"> Take Away <span class="strike-through"></span></label>
                        </div>
                        <div>
                            <h4>Number of Guest is <span id="numberOfGuests"></span></h4>
                        </div>
                        <div class="buttons">
                            <button type="submit" class="confirm-button">Confirm Reservation</button>
                            <span class="confirmed-text">Already Confirmed!</span>
                            <button type="button" class="close-button">Close</button>
                        </div>
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