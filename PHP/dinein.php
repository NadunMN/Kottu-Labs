<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DineIn</title>
    <link rel="stylesheet" href="../CSS/navbar.css">
    <link rel="stylesheet" href="../CSS/dinein.css">
    <link rel="stylesheet" href="../CSS/footer.css">
    
</head>

<body>
    <?php //include 'navbar.php'; ?>
    
    <h2 class="headline">Reserve your Spot & Enjoy!</h2>
    <section class="banner">
        <div class="card-container">
            <div class="card-img">
                <img src="../Photo/Thirani_pics/dinein_pic.jpg" alt="pic1">
            </div>

            <div class="card-content">
                <h3>RESERVATION</h3>
                <form>
                    <div class="form-row">
                        <input type="text" placeholder="Full Name" required>
                        <input type="tel" placeholder="Phone Number" pattern="[0-9]{10}" required>
                    </div>

                    <div class="form-row1">
                        <label for="reservation-date">Select Date: </label>

                        <input type="date" id="reservation-date" required> 

                        <select name="hours" required>
                            <option value="hour-select">Select Time</option>
                            <option value="3">3pm - 4pm</option>
                            <option value="4">4pm - 5pm</option>
                            <option value="5">5pm - 6pm</option>
                            <option value="6">6pm - 7pm</option>
                            <option value="7">7pm - 8pm</option>
                            <option value="8">8pm - 9pm</option>
                            <option value="9">9pm - 10pm</option>
                            <option value="10">10pm - 11pm</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <input type="number" placeholder="How many persons to dine in?" min="1" required>
                    </div>
                    
                    <button class="submit-button"><a href="http://www.google.com"> Add Reservation</a></button>

                </form>
            </div>
        </div>
    </section>

    <script src="../JavaScript/dinein.js" defer></script>
    <?php //include 'footer.php'; ?>

</body>
</html>
