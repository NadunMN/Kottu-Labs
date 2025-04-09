document.addEventListener("DOMContentLoaded", function() {
    const storedRequestBody = localStorage.getItem("reservationData");
    const inputs = document.querySelectorAll('.pin-digit');
    const submitButton = document.querySelector('.submit-button-enter');
    const messageDiv = document.querySelector('.pin-message');

    let requestBody;
    let confirmationNumber;

    if (storedRequestBody) {
        try {
            requestBody = JSON.parse(storedRequestBody);
            confirmationNumber = requestBody.confirmation_number;
            console.log('Stored Request Body:', requestBody);
            // console.log('Confirmation Number:', confirmationNumber);
        } catch (error) {
            console.error("Error parsing stored request body:", error);
            messageDiv.textContent = 'Error loading reservation data.';
            return;
        }
    } else {
        messageDiv.textContent = 'No reservation data found.';
        return;
    }

    if (!confirmationNumber) {
        messageDiv.textContent = 'Invalid reservation data. Please try again.';
        console.error("confirmationNumber is undefined or null.");
        return;
    }

    // Auto-focus next input
    inputs.forEach((input, index) => {
        input.addEventListener('input', function() {
            if (this.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                inputs[index - 1].focus();
            }
            if (e.key === 'Enter') {
                e.preventDefault();
                submitButton.click();
            }
        });
    });

    if (inputs.length > 0) inputs[0].focus();
    
    if (!submitButton) {
        console.error("Submit button not found!");
        return;
    }

    // Submit handler
    submitButton.addEventListener('click', async function(event) {
        event.preventDefault();
        let pin = '';
        inputs.forEach(input => pin += input.value);

        console.log("Entered PIN:", pin);
        console.log("Stored Confirmation Number:", confirmationNumber);

        if (pin.length !== 6) {
            messageDiv.textContent = 'Please enter 6 digits';
            return;
        }

        if (pin.trim() === String(confirmationNumber).trim()) { 
            messageDiv.textContent = 'PIN verified! Storing reservation...';

            try {
                const response = await fetch("/reservation/add", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(requestBody),
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => null);
                    throw new Error(errorData?.message || `HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();
                console.log("Success:", data);
                alert("Reservation successful!");
                window.location.href = '/successreservation';
            } catch (error) {
                console.error("Error:", error);
                alert(`An error occurred: ${error.message}`);
            }

        } else {
            messageDiv.textContent = 'Invalid PIN. Please try again.';
            
            setTimeout(() => {
                inputs.forEach(input => input.value = '');
                inputs[0].focus();
            }, 500);
        }
    });
});
