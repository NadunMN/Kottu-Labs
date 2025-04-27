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
                // Populate the form fields with user data
                document.getElementById('fullName').value = `${data.firstname} ${data.lastname}`;
                document.getElementById('email').value = data.email;
            }
        })
        .catch(error => console.error('Error fetching user data:', error));

    // Single submit event listener
    reservationForm.addEventListener('submit',  async function (event) {
        event.preventDefault(); // Prevent default form submission
    
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        console.log('Form Data:', data);  // Log the form data for debugging
        data.reservation_name = document.getElementById('fullName').value
        data.email = document.getElementById('email').value;
        data.reservation_time = document.getElementById('pickupTime').value;
        data.reservation_date = document.getElementById('pickupDate').value; 
        data.confirmation_status = 0;  // Set confirmation status to 1

        
        const branch = selectedBranchDisplay.textContent.trim().toLowerCase().split(" ")[0];
        console.log('Selected Branch:', branch);  // Log the selected branch for debugging

        if (branch) {
            switch (branch) {
            case 'wattala':
                data.branch_id = 1;
                break;
            case 'kotahena':
                data.branch_id = 3;
                break;
            case 'kelaniya':
                data.branch_id = 2;
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
        try {
            const response = await fetch("/reservation/add", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: requestBody,
            });
        
            if (!response.ok) {
                const errorData = await response.json().catch(() => null);
                throw new Error(errorData?.message || `HTTP error! Status: ${response.status}`);
            }
        
            const data = await response.json();
        
            // Check success field in response body
            if (!data.success) {
                showToast("That time slot is currently unavailable. Kindly choose another.",  { type: 'info', duration: 5000});
                
                throw new Error(data.message || "Reservation failed.");
            }
        
            console.log(data.success);
            showToast("Reservation successful!", "success");

            

            // Change form action
        reservationForm.action = `/reservationNumber?random=${data.success}`;
        
        // Submit the form programmatically after ensuring action is set
        setTimeout(() => {
            reservationForm.submit(); 
        }, 100); // Add a slight delay to ensure `action` is set

        // Redirect only **after** form submission is processed
        setTimeout(() => {
            window.location.href = '/takeaway/menu';
        }, 500);



            // window.location.href = '/successreservation';

        
        } catch (error) {
            console.error("Error:", error);
            showToast(error.message || "Something went wrong!",  { type: 'warning'});
            // showToast("Something went wrong!",  { type: 'info'});
        }


    });
    
});




// First, add this CSS to your stylesheet or in a <style> tag in your HTML head
const style = document.createElement('style');
style.textContent = `
 .toast-container {
  position: fixed;
  top: 75px;
  right: 20px;
  z-index: 9999;
  display: flex;
  flex-direction: column;
  gap: 12px;
  pointer-events: none;
}

.toast-notification {
  color: #ffffff;
  padding: 16px 20px;
  border-radius: 12px;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
  display: flex;
  align-items: center;
  min-width: 300px;
  max-width: 400px;
  transform: translateX(120%);
  transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
  border-left: 5px solid transparent;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
  opacity: 0;
  pointer-events: auto;
  overflow: hidden;
  position: relative;
}

.toast-notification.show {
  transform: translateX(0);
  opacity: 1;
}

.toast-notification.hide {
  transform: translateX(120%);
  opacity: 0;
}

.toast-icon {
  margin-right: 16px;
  font-size: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
}

.toast-content {
  flex: 1;
}

.toast-message {
  margin: 0;
  font-size: 0.95rem;
  font-weight: 500;
  line-height: 1.4;
}

.toast-close {
  background: none;
  border: none;
  color: rgba(255, 255, 255, 0.8);
  cursor: pointer;
  font-size: 18px;
  padding: 0 5px;
  margin-left: 16px;
  opacity: 0.8;
  transition: opacity 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 24px;
  width: 24px;
  border-radius: 50%;
}

.toast-close:hover {
  opacity: 1;
  background-color: rgba(255, 255, 255, 0.15);
}

.toast-close:focus {
  outline: none;
  box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

/* Toast types with matching background colors */
.toast-success {
  background-color: #4CAF50;
  border-left-color: #388E3C;
}

.toast-error {
  background-color: #ef5350;
  border-left-color: #d32f2f;
}

.toast-warning {
  background-color: #ff9800;
  border-left-color: #f57c00;
}

.toast-info {
  background-color: #2196F3;
  border-left-color: #1976D2;
}

/* Responsive adjustments */
@media (max-width: 576px) {
  .toast-container {
    top: auto;
    bottom: 20px;
    left: 20px;
    right: 20px;
    align-items: stretch;
  }
  
  .toast-notification {
    min-width: unset;
    max-width: unset;
    width: 100%;
  }
}

/* Accessibility improvements */
@media (prefers-reduced-motion: reduce) {
  .toast-notification {
    transition: none;
  }
}
`;
document.head.appendChild(style);

// Create toast container if it doesn't exist
function getToastContainer() {
  let container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
  }
  return container;
}

// Function to show toast notification
function showToast(message, options = {}) {
  const {
    type = 'success',
    duration = 3000,
    showClose = true
  } = options;
  
  const container = getToastContainer();
  
  // Create toast element
  const toast = document.createElement('div');
  toast.className = `toast-notification toast-${type}`;
  
  // Create icon based on type
  const icon = document.createElement('div');
  icon.className = 'toast-icon';
  let iconSymbol = '';
  
  switch(type) {
    case 'success':
      iconSymbol = '✓';
      break;
    case 'error':
      iconSymbol = '✕';
      break;
    case 'warning':
      iconSymbol = '!';
      break;
    case 'info':
      iconSymbol = 'i';
      break;
  }
  
  icon.textContent = iconSymbol;
  
  // Create content
  const content = document.createElement('div');
  content.className = 'toast-content';
  
  const messageElement = document.createElement('p');
  messageElement.className = 'toast-message';
  messageElement.textContent = message;
  
  content.appendChild(messageElement);
  
  // Add close button if needed
  let closeBtn;
  if (showClose) {
    closeBtn = document.createElement('button');
    closeBtn.className = 'toast-close';
    closeBtn.textContent = '×';
    closeBtn.addEventListener('click', () => {
      hideToast(toast);
    });
  }
  
  // Assemble toast
  toast.appendChild(icon);
  toast.appendChild(content);
  if (closeBtn) toast.appendChild(closeBtn);
  
  // Add to container
  container.appendChild(toast);
  
  // Show the toast (with a slight delay to allow the transition to work)
  setTimeout(() => {
    toast.classList.add('show');
  }, 10);
  
  // Hide and remove the toast after the specified duration
  if (duration !== 0) {
    setTimeout(() => {
      hideToast(toast);
    }, duration);
  }
  
  return toast;
}

// Function to hide toast
function hideToast(toast) {
  toast.classList.add('hide');
  toast.classList.remove('show');
  
  // Remove from DOM after animation
  setTimeout(() => {
    if (toast.parentNode) {
      toast.parentNode.removeChild(toast);
    }
  }, 400);
}

// Usage:
// showToast('Added to cart successfully!');
// OR with options:
// showToast('Added to cart successfully!', { type: 'success', duration: 5000 });
// Types: 'success', 'error', 'warning', 'info'
