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

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    
    
        input.addEventListener('keydown',function(e){
            if(e.key === 'Enter'){
                e.preventDefault();
                submitButton.click();
            }
        });
    });
    inputs[0].focus();
    
    // Submit handler
    submitButton.addEventListener('click', async function() {
        let pin = '';
        inputs.forEach(input => {
            pin += input.value;
        });

        if (pin.length !== 6) {
            messageDiv.textContent = 'Please enter 6 digits';
            return;
        }

        messageDiv.textContent = 'Verifying PIN...';
        
        try {
            const response = await fetch(`/reservation/otp?pin=${pin}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            
            const text = await response.text();
            const result = JSON.parse(text);

            if (result.success) {
                pinEntrySection.style.display = 'none'; 
                document.getElementById('modalMessage').textContent = ''; 
                document.getElementById('reservationModal').style.display = 'block';
                
                document.getElementById('reservationDate').value = result.reservation.reservation_date; 
                document.getElementById('reservationTime').value= result.reservation.reservation_time; 
                document.getElementById('numberOfGuests').value = result.reservation.number_of_guests; 
                
                const branch_id = result.reservation.branch_id;
                const branchName = branch_id === '1' ? 'Wattala' : branch_id === '2' ? 'Kelaniya' : 'Kotahena';
                document.getElementById('branch').value = branchName;

                 // check with the current date
                 const currentDate = new Date();
                 const formattedCurrentDate = currentDate.toISOString().split('T')[0]; 
                 const reservationDate= result.reservation.reservation_date;
                 const reservationDateInput = document.getElementById('reservationDate'); 
                 if (reservationDate === formattedCurrentDate) {
                     reservationDateInput.style.color = ''; 
                    } 
                    else {
                     reservationDateInput.style.color = 'red'; 
                    }
            }
            else {
                messageDiv.textContent = 'Invalid PIN. Please try again.';
                inputs.forEach(input => {
                    input.value = ''; 
                });
                inputs[0].focus();
            }
        } catch (error) {
            console.error("Error verifying PIN:", error);
            messageDiv.textContent = 'Failed to verify PIN.';
        }
    });
     window.onclick = function(event) {
        const modal = document.getElementById('reservationModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }
});