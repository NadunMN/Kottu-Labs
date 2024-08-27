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


document.getElementById('signup-form').addEventListener('submit', function(event) {
    event.preventDefault();
//    var name = document.getElementById('name').value;
    var phoneNumber = document.getElementById('phone-number').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm-password').value;
    var errorMessage = document.getElementById('error-message');

    errorMessage.textContent = "";

    // Validate phone number
    if (!validatePhoneNumber(phoneNumber)) {
        displayErrorMessage(errorMessage, "Please enter a valid phone number.");
        return;
    }

    // Validate password length
    if (password.length < 6) {
        displayErrorMessage(errorMessage, "Password must be at least 6 characters long.");
        return;
    }

    // Validate password confirmation
    if (password !== confirmPassword) {
        displayErrorMessage(errorMessage, "Passwords do not match.");
        return;
    }

    alert('Account created successfully!');
});

// Password visibility toggle
document.getElementById('show-password').addEventListener('change', function() {
    var passwordField = document.getElementById('password');
    var confirmPasswordField = document.getElementById('confirm-password');
    if (this.checked) {
        passwordField.type = 'text';
        confirmPasswordField.type = 'text';
    } else {
        passwordField.type = 'password';
        confirmPasswordField.type = 'password';
    }
});
