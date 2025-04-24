fetch(`/user/data`)
    .then((response) => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then((data) => {
        const dineInButton = document.querySelector('.dinein');
        const takeAwayButton = document.querySelector('.takeaway');

        console.log(data); // Log the data to see its structure

        userId = data.id; // Assuming userId is in the data object
        console.log(userId); // Log the userId to see its value

        if (userId === null || userId === undefined) {
            // Disable the button if data is not available
            // dineInButton.disabled = true;

            // takeAwayButton.disabled = true;

            dineInButton.addEventListener('click', function() {
                showToast("Reserve your seat at the feast — log in now", { type: 'info' });
                window.location.href = '/dinein';
            });
            takeAwayButton.addEventListener('click', function() {
                showToast("Reserve your seat at the feast — log in now", { type: 'info' });
                // Optionally, you can also set the onclick for the takeAwayButton
                window.location.href='/selectBranch';
         
            });
           


        } else {
            // Enable the button if data is available
            dineInButton.disabled = false;
            dineInButton.style.pointerEvents = 'auto'; // Enable navigation
            dineInButton.style.opacity = '1'; // Reset visual cue
            dineInButton.onclick = () => {
                window.location.href = '/dinein';
            };


            // Optionally, you can also set the onclick for the takeAwayButton
            takeAwayButton.onclick = () => {
               window.location.href='/selectBranch';
            };
        }
    })
    .catch((error) => {
        console.error("Error fetching user data:", error);

        // Optionally disable the button in case of an error
        const dineInButton = document.querySelector('.button');
        dineInButton.disabled = true;
        dineInButton.style.pointerEvents = 'none';
        dineInButton.style.opacity = '0.5';
    });



    
// First, add this CSS to your stylesheet or in a <style> tag in your HTML head
const style = document.createElement('style');
style.textContent = `
 .toast-container {
  position: fixed;
  top: 20px;
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