document.addEventListener("DOMContentLoaded", function () {
    const offerMain = document.querySelector('.product-container'); // Ensure the class is correct
    const cardSection = document.querySelector('.product-grid'); // Ensure the class is correct

    const urlParams = new URLSearchParams(window.location.search);
    const offerId = urlParams.get('id');
    console.log("Offer ID:", offerId);
    let userId= null;

    fetch('/user/data')
       .then(response => response.json())
       .then(data => {
              console.log("User Data:", data);
              if (data && data.id) {
                userId = data.id; // Set userId if available
              } else {
                console.error("User ID not found in response");
              }
       })
         .catch(error => {
                console.error("Error fetching user data:", error);
         })


    // Function to attach event listeners to dynamically inserted elements
    function attachEventListeners() {
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', () => {
                const input = document.querySelector('.quantity-number');
                let value = parseInt(input.value);
                if (button.classList.contains('plus')) {
                    value++;
                } else {
                    value = value > 1 ? value - 1 : 1;
                }
                input.value = value;
            });
        });

        // Tab Switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                const tabId = tab.dataset.tab;
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

                tab.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });
    }

    if (offerId) {
        fetch(`/get/offer?offerId=${offerId}`)
            .then(response => {
                if (!response.ok) throw new Error("Network response was not ok");
                return response.json();
            })
            .then(data => {



                if (!data) {
                    window.location.href = '/offers'; // Redirect if offer not found
                    return;
                }
                 const offer = data[0];

                const mealIds = offer[0].meal_ids.split(",");
                console.log(mealIds);

                
                // const mealIdsArray = mealIds.split(",");
                // console.log(mealIdsArray); 


                console.log("Offer Data:", offer); // Debugging: Check API response

                const offerDetail = `
                    <div class="product-gallery">
                        <img src="${offer[0].offer_photo}" class="main-image" alt="${offer[0].offer_name || "No Title"}">
                    </div>

                    <div class="product-info">
                        <h1 class="product-title">${offer[0].offer_name || "No Title"}</h1>
                        <div class="price">Rs.${offer[0].offer_price || "0.00"}</div>
                        <div class="reviews">★★★★★★</div>
                        <p class="description">${offer[0].offer_description || "No Description"}</p>

                        

                        <div class="action-buttons">
                            <button id="dinein" class="btn btn-cart dinein" ${offer.status && offer.status.toLowerCase() === "out of stock" ? 'disabled' : ''}>
                                ${offer.status && offer.status.toLowerCase() === "out of stock" ? "OUT OF STOCK" : "ADD TO DINEIN"}
                            </button>

                            <button id="takaway" class="btn btn-cart takeaway" ${offer.status && offer.status.toLowerCase() === "out of stock" ? 'disabled' : ''}>
                                ${offer.status && offer.status.toLowerCase() === "out of stock" ? "OUT OF STOCK" : "ADD TO TAKEAWAY"}
                            </button>
                        </div>

                        <div class="product-tabs">
                            <div class="tab active" data-tab="details">Details</div>
                            <div class="tab" data-tab="features">Features</div>
                            <div class="tab" data-tab="shipping">Shipping</div>
                            <div class="tab" data-tab="care">Care Instruction</div>
                        </div>

                        <div id="details" class="tab-content active">Product details information...</div>
                        <div id="features" class="tab-content">Product features description...</div>
                        <div id="shipping" class="tab-content">Shipping information and policies...</div>
                        <div id="care" class="tab-content">Care instructions and maintenance...</div>
                    </div>
                `;                // Insert offer details into the page
                offerMain.innerHTML = offerDetail;



                fetch("/menuitem/data")
                    .then((response) => response.json())
                    .then((data)=>{
                        console.log(data);

                        const matchingMeals = data.filter((meal) => mealIds.includes(meal.meal_id.toString()));

                        console.log("Matching Meals:", matchingMeals);

                        const mealCards = matchingMeals.map((meal) => `
                                        <div class="card">
                                            <div class="image-div">
                                                <img src="${meal.meal_photo}" alt="Product Image" class="card-image" />
                                            </div>
                                            
                                            <div class="card-content">
                                                <h2 class="card-title">${meal.meal_name}</h2>
                                                <div class="card-price">Rs. ${meal.meal_price}</div>
                                            </div>
                                        </div>
                                        `).join('');

                        cardSection.innerHTML = mealCards;
                    })
                    .catch((error) => {
                        console.error("Error fetching data:", error);
                    });
                    



                // Attach event listeners after inserting elements
                attachEventListeners();

                
                // Add event listener for the Dine-In button
                let dineinBtn = document.getElementById('dinein');
                    dineinBtn.addEventListener('click', () => {
                        // Create the data to send to the server
                        const dineinData = {
                            user_id: userId, // Use the userId from the fetched data
                            offer_id: offerId, // Use the offerId from the URL
                            quantity: 1
                        };
                        console.log("Dine-In Data:", dineinData); // Debugging: Check data being sent

                        // Send the data to the server
                        fetch('/cart/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(dineinData),
                        })
                            .then((response) => {
                                if (!response.ok) {
                                    showToast('Failed to add to Dine-In cart.', { type: 'error', duration: 3000 });
                                    throw new Error('Failed to add to Dine-In cart');
                                }
                                return response.json();
                            })
                            .then((data) => {
                                console.log('Added to Dine-In cart:', data);
                                // alert('Item added to Dine-In cart successfully!');
                                showToast('Item added to Dine-In cart successfully!', { type: 'success', duration: 3000 });
                            })
                            .catch((error) => {
                                console.error('Error adding to Dine-In cart:', error);
                                // alert('Failed to add item to Dine-In cart.');
                                showToast('Failed to add item to Dine-In cart.', { type: 'error', duration: 3000 });
                            });
                    });
                

                // Add event listener for the Dine-In button
                let takeawayBtn = document.getElementById('takaway');
                    takeawayBtn.addEventListener('click', () => {
                        // Create the data to send to the server
                        const takeawayData = {
                            user_id: userId, // Use the userId from the fetched data
                            offer_id: offerId, // Use the offerId from the URL
                            quantity: 1
                        };
                        console.log("Takeaway Data:", takeawayData); // Debugging: Check data being sent

                        // Send the data to the server
                        fetch('/takeawaycart/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(takeawayData),
                        })
                            .then((response) => {
                                if (!response.ok) {
                                    throw new Error('Failed to add to Takeaway cart');
                                }
                                return response.json();
                            })
                            .then((data) => {
                                console.log('Added to Take away cart:', data);
                                // alert('Item added to Takeaway cart successfully!');
                                showToast('Item added to Takeaway cart successfully!', { type: 'success', duration: 3000 });
                            })
                            .catch((error) => {
                                console.error('Error adding to Takeaway cart:', error);
                                // alert('Failed to add item to Dine-In cart.');
                                showToast('Failed to add item to Takeaway cart.', { type: 'error', duration: 3000 });
                            });
                    });
                







            })
            .catch(error => {
                console.error("Error fetching offer:", error);
                window.location.href = '/offers'; // Redirect on error
            });
    } else {
        // Redirect if no ID is provided
        window.location.href = '/offers';
    }
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