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
    <title>Dine-In Reservation - Kottu Labs</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="/CSS/dinein.css">
    
    <!-- Resource Preloading -->
    <link rel="preload" href="/Photo/Thirani_pics/dinein_pic.jpg" as="image">
    <link rel="preload" href="/CSS/dinein.css" as="style">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>

<body>
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header Section -->
            <header class="page-header">
                <h1 class="headline">Reserve your Spot & Enjoy!</h1>
            </header>

            <!-- Reservation Section -->
            <section class="reservation-section" aria-label="Reservation Form">
                <div class="card-container">
                    <!-- Restaurant Image -->
                    <div class="card-img">
                        <img 
                            src="/Photo/Thirani_pics/dinein_pic.jpg" 
                            alt="Kottu Labs dining area interior"
                            width="600"
                            height="400"
                            loading="eager"
                            class="restaurant-image"
                        >
                    </div>

                    <!-- Reservation Form Card -->
                    <div class="card-content">
                        <h2 class="form-title">Make a Reservation</h2>
                        
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
                            <div class="form-controls">
                                <button 
                                    type="submit" 
                                    class="submit-button"
                                    aria-label="Submit reservation request"
                                >
                                    Confirm Reservation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Initialize form validation and date restrictions
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('reservation-date').min = today;

            // Form validation
            const form = document.getElementById('reservationForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                // Add your form submission logic here
                console.log('Form submitted');
            });
        });
    </script>
    <script src="/JavaScript/dinein.js" defer></script>
</body>
</html>