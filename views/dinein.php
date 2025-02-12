<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Information -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Make a dining reservation at Kottu Labs - Reserve your spot for a delicious dining experience">
    <meta name="keywords" content="Kottu Labs, restaurant reservation, dining, Sri Lankan food">
    <meta name="author" content="Kottu Labs">

    <!-- Page Title -->
    <title>Dine in</title>

    <!-- Styles -->
    <link rel="stylesheet" href="/CSS/dinein.css">
</head>

<body>

    <!-- Reservation Section -->
    <section class="reservation-section">
        <div class="card-content">
            <div class="card-content-left">
            <h2 class="form-title">Add a Reservation</h2>
            <form id="reservationForm" action="/reservationNumber" class="reservation-form" method="POST">
  <div class="form-group">
    <label for="fullname" class="form-label" >Full Name</label>
    <input type="text" id="fullname" name="fullname" class="form-input" placeholder="Enter Full Name" required>
</div>
<div class="form-group">
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" name="email" class="form-input" placeholder="Enter Email" required>
    <small class="small-texts">** The reservation number will be sent to this email</small>
</div>
<div class="form-group">
    <label for="reservation-date" class="form-label">Reservation Date</label>
    <input type="date" id="reservation-date" name="reservation_date" class="form-input" required>
</div>
  <div class="form-group">
      <label for="reservation-time" class="form-label">Reservation Time</label>
    <select id="reservation-time" name="reservation_time" class="form-select" required>
        <option value="">Select a time slot</option>
      <optgroup label="Afternoon">
          <option value="15:00">3:00 PM - 4:00 PM</option>
        <option value="16:00">4:00 PM - 5:00 PM</option>
        <option value="17:00">5:00 PM - 6:00 PM</option>
      </optgroup>
      <optgroup label="Evening">
          <option value="18:00">6:00 PM - 7:00 PM</option>
          <option value="19:00">7:00 PM - 8:00 PM</option>
        <option value="20:00">8:00 PM - 9:00 PM</option>
      </optgroup>
    </select>
  </div>
  <div class="form-group">
    <label for="reservation-branch" class="form-label">Branch</label>
    <select id="reservation-branch" name="branch_id" class="form-select" required>
        <option value="">Select a Branch</option>
        <option value="1">Wattala</option>
        <option value="2">Keleniya</option>
        <option value="3">Kotahena</option>
    </select>
</div>
<div class="form-group">
    <label for="guests" class="form-label">Number of Guests</label>
    <input type="number" id="guests" name="number_of_guests" class="form-input" required min="1" max="20" placeholder="Enter number of guests">
    <small class="small-texts">** You cannot enter more than 20 guests.</small>
</div>
<button type="submit" class="submit-button">Confirm Reservation</button>
</form>

            </div>

            

        </div>
    </section>

    <script src="/JavaScript/dinein.js"></script>

</body>

</html>