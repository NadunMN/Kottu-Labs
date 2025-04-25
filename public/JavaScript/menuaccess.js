let expectedString = "ABC123";
const inputField = document.getElementById('input-string');
const verifyBtn = document.getElementById('verify-btn');
const successMessage = document.getElementById('success-message');
const errorMessage = document.getElementById('error-message');
const pinForm = document.getElementById('container-mainwraaper');
const reservationModal = document.getElementById('reservationModal');
const reservationForm = document.getElementById('reservationConfirmationForm');
const closeButton = document.querySelector('.close-button');
const pinFormSuccess = document.getElementById('success-message');

let steward_branchId;

// Fetch user data
fetch('user/data')
    .then(response => response.json())
    .then(data => {
        steward_branchId = data.branch_id;
        console.log('Steward Branch ID:', steward_branchId);
    })
    .catch(error => {
        console.error('Error fetching user data:', error);
    });

// Function to highlight registration status
const highlightRegistrationStatus = (isRegistered) => {
  const statusElement = document.getElementById('type-user');
  
  // Remove any existing classes
  statusElement.classList.remove('registered-user', 'unregistered-user');
  
  // Add appropriate class based on registration status
  if (isRegistered) {
    statusElement.classList.add('registered-user');
  } else {
    statusElement.classList.add('unregistered-user');
  }
};

