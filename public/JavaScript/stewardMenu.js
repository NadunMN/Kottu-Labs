document.addEventListener("DOMContentLoaded", async function () {
    const branchSelect = document.getElementById("branch-select");
    const searchSelection = document.getElementById("search-selection-2");
    const menuContainer = document.querySelector(".menu-items");
    const lengthMenu = document.querySelector(".how-many");
    const searchInput = document.getElementById("search");
    const searchButton = document.querySelector(".search-button-menu");
    let flag = 1;

   

    // Get the current URL's query parameters
const urlParams = new URLSearchParams(window.location.search);

// Retrieve the `id` parameter (or any other parameter)
const reservationNo = urlParams.get('reservationNo');

localStorage.setItem('reservationNo', reservationNo); // Store the reservation number in local storage




    const mealDescriptions = {
        1: "All",
        2: "Classic Kottu",
        3: "Dolphin Kottu",
        4: "Cheese Kottu",
        5: "String Hopper Kottu",
        6: "KL Special Fried Rice",
        7: "Pasta",
        8: "Appetizers",
        9: "KL Inventions",
        10: "Wraps & Rotti Sandwiches",
        11: "Parata",
        12: "Devilled Portions",
        13: "Mocktails",
        14: "Beverages"
    };

    let userId = null;
    let tempId = null;
    let branchId = null;
    
    try {
        // Fetch user data from the backend
        const userResponse = await fetch('/user/data');
        const userData = await userResponse.json();
    
        if (userData.error) {
            console.error(userData.error);
        } else {
            userId = userData.id;
            branchId = userData.branch_id;
        }
        // Fetch reservation data
        const reservationResponse = await fetch(`/reservartionData?reservationNo=${reservationNo}`);
        const reservationData = await reservationResponse.json();
    
        if (reservationData.error) {
            console.error(reservationData.error);
        } else {
            if (reservationData.reservation.tempId !== null) {
                tempId = reservationData.reservation.temp_id;
            } else {
                userId = reservationData.reservation.user_id;
            }
        }
        // Call loadMeals only after branchId is set
        if (branchId) {
          loadMeals(branchId, searchSelection.value);
        } else {
            console.error("Branch ID is not set. Unable to load meals.");
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
    
    





    function loadMeals(branchId, selectionId, searchTerm = "") {
        menuContainer.innerHTML = "<div class=\"loder-wrapper\"><div class=\"loader\"></div></div>";

        fetch(`/getMealsmenu?branchId=${branchId}&selectionId=${selectionId}&search=${searchTerm}`)
            .then(response => response.json())
            .then(data => {
                setTimeout(() => {
                    if (data.error) {
                        menuContainer.innerHTML = `<p>${data.error}</p>`;
                        return;
                    }

                    if (data.length === 0) {
                        menuContainer.innerHTML = `
                            <div class="no-offers-container" 
                                style="text-align: center; 
                                        display: flex; 
                                        flex-direction: column; 
                                        align-items: center; 
                                        justify-content: center; 
                                        padding: 2rem; 
                                        width: 100%;
                                        height: 300px;
                                        border-radius: 10px; 
                                        margin: 20px;">
                                <i class="fa-solid fa-bowl-food" 
                                style="font-size: 3rem; 
                                        color: #6c757d; 
                                        margin-bottom: 1rem;"></i>
                                <h3 style="font-size: 1.5rem; 
                                        color: #343a40; 
                                        margin-bottom: 0.5rem; 
                                        font-weight: 600;">
                                    No Meals Found!
                                </h3>
                                <p style="color: #6c757d; 
                                        font-size: 1rem; 
                                        max-width: 400px; 
                                        line-height: 1.5;">
                                    We'll notify you when new meals arrive!
                                </p>
                            </div>
                        `;
                        lengthMenu.innerHTML = "0 Meals Available";
                        return;
                    } else {
                        lengthMenu.innerHTML = data.length + " Meals Available";
                    }

                    const mealCards = data.map(meal => `
                      <div class="card">
                        <div class="image-div">
                          <img src="${meal.meal_photo}" alt="Product Image" class="card-image" />
                        </div>
                        <div class="card-label-wrapper">
                          <div class="card-label ${meal.meal_status ? '' : 'not-available'}">
                          <p>${meal.meal_status ? 'Available' : 'Not Available'}</p>
                          </div>
                          <div class="card-label-2">
                          <p>${mealDescriptions[meal.meal_description]}</p>
                          </div>
                        </div>
                        <div class="card-content">
                          <h2 class="card-title">${meal.meal_name}</h2>
                          <div class="card-price">Rs. ${meal.meal_price}</div>

                          ${flag == 1 ? `
                            <button class="view-button add-to-cart" 
                            data-meal-id="${meal.meal_id}">
                            <img src="/Photo/icon/shopping-cart.png" alt=""/>
                            ADD TO CART
                            </button>
                          ` : `
                            <button class="view-button make-reservation" 
                            style="background-color: #6c757d; cursor: pointer;">
                            <img src="/Photo/icon/shopping-cart.png" alt=""/>
                            ADD TO CART
                            </button>
                          `}
                    
                        </div>
                      </div>
                    `).join('');

                    // Add event listener for reservation button
                    menuContainer.addEventListener('click', function(event) {
                      const button = event.target.closest('.make-reservation');
                      if (button) {
                        showToast('Please make a reservation first!', { type: 'info' });
                        // Redirect to reservation page or handle reservation logic
                        // window.location.href = '/reservation';
                      }
                    });

                    menuContainer.innerHTML = mealCards;
                }, 1000);
            })
            .catch(error => {
                console.error('Error fetching meals:', error);
                menuContainer.innerHTML = "<p>Failed to load meals. Please try again later.</p>";
            });
    }

    // Event delegation for add-to-cart buttons
    menuContainer.addEventListener('click', function(event) {
        const button = event.target.closest('.add-to-cart');
        if (button) {
            if (!userId) {
                alert('Please log in to add items to your cart.');
                return;
            }
            
            const mealId = button.getAttribute('data-meal-id');

            const requestBody = JSON.stringify({ meal_id: mealId, user_id: userId, quantity: 1, temp_id: tempId });
            
            
            fetch('/cart/add/unreg', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                },
                body: requestBody,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                    fetch('/user/store', {
                      method:'POST',
                      headers: { 
                        'Content-Type': 'application/json',
                      },
                      body: JSON.stringify({ reservation_no: reservationNo, user_id: userId}),
                    })
                    .then(response => response.json())
                    .then(data => {
                      if (data.success) {
                        console.log("Reservation number stored successfully.");
                      } else {
                        console.error("Failed to store reservation number:", data.error);
                      }
                    })

                // Use this:
                showToast('Added to cart successfully!' , { type: 'success' });


                } else {
                  console.log(data.error);
                    // alert('Failed to add to cart: ' + (data.message || 'Please try again.'));
                    showToast('Failed to add to cart: ', { type: 'info' });
                }
            })
            .catch(error => {
              // console.log(data.error);
                console.error('Error:', error);
                // alert('An error occurred. Please try again.');
                showToast('An error occurred. Please try again.', { type: 'error' });

            });
        }
    });

    // Initial load
    loadMeals(branchSelect.value, searchSelection.value);

    // Event listeners
    branchSelect.addEventListener("change", function() {
        loadMeals(this.value, searchSelection.value, searchInput.value.trim());
    });

    searchSelection.addEventListener("change", function() {
        loadMeals(branchSelect.value, this.value, searchInput.value.trim());
    });

    searchButton.addEventListener("click", function() {
        loadMeals(branchSelect.value, searchSelection.value, searchInput.value.trim());
    });

    searchInput.addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            loadMeals(branchSelect.value, searchSelection.value, this.value.trim());
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