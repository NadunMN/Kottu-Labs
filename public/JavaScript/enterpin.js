document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.pin-digit');
    const submitButton = document.querySelector('.submit-button');
    const messageDiv = document.querySelector('.pin-message');
    const reservationForm = document.getElementById('reservationConfirmationForm');

    let userId;
    let ReservationNo;

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
            console.log(result);
            console.log(result.reservation[0].userName);

            

            if (result.success) {
                pinEntrySection.style.display = 'none'; 
                document.getElementById('modalMessage').textContent = ''; 
                document.getElementById('reservationModal').style.display = 'block';
                
                document.getElementById('fullname').value = result.reservation[0].userName; 
                document.getElementById('reservationDate').value = result.reservation[0].reservation_date; 
                document.getElementById('reservationTime').value= result.reservation[0].reservation_time; 
                document.getElementById('numberOfGuests').value = result.reservation[0].number_of_guests; 

                ReservationNo = result.reservation[0].reservation_time;
                
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



     // Single submit event listener
     reservationForm.addEventListener('submit', function (event) {
        event.preventDefault();  // Prevent default form submission

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        data.reservation_no = ReservationNo;  // Add user ID to the form data
        
        const requestBody = JSON.stringify(data);

        console.log('Request Body:', requestBody);  // Log the request body for debugging

        fetch("/reservation/addtable", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: requestBody,
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Success:", data);
            alert("Reservation successful!");  // Example success message
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while submitting your reservation. Please try again.");
        });
    });



     window.onclick = function(event) {
        const modal = document.getElementById('reservationModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }

    
    
});