// Verification handler
verifyBtn.addEventListener('click', async function () {
    const enteredString = inputField.value.trim();

    successMessage.style.display = 'none';
    errorMessage.style.display = 'none';
    inputField.style.borderColor = '';

    if (!enteredString) {
        errorMessage.textContent = 'Please enter a PIN.';
        errorMessage.style.display = 'block';
        inputField.style.borderColor = '#dc3545';
        return;
    }

    try {
        const response = await fetch(`/menuaccess/pin?enterPin=${encodeURIComponent(enteredString)}`);
        if (!response.ok) throw new Error(`Network error: ${response.statusText}`);
        
        const data = await response.json();
        if (data.error) throw new Error(data.error);

        // Successful verification
        successMessage.textContent = 'PIN verified successfully!';
        successMessage.style.display = 'block';
        inputField.style.borderColor = '#28a745';
        expectedString = data.temp_id || expectedString;

        pinForm.style.display = 'none';
        reservationModal.style.display = 'flex'; // Changed to flex for centering
        reservationModal.style.flexDirection = 'column';

        // Common UI update function
        const updateReservationUI = (userData, isRegisteredUser) => {
            // Reset styles
            document.getElementById('branch').style.color = '';
            document.getElementById('reservationDate').style.color = '';

            // Set basic info
            document.getElementById('fullname').textContent = userData.reservation_name;
            document.getElementById('reservationDate').textContent = userData.reservation_date;
            document.getElementById('reservationTime').textContent = userData.reservation_time;
            document.getElementById('numberOfGuests').textContent = userData.number_of_guests;
            document.getElementById('type-user').textContent = isRegisteredUser ? 'Registered User' : 'UnRegistered User';
            
            // Apply registration status highlighting
            highlightRegistrationStatus(isRegisteredUser);

            // Branch info
            const branch_id = Number(userData.branch_id);
            const branchName = branch_id === 1 ? 'Wattala' : branch_id === 2 ? 'Kelaniya' : 'Kotahena';
            document.getElementById('branch').textContent = branchName;

            // Reservation type
            const reservationType = userData.type;
            const typeLabel = document.getElementById('reservationTypeLabel');
            typeLabel.textContent = reservationType === 'dinein' ? 'Dine In' : 'Take Away';

            // Date validation
            const currentDate = new Date().toLocaleDateString('en-CA');
            const isToday = userData.reservation_date === currentDate;
            if (!isToday) {
                document.getElementById('reservationDate').style.color = 'red';
            }

            // Branch validation
            if (branch_id !== steward_branchId) {
                document.getElementById('branch').style.color = 'red';
            }

            // Show/hide confirmation button
            const confirmButton = document.querySelector('.confirm-button');
            if (userData.confirmation_status === 1  || branch_id !== steward_branchId) {
                confirmButton.style.display = 'none';
                document.querySelector('.confirmed-text').style.display = 'block';
                // document.querySelector('.confirmed-text').textContent = 'Reservation Confirmed';
                if(branch_id !== steward_branchId) {
                    document.querySelector('.confirmed-text').textContent = 'DIfferent Branch Reservation';
                    document.querySelector('.confirmed-text').style.color = 'red';


                }
            } else {
                confirmButton.style.display = 'block';
                document.querySelector('.confirmed-text').style.display = 'none';
            }

            // Table section handling
            const tableSection = document.querySelector('.table-assignment-section');
            if (reservationType === 'takeaway') {
                tableSection.style.display = 'none';
                document.getElementById('tableNumber').required = false;
                document.getElementById('numberOfGuests').parentElement.style.display = 'none';
                
                // Fetch order details for takeaway
                fetch(`/order/takeawayDetails?reservation_no=${userData.reservation_no}`)
                    .then(response => response.json())
                    .then(orderData => {
                        document.getElementById('orderNumber').textContent = orderData.order_number;
                        document.getElementById('orderItems').textContent = orderData.items
                            .map(item => `${item.meal_name} (x${item.quantity})`)
                            .join(', ');
                        document.getElementById('totalPrice').textContent = `$${orderData.total_price.toFixed(2)}`;
                        document.getElementById('orderDetails').style.display = 'block';
                    });
            } else {
                tableSection.style.display = 'block';
                document.getElementById('tableNumber').required = true;
                document.getElementById('numberOfGuests').parentElement.style.display = 'block';
                document.getElementById('orderDetails').style.display = 'none';
            }
        };

        if (data.data.temp_id === null) {
            // Registered user flow
            updateReservationUI(data.data, true);
        } else {
            // Unregistered user flow
            updateReservationUI(data.data, false);
        }

        // Form submission handler
        reservationForm.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(reservationForm);
            const submissionData = Object.fromEntries(formData.entries());
            submissionData.reservation_no = data.data.reservation_no;

            try {
                const response = await fetch("/reservation/addtable", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(submissionData)
                });
                
                if (!response.ok) throw new Error('Submission failed');
                
                reservationModal.style.display = 'none';
                
                // Show success message with animation
                const successMsg = document.getElementById('successMessage');
                pinForm.style.display = 'none';
                successMsg.style.display = 'block';
                successMsg.classList.add('show');
                
                setTimeout(() => {
                    reservationModal.style.display = 'none';
                    pinForm.style.display = 'flex';
                    inputField.value = '';
                    inputField.style.border = '1px solid #ced4da';
                    pinFormSuccess.style.display = 'none';
                    successMsg.style.display = 'none';
                    successMsg.classList.remove('show');
                    reservationForm.reset(); // Reset the form after successful submission
                    // pinForm.reset(); // Reset the form after successful submission
                }, 2000);

                // pinForm.reset(); // Reset the form after successful submission
                // pinForm.style.display = 'block'; // Change border color to green


            } catch (error) {
                console.error('Submission error:', error);
                alert('Error submitting reservation. Please try again.');
            }
        };

    } catch (error) {
        errorMessage.textContent = error.message;
        errorMessage.style.display = 'block';
        inputField.style.borderColor = '#dc3545';
        inputField.style.animation = 'shake 0.5s';
        setTimeout(() => inputField.style.animation = '', 500);
    }
});

// Enter key handler
inputField.addEventListener('keyup', (e) => {
    if (e.key === 'Enter') verifyBtn.click();
});

// Close modal handler
closeButton.addEventListener('click', () => {
    reservationModal.style.display = 'none';
    pinForm.style.display = 'flex';
    
    reservationForm.reset();
    // Reset success message if visible
    const successMsg = document.getElementById('successMessage');
    inputField.value = '';
    inputField.style.border = '1px solid #ced4da';
    pinFormSuccess.style.display = 'none';

    successMsg.style.display = 'none';
    successMsg.classList.remove('show');
});

// Update date and time in the header (optional enhancement)
const updateDateTime = () => {
    const now = new Date();
    const dateElement = document.getElementById('date');
    const clockElement = document.getElementById('clock');
    
    if (dateElement) {
        dateElement.textContent = now.toLocaleDateString('en-US', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
    }
    
    if (clockElement) {
        clockElement.textContent = now.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
    }
};

// Initialize date/time and update every minute
updateDateTime();
setInterval(updateDateTime, 60000);