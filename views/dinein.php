<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Form</title>
    <link rel="stylesheet" href="/CSS/dinein.css">
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fullName = $_POST['fullName'];
            $phoneNumber = $_POST['phoneNumber'];
            $reservationDate = $_POST['reservationDate'];
            $reservationTime = $_POST['reservationTime'];
            $numberOfPersons = $_POST['numberOfPersons'];
            $specialNotes = $_POST['specialNotes'];

            // Generate a random reservation number
            $reservationNumber = rand(100000, 999999);

            // Here you would typically send the reservation number to the provided phone number
            // using an SMS gateway API. For demonstration, we'll just log it.
            error_log("Reservation number $reservationNumber sent to $phoneNumber");

            // Redirect back to the form with a success message
            header('Location: index.html');
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Define valid time slots from 3 PM to 11 PM
            $validTimeSlots = [
                "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"
            ];
        
            $reservationTime = $_POST['reservationTime'];
        
            if (!in_array($reservationTime, $validTimeSlots)) {
                die("Invalid reservation time selected.");
            }
        
            // Process the valid reservation
            // Generate a random reservation number
            $reservationNumber = rand(100000, 999999);
        
            // Log the reservation for demonstration
            error_log("Reservation number $reservationNumber for $reservationTime");
        
            // Redirect to success page or process the reservation further
            header('Location: index.html');
            exit();
        }
    ?>
</head>
<body>
    <div class="form-container">
        <h2>Reserve your Spot!</h2>
        <form id="reservationForm" action="reserve.php" method="POST">

            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="fullName" required>

            <label for="phoneNumber">Phone Number</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" required>
            <small id="phoneError"></small> <!-- Error message for phone number -->
            <p> Please note that the Reservation number will be sent to this number.</p>

            <label for="reservationDate">Reservation Date</label>
            <input type="date" id="reservationDate" name="reservationDate" required>
            <small id="dateError" class="error"></small> 

            <label for="reservationTime">Reservation Time</label>
            <select id="reservationTime" name="reservationTime" required>
                <option value="hour-select">Select Time</option>
                    <option value="1">3pm - 4pm</option>
                    <option value="2">4pm - 5pm</option>
                    <option value="3">5pm - 6pm</option>
                    <option value="4">6pm - 7pm</option>
                    <option value="5">7pm - 8pm</option>
                    <option value="6">8pm - 9pm</option>
                    <option value="7">9pm - 10pm</option>
                    <option value="8">10pm - 11pm</option>
            </select>
            <small id="timeError" class="error"></small>

            <label for="numberOfPersons">Number of persons</label>
            <input type="number" id="numberOfPersons" name="numberOfPersons" min="1" max="20" required>

            <label for="specialNotes">Special Notes</label>
            <textarea id="specialNotes" name="specialNotes" rows="4"></textarea>

            <button type="submit">Reserve</button>
        </form>
    </div>

    <div id="popup" class="popup">
        <p>Reservation number is sent to the provided phone number.</p>
        <button onclick="closePopup()">Close</button>
    </div>

    <script src="/JavaScript/dinein.js"></script>
</body>
</html>