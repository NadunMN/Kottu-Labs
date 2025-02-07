document.addEventListener("DOMContentLoaded", function() {
    let dateInput = document.getElementById("reservationDate");
    let today = new Date();
    let maxDate = new Date();
    maxDate.setDate(today.getDate() + 14);

    let minDateStr = today.toISOString().split("T")[0];
    let maxDateStr = maxDate.toISOString().split("T")[0];

    dateInput.setAttribute("min", minDateStr);
    dateInput.setAttribute("max", maxDateStr);
});

document.getElementById('reservationForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let isValid = true;
    let reservationDate = document.getElementById('reservationDate').value;
    let dateError = document.getElementById('dateError');

    let today = new Date();
    let maxDate = new Date();
    maxDate.setDate(today.getDate() + 14);

    function normalizeDate(date) {
        return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }

    let selectedDate = normalizeDate(new Date(reservationDate));
    let todayNormalized = normalizeDate(today);
    let maxDateNormalized = normalizeDate(maxDate);

    if (selectedDate < todayNormalized || selectedDate > maxDateNormalized) {
        dateError.innerText = "Reservations can only be made within the next 14 days.";
        dateError.style.color = "red";
        isValid = false;
    } else {
        dateError.innerText = "";
    }

    let timeDropdown = document.getElementById("reservationTime");

    // // Function to generate time slots from 3 PM to 11 PM
    // function generateTimeSlots(startHour, endHour) {
    //     let times = [];
    //     for (let hour = startHour; hour < endHour; hour++) {
    //         let formattedHour = hour.toString().padStart(2, '0');
    //         times.push(`${formattedHour}:00`);
    //     }
    //     return times;
    // }

    // // 3 PM to 11 PM
    // let validTimes = generateTimeSlots(15, 23); // 3 PM (15) to 11 PM (23)

    // // Add the time options to the dropdown
    // validTimes.forEach(time => {
    //     let option = document.createElement("option");
    //     option.value = time;
    //     option.textContent = time;
    //     timeDropdown.appendChild(option);
    // });

    // Validate the time selection on form submission
    document.getElementById('reservationForm').addEventListener('submit', function(event) {
        let selectedTime = timeDropdown.value;
        let timeError = document.getElementById("timeError");

        if (!selectedTime || selectedTime === "hour-select") {
            timeError.innerText = "Please select a valid reservation time.";
            event.preventDefault(); // Prevent form submission
        } else {
            timeError.innerText = ""; // Clear the error
        }
    });

    // Phone Number Validation
    let phoneNumber = document.getElementById("phoneNumber").value;
    let phoneError = document.getElementById("phoneError");

    // Regex for validating phone number (US format as an example)
    let phoneRegex = /^[\+]?[0-9]{1,4}[-\s]?(\(?\d{3}\)?[-\s]?)?\d{3}[-\s]?\d{4}$/;

    if (!phoneRegex.test(phoneNumber)) {
        phoneError.innerText = "Please enter a valid phone number.";
        phoneError.style.color = "red";
        isValid = false;
    } else {
        phoneError.innerText = "";
    }

    if (isValid) {
        // Generate a random reservation number
        let reservationNumber = Math.floor(Math.random() * 900000) + 100000; // Random 6-digit number

        // Show the success popup with the reservation number
        showPopup(reservationNumber);
    }
});

// Function to show the popup
function showPopup(reservationNumber) {
    let popup = document.getElementById("popup");
    let popupMessage = popup.querySelector("p");
    popupMessage.innerText = `Reservation Successful. Reservation number has been sent to the phone number.`;

    popup.style.display = "block";  // Show the popup
}

// Function to close the popup and reset the form
function closePopup() {
    let popup = document.getElementById("popup");
    popup.style.display = "none";  // Hide the popup

    // Reset the form fields
    let reservationForm = document.getElementById("reservationForm");
    reservationForm.reset();  // Resets all the form fields to their initial values

    // Clear any error messages
    let errorMessages = document.querySelectorAll(".error");
    errorMessages.forEach(error => {
        error.innerText = "";
    });
}
