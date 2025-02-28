document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.pin-digit');
    const submitButton = document.querySelector('.submit-button');
    const messageDiv = document.querySelector('.pin-message');
    const reservationForm = document.getElementById('reservationConfirmationForm');
    const successMessage = document.getElementById('successMessage');
    const closeButton = document.querySelector('.close-button');
    const reservationModal = document.getElementById('reservationModal');
    const pinEntrySection = document.getElementById('pinEntrySection');
    let ReservationNo;

    function updateTime() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
      
        const timeString = `${hours}:${minutes}:${seconds}`;
      
        document.getElementById('clock').textContent = timeString;
      }
      
      // Update time every second
      setInterval(updateTime, 1000);
      
      // Initialize the clock immediately
      updateTime();

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

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
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

        // Reset previous reservation details
        document.getElementById('fullname').textContent = '';
        document.getElementById('reservationDate').textContent = '';
        document.getElementById('reservationTime').textContent = '';
        document.getElementById('numberOfGuests').textContent = '';
        document.getElementById('branch').textContent = '';
        ReservationNo = null;
        reservationModal.style.display = 'none';
        successMessage.style.display = 'none';

        try {
            const response = await fetch(`/reservation/otp?pin=${pin}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const text = await response.text();
            const result = JSON.parse(text);

            if (result.success) {
                pinEntrySection.style.display = 'none';
                reservationModal.style.display = 'block';
                document.getElementById('fullname').textContent = result.reservation[0].userName;
                document.getElementById('reservationDate').textContent = result.reservation[0].reservation_date;
                document.getElementById('reservationTime').textContent = result.reservation[0].reservation_time;
                document.getElementById('numberOfGuests').textContent = result.reservation[0].number_of_guests;

                ReservationNo = result.reservation[0].reservation_no;

                const status = result.reservation[0].confirmation_status;

                if (status === 1) {
                    document.querySelector('.confirmed-text').style.display = 'block';
                    document.querySelector('.confirm-button').style.display = 'none';
                    document.getElementById('tableNumber').style.display = 'none';
                } else {
                    document.querySelector('.confirmed-text').style.display = 'none';
                    document.querySelector('.confirm-button').style.display = 'block';
                    document.getElementById('tableNumber').style.display = 'block';
                }

                const branch_id = result.reservation[0].branch_id;
                const branchName = branch_id === 1 ? 'Wattala' : branch_id === 2 ? 'Kelaniya' : 'Kotahena';
                document.getElementById('branch').textContent = branchName;

                const reservationType = result.reservation[0].type;

                // Set the text content of the labels and apply strike-through effect
                if (reservationType === 'dinein') {
                    document.getElementById('dineInLabel').innerHTML = 'Dine In';
                    document.getElementById('takeAwayLabel').innerHTML = '<s>Take Away</s>';
                } else {
                    document.getElementById('dineInLabel').innerHTML = '<s>Dine In</s>';
                    document.getElementById('takeAwayLabel').innerHTML = 'Take Away';
                }

                // check with the current date
                const currentDate = new Date();
                const formattedCurrentDate = currentDate.toISOString().split('T')[0];

                const reservationDate = result.reservation[0].reservation_date;
                const reservationDateInput = document.getElementById('reservationDate');
                if (reservationDate === formattedCurrentDate) {
                    reservationDateInput.style.color = '';
                } else {
                    reservationDateInput.style.color = 'red';
                }

                // Reset the form and show the confirm button
                reservationForm.reset();
                reservationForm.style.display = 'block';
                document.querySelector('.submit-button').style.display = 'block';
                document.querySelector('.confirmation-box').style.display = 'block';
            } else {
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
    reservationForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        data.reservation_no = ReservationNo;

        const requestBody = JSON.stringify(data);
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
            reservationForm.style.display = 'none';
            pinEntrySection.style.display = 'none';
            successMessage.style.display = 'flex';
            document.querySelector('.confirmation-box').style.display = 'none';
            document.querySelector('#reservationModal .pin-topic').style.display = 'none'; // Hide the pin-topic

            setTimeout(() => {
                successMessage.style.display = 'none';
                reservationModal.style.display = 'none';
                pinEntrySection.style.display = 'block';
                inputs.forEach(input => {
                    input.value = '';
                });
                inputs[0].focus();
                document.querySelector('.confirmation-box').style.display = 'block';
                document.querySelector('#reservationModal .pin-topic').style.display = 'block'; // Show the pin-topic again
            }, 2000);
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while submitting your reservation. Please try again.");
        });
    });

    // Close button handler
    closeButton.addEventListener('click', function() {
        reservationModal.style.display = 'none';
        pinEntrySection.style.display = 'block';
        inputs.forEach(input => {
            input.value = '';
        });
        inputs[0].focus();
        messageDiv.textContent = '';
        document.querySelector('.confirmation-box').style.display = 'block';
    });

    // Reset form and modal when entering another PIN
    function resetFormAndModal() {
        reservationForm.reset();
        reservationForm.style.display = 'block';
        document.querySelector('.submit-button').style.display = 'block';
        pinEntrySection.style.display = 'block';
        inputs.forEach(input => {
            input.value = '';
        });
        inputs[0].focus();
        document.querySelector('.confirmation-box').style.display = 'block'; // Ensure confirmation box is shown
    }

    // Call resetFormAndModal when needed
    successMessage.addEventListener('transitionend', resetFormAndModal);
});