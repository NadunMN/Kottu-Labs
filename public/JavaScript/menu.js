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
reservationForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form values
    const name = document.getElementById('fullName').value;
    const email = document.getElementById('email').value;
    const date = document.getElementById('pickupDate').value;
    const time = document.getElementById('pickupTime').value;
    const branch = selectedBranchDisplay.textContent;
    const address = selectedBranchAddress.textContent;
    
    // Generate reservation number
    const reservationNumber = generateReservationNumber();
    
    // Format date and time for display
    const formattedDate = new Date(date).toLocaleDateString('en-US', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
    
    // Update success message with more details
    successMessage.innerHTML = `
        <h3 style="color: #155724; margin-bottom: 15px;">Your takeaway order has been successfully placed!</h3>
        <div style="border-top: 1px solid #c3e6cb; padding-top: 15px; margin-top: 10px;">
            <div style="font-size: 1.1rem; margin-bottom: 10px;">Reservation #: <strong>${reservationNumber}</strong></div>
            <div style="margin-bottom: 5px;"><strong>Branch:</strong> ${branch}</div>
            <div style="margin-bottom: 5px;"><strong>Address:</strong> ${address}</div>
            <div style="margin-bottom: 5px;"><strong>Pickup:</strong> ${formattedDate} at ${time}</div>
            <div style="margin-top: 15px; font-size: 0.9rem;">A confirmation has been sent to <strong>${email}</strong></div>
        </div>
    `;
    
    // Hide form and show success message
    takeawayForm.classList.remove('active');
    successMessage.classList.add('active');
    
    // Reset form
    reservationForm.reset();
});