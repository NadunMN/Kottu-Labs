// Function to validate a phone number
function validatePhoneNumber(phoneNumber) {
    // Regular expression to check if the phone number is exactly 10 digits
    var phonePattern = /^\d{10}$/;
    return phonePattern.test(phoneNumber);
}

// Function to display an error message
function displayErrorMessage(element, message) {
    element.textContent = message;
}

// Event listener for the login form
{document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();
    var phoneNumber = document.getElementById('Phone').value;
    var password = document.getElementById('password').value;
    var errorMessage = document.getElementById('error-message');

    errorMessage.textContent = "";

    if (!validatePhoneNumber(phoneNumber)) {
        displayErrorMessage(errorMessage, "Please enter a valid phone number.");
        return;
    }

    if (password.length < 6) {
        displayErrorMessage(errorMessage, "Invalid Password.");
        return;
    }

    alert('Form submitted successfully!');
});
}

document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('login-form');
    const errorMessage = document.getElementById('error-message');

    loginForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the form from submitting the traditional way

        const phone = document.getElementById('Phone').value;
        const password = document.getElementById('password').value;

        // Dummy validation logic for demonstration purposes
        if (phone === "0712345678" && password === "password123") {
            window.location.href = 'home.html';
        } else {
            errorMessage.textContent = "Invalid phone number or password. Please try again.";
        }
    });
});
