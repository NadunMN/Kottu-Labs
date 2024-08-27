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

// Event listener for the forgot password form
document.getElementById('forgot-password-form').addEventListener('submit', function(event) {
    event.preventDefault();
    var phoneNumber = document.getElementById('phone').value;
    var errorMessage = document.getElementById('error-message');

    errorMessage.textContent = "";

    if (!validatePhoneNumber(phoneNumber)) {
        displayErrorMessage(errorMessage, "Please enter a valid phone number.");
        return;
    }

    alert('Reset code sent successfully!');
});
