document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.pin-digit');
    const submitButton = document.querySelector('.submit-button');
    const messageDiv = document.querySelector('.pin-message');

    // Auto-focus next input
    inputs.forEach((input, index) => {
        input.addEventListener('input', function() {
            if (this.value.length === 1) {
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            }
        });

        // Handle backspace
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });
    
        inputs[0].focus(); // Focus the first input
    
    // Submit handler
    submitButton.addEventListener('click', async function() {
        let pin = '';
        inputs.forEach(input => {
            pin += input.value;
        });

        if (pin.length !== 5) {
            messageDiv.textContent = 'Please enter all 5 digits';
            return;
        }

        messageDiv.textContent = 'Verifying PIN...';
        
        try {
            const response = await fetch('/reservation/otp?pin=${encodeURIComponent(pin)}', {
                method: 'GET',
                
                
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            console.log(response);
            
            
            const result = await response.json();
            console.log(result);
            
            if (result.success) {
                alert("PIN verified successfully!"); 
            } else {
                messageDiv.textContent = 'Invalid PIN. Please try again.';
                inputs.forEach(input => {
                    input.value = ''; // Clear each input
                });
                inputs[0].focus();
            }
        } catch (error) {
            console.error("Error verifying PIN:", error);
            messageDiv.textContent = 'Failed to verify PIN.';
        }
    });
});