// Get all elements
const branchSelection = document.getElementById('branchSelection');
const selectionSection = document.getElementById('selectionSection');
const branchCards = document.querySelectorAll('.branch-card');
const takeawayForm = document.getElementById('takeawayForm');
const reservationForm = document.getElementById('reservationForm');
const successMessage = document.getElementById('successMessage');
const selectedBranchDisplay = document.getElementById('selectedBranchDisplay');
const selectedBranchAddress = document.getElementById('selectedBranchAddress');
const backToSelectionBtn = document.getElementById('backToSelection');
const headerSection = document.getElementById('header');

// Set minimum date for pickup to today
const today = new Date().toISOString().split('T')[0];
document.getElementById('pickupDate').min = today;

// Add click event to all branch cards
branchCards.forEach(card => {
    card.addEventListener('click', function() {
        // Get the branch information
        headerSection.style.display = 'none';
        const branchName = this.querySelector('.branch-name').textContent;
        const branchAddress = this.querySelector('.branch-address').textContent;
        
        // Update the form with the selected branch
        selectedBranchDisplay.textContent = branchName;
        selectedBranchAddress.textContent = branchAddress;
        
        // Hide the branch selection and show the form
        selectionSection.style.display = 'none';
        takeawayForm.classList.add('active');
    });
});

// Back to selection button
backToSelectionBtn.addEventListener('click', function() {
    takeawayForm.classList.remove('active');
    headerSection.style.display = 'block';
    selectionSection.style.display = 'block';

});

// Generate reservation number
function generateReservationNumber() {
    const prefix = "KL";
    const timestamp = new Date().getTime().toString().slice(-6);
    const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
    return `${prefix}${timestamp}${random}`;
}

// Handle form submission
// reservationForm.addEventListener('submit', function(e) {
//     e.preventDefault();
    
//     // Get form values
//     const name = document.getElementById('fullName').value;
//     const email = document.getElementById('email').value;
//     const date = document.getElementById('pickupDate').value;
//     const time = document.getElementById('pickupTime').value;
//     const branch = selectedBranchDisplay.textContent;
//     const address = selectedBranchAddress.textContent;
    
//     // Generate reservation number
//     const reservationNumber = generateReservationNumber();
    
//     // Format date and time for display
//     const formattedDate = new Date(date).toLocaleDateString('en-US', { 
//         weekday: 'long', 
//         year: 'numeric', 
//         month: 'long', 
//         day: 'numeric' 
//     });
    
//     // Update success message with more details
//     successMessage.innerHTML = `
//         <h3 style="color: #155724; margin-bottom: 15px;">Your takeaway order has been successfully placed!</h3>
//         <div style="border-top: 1px solid #c3e6cb; padding-top: 15px; margin-top: 10px;">
//             <div style="font-size: 1.1rem; margin-bottom: 10px;">Reservation #: <strong>${reservationNumber}</strong></div>
//             <div style="margin-bottom: 5px;"><strong>Branch:</strong> ${branch}</div>
//             <div style="margin-bottom: 5px;"><strong>Address:</strong> ${address}</div>
//             <div style="margin-bottom: 5px;"><strong>Pickup:</strong> ${formattedDate} at ${time}</div>
//             <div style="margin-top: 15px; font-size: 0.9rem;">A confirmation has been sent to <strong>${email}</strong></div>
//         </div>
//     `;
    
//     // Hide form and show success message
//     takeawayForm.classList.remove('active');
//     successMessage.classList.add('active');
    
//     // Reset form
//     reservationForm.reset();
// });




document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.getElementById('pickupDate');
    const randomNumber = Math.floor(Math.random() * 900000) + 100000;

    let userId;  // Declare userId for later use

    // Set date range for the reservation date
    const today = new Date();
    const oneMonthLater = new Date();
    oneMonthLater.setMonth(today.getMonth() + 1);

    const formatDate = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    dateInput.setAttribute('min', formatDate(today));
    dateInput.setAttribute('max', formatDate(oneMonthLater));

    // Fetch user data from the backend
    fetch('/user/data')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error(data.error);
            } else {
                userId = data.id;  // Store user ID
                console.log('User:', userId);
            }
        })
        .catch(error => console.error('Error fetching user data:', error));

    // Single submit event listener
    reservationForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission
    
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        console.log('Form Data:', data);  // Log the form data for debugging
        data.reservation_name = document.getElementById('fullName').value
        data.email = document.getElementById('email').value;
        data.reservation_time = document.getElementById('pickupTime').value;
        data.reservation_date = document.getElementById('pickupDate').value; 
        data.confirmation_status = 1;  // Set confirmation status to 1

        
        const branch = selectedBranchDisplay.textContent.trim().toLowerCase().split(" ")[0];
        console.log('Selected Branch:', branch);  // Log the selected branch for debugging

        if (branch) {
            switch (branch) {
            case 'wattala':
                data.branch_id = 1;
                break;
            case 'kotahena':
                data.branch_id = 2;
                break;
            case 'kelaniya':
                data.branch_id = 3;
                break;
            }
        } else {
            console.error('No branch selected');
            return; // Exit the function if no branch is selected
        }


        data.user_id = userId;  // Add user ID to the form data
        data.confirmation_number = randomNumber;  // Add confirmation number to the form data
        data.type = 'takeaway';  // Add reservation type to the form data
        const requestBody = JSON.stringify(data);
    
        console.log('Request Body:', requestBody);  // Log the request body for debugging
        localStorage.setItem('reservationData', requestBody);  // Store reservation data in local storage
    
        // Change form action
        reservationForm.action = `/reservationNumber?random=${randomNumber}`;
        
        // Submit the form programmatically after ensuring action is set
        setTimeout(() => {
            reservationForm.submit(); 
        }, 100); // Add a slight delay to ensure `action` is set
    
        // Redirect only **after** form submission is processed
        setTimeout(() => {
            window.location.href = '/confirmreservation';
        }, 500);
    });
    
});
