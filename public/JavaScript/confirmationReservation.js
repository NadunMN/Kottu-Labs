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
            // console.log('Stored Request Body:', requestBody);
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
            // messageDiv.textContent = 'PIN verified! Storing reservation...';
            showToast("PIN verified!", { type: 'success'});

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
            
                // Check success field in response body
                if (!data.success) {
                    showToast("That time slot is currently unavailable. Kindly choose another.",  { type: 'info', duration: 5000});
                    
                    throw new Error(data.message || "Reservation failed.");
                }
            
                console.log("Success:", data);
                showToast("Reservation successful!", "success");
                window.location.href = '/successreservation';
            
            } catch (error) {
                console.error("Error:", error);
                showToast(error.message || "Something went wrong!",  { type: 'warning'});
                // showToast("Something went wrong!",  { type: 'info'});
            }


        } else {
            showToast("Invalid PIN. Please try again.", { type: 'error'});
            // messageDiv.textContent = 'Invalid PIN. Please try again.';
            
            setTimeout(() => {
                inputs.forEach(input => input.value = '');
                inputs[0].focus();
            }, 500);
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
