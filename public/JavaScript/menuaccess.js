let expectedString = "ABC123"; // Initial value, though server response should dictate validation

const inputField = document.getElementById('input-string');
const verifyBtn = document.getElementById('verify-btn');
const successMessage = document.getElementById('success-message');
const errorMessage = document.getElementById('error-message');
const pinForm = document.getElementById('container-mainwraaper'); // Ensure this ID matches your HTML
const reservationModal = document.getElementById('reservationModal'); // Ensure this ID matches your HTML
const reservationForm = document.getElementById('reservationConfirmationForm');
const closeButton = document.querySelector('.close-button');



// Verify button click event
verifyBtn.addEventListener('click', async function () {
    const enteredString = inputField.value.trim();

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
    fetch(`/menuaccess/pin?enterPin=${encodeURIComponent(enteredString)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then(async (data) => { // Mark callback as async to use await
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
                successMessage.style.display = 'block';
                inputField.style.borderColor = '#28a745';

                // Update expectedString if needed
                expectedString = data.temp_id || expectedString;
                console.log('Expected String:', expectedString); 

                pinForm.style.display = 'none';
                reservationModal.style.display = 'block';

                if (data.data.temp_id === null) {
                    const userData = data.data;
                    console.log('User Type:', userData.reservation_name);

                    // Update reservation details
                    document.getElementById('fullname').textContent = userData.reservation_name;
                    document.getElementById('reservationDate').textContent = userData.reservation_date;
                    document.getElementById('reservationTime').textContent = userData.reservation_time;
                    document.getElementById('numberOfGuests').textContent = userData.number_of_guests;

                    const ReservationNo = userData.reservation_no; // Properly declared with const
                    const status = userData.confirmation_status;
                    const reservationType = userData.type;

                    if (reservationType === 'takeaway') {
                        document.querySelector('.table-assignment-section').style.display = 'none';
                        document.getElementById('tableNumber').required = false;
                        document.getElementById('numberOfGuests').parentElement.style.display = 'none';

                        try {
                            const orderResponse = await fetch(`/order/takeawayDetails?reservation_no=${ReservationNo}`);
                            if (!orderResponse.ok) {
                                throw new Error("Failed to fetch order details");
                            }
                            const orderData = await orderResponse.json();
                    
                            document.getElementById('orderNumber').textContent = orderData.order_number;
                            document.getElementById('orderItems').textContent = orderData.items
                                .map(item => `${item.meal_name} (x${item.quantity})`)
                                .join(', ');
                            document.getElementById('totalPrice').textContent = `$${orderData.total_price.toFixed(2)}`;
                    
                            document.getElementById('orderDetails').style.display = 'block';
                        } catch (error) {
                            console.error("Error fetching order details:", error);
                        }
                    } else {
                        document.querySelector('.table-assignment-section').style.display = 'block';
                        document.getElementById('tableNumber').required = true;
                        document.getElementById('numberOfGuests').parentElement.style.display = 'block';
                    }

                    if (status === 1) {
                        document.querySelector('.confirmed-text').style.display = 'block';
                        document.querySelector('.confirm-button').style.display = 'none';
                        document.getElementById('tableNumber').style.display = 'none';
                    }

                    const branch_id = Number(data.data.branch_id);
                const reservationBranchInput = document.getElementById('branch');
                const branchName = branch_id === 1 ? 'Wattala' : branch_id === 2 ? 'Kelaniya' : 'Kotahena';
                document.getElementById('branch').textContent = branchName;

                document.getElementById('type-user').textContent = 'Registered User'; // Set the user type label


                // Set the text content of the labels and apply strike-through effect
                
                const reservationTypeLabel = document.getElementById('reservationTypeLabel'); // Use a single label element
                reservationTypeLabel.textContent = reservationType === 'dinein' ? 'Dine In' : 'Take Away';

                // check with the current date
                const formattedCurrentDate = new Date().toLocaleDateString('en-CA');

                const reservationDate = data.data.reservation_date;
                const reservationDateInput = document.getElementById('reservationDate');
                if (reservationDate != formattedCurrentDate) {
                    reservationDateInput.style.color = 'red';
                    document.querySelector('.confirm-button').style.display = 'none';
                }
                
                // Reset the form and show the confirm button
                reservationForm.reset();
                reservationForm.style.display = 'block';

                // Single submit event listener
    reservationForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        data.reservation_no = ReservationNo;

        console.log('Form Data:', data); // Log the form data for debugging

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
        pinForm.style.display = 'block';
        messageDiv.textContent = '';
        });

    // Reset form and modal when entering another PIN
    function resetFormAndModal() {
        reservationForm.reset();
        reservationForm.style.display = 'block';
        document.querySelector('.submit-button').style.display = 'block';
        pinForm.style.display = 'block'; // Ensure confirmation box is shown
    }

    // Call resetFormAndModal when needed
    successMessage.addEventListener('transitionend', resetFormAndModal);
                
    }else{

                    // Handle other user types if needed
                    console.log('User Type:', data.type);
                    console.log('User Data:', data.data);

                    const userData = data.data;


                     // Update reservation details
                     document.getElementById('fullname').textContent = userData.reservation_name;
                     document.getElementById('reservationDate').textContent = userData.reservation_date;
                     document.getElementById('reservationTime').textContent = userData.reservation_time;
                     document.getElementById('numberOfGuests').textContent = userData.number_of_guests;

                     const ReservationNo = userData.reservation_no;
                    const status = userData.confirmation_status;
                    const reservationType = userData.type;


                    
                        document.querySelector('.table-assignment-section').style.display = 'block';
                        document.getElementById('tableNumber').required = true;
                        document.getElementById('numberOfGuests').parentElement.style.display = 'block';
                    

                    if (status === 1) {
                        document.querySelector('.confirmed-text').style.display = 'block';
                        document.querySelector('.confirm-button').style.display = 'none';
                        document.getElementById('tableNumber').style.display = 'none';
                    }

                    const branch_id = Number(data.data.branch_id);
                const reservationBranchInput = document.getElementById('branch');
                const branchName = branch_id === 1 ? 'Wattala' : branch_id === 2 ? 'Kelaniya' : 'Kotahena';
                document.getElementById('branch').textContent = branchName;
                document.getElementById('type-user').textContent = 'UnRegistered User'; // Set the user type label



                // Set the text content of the labels and apply strike-through effect
                
                const reservationTypeLabel = document.getElementById('reservationTypeLabel'); // Use a single label element
                reservationTypeLabel.textContent = reservationType === 'dinein' ? 'Dine In' : 'Take Away';

                // check with the current date
                const formattedCurrentDate = new Date().toLocaleDateString('en-CA');

                const reservationDate = data.data.reservation_date;
                const reservationDateInput = document.getElementById('reservationDate');
                if (reservationDate != formattedCurrentDate) {
                    reservationDateInput.style.color = 'red';
                    document.querySelector('.confirm-button').style.display = 'none';
                }
                
                // Reset the form and show the confirm button
                reservationForm.reset();
                reservationForm.style.display = 'block';

                // Single submit event listener
    reservationForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        data.reservation_no = ReservationNo;

        console.log('Form Data:', data); // Log the form data for debugging

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
            successMessage.style.display = 'flex';
            document.querySelector('.confirmation-box').style.display = 'none';
            document.querySelector('#reservationModal .pin-topic').style.display = 'none'; // Hide the pin-topic

            setTimeout(() => {
                successMessage.style.display = 'none';
                reservationModal.style.display = 'none';
                pinForm.style.display = 'block';
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
        pinForm.style.display = 'block';
        messageDiv.textContent = '';
        });

    // Reset form and modal when entering another PIN
    function resetFormAndModal() {
        reservationForm.reset();
        reservationForm.style.display = 'block';
        document.querySelector('.submit-button').style.display = 'block';
        pinForm.style.display = 'block'; // Ensure confirmation box is shown
    }

    // Call resetFormAndModal when needed
    successMessage.addEventListener('transitionend', resetFormAndModal);
                





































    }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorMessage.textContent = 'An error occurred. Please try again.';
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