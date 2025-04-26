let expectedString = "ABC123"; // Initial value, though server response should dictate validation

const inputField = document.getElementById('input-string');
const verifyBtn = document.getElementById('verify-btn');
const successMessage = document.getElementById('success-message');
const errorMessage = document.getElementById('error-message');

// Verify button click event
verifyBtn.addEventListener('click', function () {
    const enteredString = inputField.value.trim();

    console.log('Entered String:', enteredString); // Log the entered string for debugging

    // Reset messages and styles
    successMessage.style.display = 'none';
    errorMessage.style.display = 'none';
    inputField.style.borderColor = '';

    if (!enteredString) {
        errorMessage.textContent = 'Please enter a PIN.';
        errorMessage.style.display = 'block';
        inputField.style.borderColor = '#dc3545';
        return;
    }
    


    // Fetch validation from the server
    fetch(`/getReservationDataUnReg?reservationNo=${enteredString}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                // Server returned an error message
                errorMessage.textContent = data.error;
                errorMessage.style.display = 'block';
                inputField.style.borderColor = '#dc3545';
                inputField.style.animation = 'shake 0.5s';
                setTimeout(() => inputField.style.animation = '', 500);
            } else {
                // Server confirmed the PIN is correct
                successMessage.textContent = 'PIN verified successfully!';
                successMessage.style.display = 'none';
                inputField.style.borderColor = '#28a745';

                // Update expectedString if needed (e.g., for future checks)
                expectedString = data[0].reservation_no || expectedString;

                console.log('Expected String:', expectedString); // Log the expected string for debugging


                window.location.href = `/stewardmenu?reservationNo=${encodeURIComponent(expectedString)}`;

                

            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorMessage.textContent = 'Invalid Reservation Number.';
            errorMessage.style.display = 'block';
            inputField.style.borderColor = '#dc3545';
            inputField.style.animation = 'shake 0.5s';
            setTimeout(() => inputField.style.animation = '', 500);
        });
});

// Trigger verification on Enter key press
inputField.addEventListener('keyup', function (event) {
    if (event.key === 'Enter') {
        verifyBtn.click();
    }
});