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
    <!-- Header Section -->
    <header>
        <h1 class="headline">Reserve Your Spot & Enjoy!</h1>
    </header>

    <!-- Reservation Section -->
    <section>
        <div class="card-content">
            <h2 class="form-title">Make a Reservation</h2>
            <form id="reservationForm" action="" class="reservation-form">
                <!-- Personal Information Section -->
               

<<<<<<< HEAD
                        <!-- <div class="card-img">
                        <img 
                            src="/Photo/Thirani_pics/dinein_pic.jpg" 
                            alt="Kottu Labs dining area interior"
                        >
                    </div> -->

                        <form id="reservationForm" action="/submit-reservation" method="POST" class="reservation-form">
                            <!-- Personal Information Section -->
                            <div class="form-section personal-info">

                                <!-- Full Name Field -->
                                <div class="form-group">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input 
                                        type="text" 
                                        id="fullName" 
                                        name="fullName"
                                        class="form-input"
                                        required
                                        autocomplete="name"
                                        minlength="2"
                                        maxlength="50"
                                        placeholder="Enter your full name"
                                    >
                                </div>
                                <br>
                                <!-- Phone Number Field -->
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input 
                                        type="tel" 
                                        id="phone" 
                                        name="phone"
                                        class="form-input"
                                        required
                                        autocomplete="tel"
                                        pattern="[0-9]{10}"
                                        placeholder="Enter your phone number"
                                        aria-describedby="phoneFormat"
                                    >
                                    <small id="phoneFormat" class="helper-text">Please enter a 10-digit phone number</small>
                                    <br>

                                    <!-- Select branch -->
                                    <label for="select branch" class="form-label">Select Branch</label>
                                    <select 
                                            id="select-branch" 
                                            name="select branch"
                                            class="form-select"
                                            required
                                            aria-describedby="timeHelp"
                                        >
                                                <option value="Branch1">Wattala</option>
                                                <option value="Branch2">Kotahena</option>
                                                <option value="Branch3">Kelaniya</option>
                                    </select>
                                    <small id="branchselect" class="helper-text">Please select the restaurant</small>    
                                </div>
                            </div>
                         

                            <!-- Reservation Details Section -->
                            <div class="form-section reservation-details">
                                <!-- Date and Time Selection -->
                                <div class="form-row date-time">
                                    <!-- Date Field -->
                                    <div class="form-group">
                                        <label for="reservation-date" class="form-label">Reservation Date</label>
                                        <input 
                                            type="date" 
                                            id="reservation-date" 
                                            name="reservationDate"
                                            class="form-input"
                                            required
                                            min=""
                                        >
                                    </div>
                                    <br>
                                    <!-- Time Field -->
                                    <div class="form-group">
                                        <label for="reservation-time" class="form-label">Reservation Time</label>
                                        <select 
                                            id="reservation-time" 
                                            name="reservationTime"
                                            class="form-select"
                                            required
                                            aria-describedby="timeHelp"
                                        >
                                            <option value="">Select a time slot</option>
                                            <optgroup label="Afternoon">
                                                <option value="15">3:00 PM - 4:00 PM</option>
                                                <option value="16">4:00 PM - 5:00 PM</option>
                                                <option value="17">5:00 PM - 6:00 PM</option>
                                            </optgroup>
                                            <optgroup label="Evening">
                                                <option value="18">6:00 PM - 7:00 PM</option>
                                                <option value="19">7:00 PM - 8:00 PM</option>
                                                <option value="20">8:00 PM - 9:00 PM</option>
                                                <option value="21">9:00 PM - 10:00 PM</option>
                                                <option value="22">10:00 PM - 11:00 PM</option>
                                            </optgroup>
                                        </select>
                                        <small id="timeHelp" class="helper-text">Please select your preferred dining time</small>
                                    </div>
                                </div>
                                <br>
                                <!-- Number of Guests Field -->
                                <div class="form-group">
                                    <label for="guests" class="form-label">Number of Guests</label>
                                    <input 
                                        type="number" 
                                        id="guests" 
                                        name="numberOfGuests"
                                        class="form-input"
                                        required
                                        min="1"
                                        max="20"
                                        placeholder="Enter number of guests"
                                        aria-describedby="guestHelp"
                                    >
                                    <small id="guestHelp" class="helper-text">Maximum 20 guests per reservation</small>
                                </div>
                            </div>

                            <!-- Form Controls -->
                            
                                <button 
                                    type="submit" 
                                    class="submit-button"
                                    aria-label="Submit reservation request"
                                >
                                    Confirm Reservation
                                </button>
                            
                        </form>
=======
                <!-- Reservation Details Section -->
                <div class="form-section reservation-details">
                    <div class="form-row date-time">
                        <!-- Date Field -->
                        <div class="form-group">
                            <label for="reservation-date" class="form-label">Reservation Date</label>
                            <input 
                                type="date" 
                                id="reservation-date" 
                                name="reservation_date"
                                class="form-input"
                                required
                            >
                        </div>
                        <br>
                        <!-- Time Field -->
                        <div class="form-group">
                            <label for="reservation-time" class="form-label">Reservation Time</label>
                            <select 
                                id="reservation-time" 
                                name="reservation_time"
                                class="form-select"
                                required
                            >
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
                                    <option value="21:00">9:00 PM - 10:00 PM</option>
                                    <option value="22:00">10:00 PM - 11:00 PM</option>
                                </optgroup>
                            </select>
                        </div>
>>>>>>> d9d9898a680a267e8f74f2928a15a6ed3a899170
                    </div>
                    <br>
                    <!-- Number of Guests Field -->
                    <div class="form-group">
                        <label for="guests" class="form-label">Number of Guests</label>
                        <input 
                            type="number" 
                            id="guests" 
                            name="number_of_guests"
                            class="form-input"
                            required
                            min="1"
                            max="20"
                            placeholder="Enter number of guests"
                        >
                        <small id="guestHelp" class="helper-text">Maximum 20 guests per reservation</small>
                    </div>
                </div>

                <!-- Form Controls -->
                <button 
                    type="submit" 
                    class="submit-button"
                >
                    Confirm Reservation
                </button>
            </form>
        </div>
    </section>

    <script src="/JavaScript/dinein.js"></script>
</body>
</html>
