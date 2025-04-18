// Initial data
const cartItems = [];
let bookedItems = []; // Allow reassignment

let userId;
let reservationId;
let branchId;
let totalPrice = 0;
let orderState; // Default value

// DOM Elements
const cartItemsContainer = document.getElementById('cartItemsContainer');
const bookedItemsContainer = document.getElementById('bookedItemsContainer');
const subtotalElement = document.getElementById('subtotal');
const allOrderTotal = document.getElementById('allOrderTotal');
const menuContainer = document.getElementById('menuContainer');
const bookbutton = document.getElementById('bookingBtn');

// Fetch user data and initialize cart
fetch('/user/data')
.then(response => response.json())
.then(userData => {
    if (userData.error) {
        console.error(userData.error);
        return;
    }
    
    userId = userData.id;

    //fetch reservation data
    fetch(`/getReservationDataOrder?userId=${userId}`)
    .then(response => response.json())
    .then(reservationData => {
        if (reservationData.error) {
            console.error(reservationData.error);
            return;
        }
        
        reservationId = reservationData[0].reservation_no;
        branchId = reservationData[0].branch_id;
        console.log('Branch ID:', branchId);
        console.log('Reservation ID:', reservationId);
        
        
    })
    .catch(error => {
        console.error('Error fetching reservation:', error);
    });

    //fetch order state data
    // Check if the order is already placed
    fetch(`/getOrderState?reservationNo=${reservationId}`)
    .then(response => {
        return response.json(); // Add "return" to pass the parsed JSON to the next .then
    })
    .then(data => {
        console.log(reservationId); 
        console.log('Order State:', data.exists);
    })
    .catch(error => {
        console.error('Error fetching reservation:', error);
    });


    //fetch bookedItem data
    fetch(`/getBookedDataOrder?userId=${userId}`)
    .then(response => response.json())
    .then(bookedData => {
        if (bookedData.error) {
            console.error(bookedData.error);
            return;
        }

        // Transform backend data to frontend structure
        bookedData.forEach(backendItem => {

            const itemPrice = parseFloat(backendItem.meal_price);
            const itemQuantity = backendItem.quantity;
            const itemTotal = itemPrice * itemQuantity;

            bookedItems.push({
                id: backendItem.meal_id,
                name: backendItem.meal_name,
                price: parseFloat(backendItem.meal_price),
                quantity: backendItem.quantity,
                description: backendItem.meal_description,
                image: backendItem.meal_photo,
                status: backendItem.status // Default status
            });

            totalPrice += itemTotal;
        });

        console.log('Booked items:', bookedItems);
        console.log("Total Price:", totalPrice);
        // Initial render
renderBookedItems();
        

    })
    .catch(error => {
        console.error('Error fetching reservation:', error);
    });

    
    // Fetch cart items after getting user ID
    fetch(`/getMealscart?userId=${userId}`)
    .then(response => response.json())
    .then(cartData => {
        if (cartData.error) {
            menuContainer.innerHTML = `<p>${cartData.error}</p>`;
            return;
        }
        
        // Transform backend data to frontend structure
        cartData.forEach(backendItem => {
            cartItems.push({
                id: backendItem.meal_id,
                name: backendItem.meal_name,
                price: parseFloat(backendItem.meal_price),
                quantity: backendItem.quantity,
                description: backendItem.meal_description,
                image: backendItem.meal_photo,
                status: 'Not Ordered' // Default status
            });
        });
        
        // Render after data transformation
        renderCartItems();
        updateSubtotal();
    })
    .catch(error => {
        console.error('Error fetching cart:', error);
        menuContainer.innerHTML = "<p>Failed to load cart. Please try again later.</p>";
    });
})
.catch(error => console.error('Error fetching user data:', error));

// Render cart items
function renderCartItems() {
    if (cartItems.length === 0) {
        cartItemsContainer.innerHTML = `
            <div class="empty-cart" style="display: flex; align-items: center; flex-direction: column; justify-content: center; height: 100%;">
                <i class="fas fa-shopping-cart"></i>
                <p>Your cart is empty</p>
                <button class="btn btn-dark" id="startShoppingBtn">Start Shopping</button>
            </div>
        `;
        return;
    }
    
    cartItemsContainer.innerHTML = '';
    
    cartItems.forEach(item => {
        const totalPrice = item.price * item.quantity;
        const cartItemElement = document.createElement('div');
        cartItemElement.className = 'cart-item';
        cartItemElement.innerHTML = `
            <div class="cart-item-image">
                <img src="${item.image}" alt="${item.name}">
            </div>
            <div class="cart-item-details">
                <div class="item-top">
                    <h3 class="item-name">${item.name}</h3>
                    <h3 class="item-price">Rs.${totalPrice.toFixed(2)}</h3>
                </div>
                <div class="item-middle">
                    <div class="unit-price">Unit Price - <span>Rs.${item.price.toFixed(2)}</span></div>
                    <div class="status status-${item.status.toLowerCase()}">${item.status}</div>
                </div>
                <div class="item-bottom">
                    <button class="delete-btn" data-id="${item.id}">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                    <div class="quantity-control">
                        <button class="quantity-btn minus" data-id="${item.id}">-</button>
                        <span class="quantity-value">${item.quantity}</span>
                        <button class="quantity-btn plus" data-id="${item.id}">+</button>
                    </div>
                </div>
            </div>
        `;
        cartItemsContainer.appendChild(cartItemElement);
    });

    addCartEventListeners(); // Ensure event listeners are re-attached
}

console.log(bookedItems);

// Event listeners for cart interactions
function addCartEventListeners() {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.removeEventListener('click', handleDelete); // Remove existing listener
        button.addEventListener('click', handleDelete); // Add new listener
    });

    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.removeEventListener('click', handleQuantityChange); // Remove existing listener
        button.addEventListener('click', handleQuantityChange); // Add new listener
    });

    document.getElementById('bookingBtn').removeEventListener('click', handleBooking); // Remove existing listener
    document.getElementById('bookingBtn').addEventListener('click', handleBooking); // Add new listener
}

// Define helper functions for event listeners
async function handleDelete(e) {
    const id = parseInt(e.currentTarget.dataset.id);
    const cartItemElement = e.currentTarget.closest('.cart-item');

    const result = await showConfirmation(
        "Delete Item", 
        "Are you sure you want to delete this item? This action cannot be undone."
      );

    if (result) {
        fetch('/removeFromCart', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 
                user_id: userId,
                meal_id: id
            })
        })
        .then(response => {
            if (!response.ok) throw new Error('Deletion failed');
            const index = cartItems.findIndex(item => item.id === id);
            if (index !== -1) {
                cartItems.splice(index, 1);
            }
            cartItemElement.remove();
            updateSubtotal();
        })
        .catch(error => console.error('Deletion error:', error));
    }
}

function handleQuantityChange(e) {
    const id = parseInt(e.currentTarget.dataset.id);
    const isPlus = e.currentTarget.classList.contains('plus');
    updateQuantity(id, isPlus ? 1 : -1);
}

async function handleBooking() {


    const result = await showConfirmation(
        "Booking Item", 
        "Are you sure you want to Book this meal/meals? This action cannot be undone."
      );


    if (cartItems.length === 0) {
        // alert('Your cart is empty! Please add items to your cart before booking.');

        showToast('Your cart is empty! Please add items to your cart before booking.', { type: 'info' });
        return;
    }

    if (!result) {
        return;
    }

    showToast('Booking in progress...', { type: 'info' });


    const orderData = {
        order_date: new Date().toISOString().split('T')[0],
        order_status: 0,
        branch_id: branchId,
        reservation_no: reservationId,
        user_id: userId,
        order_time: new Date().toTimeString().split(' ')[0],
        order_price: cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0).toFixed(2)
    };

    console.log('Order data:', orderData);



    try {

        
        // First, place the order and get order ID
        const response = await fetch('/placeOrder', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(orderData)
        });

        if (!response.ok){
            showToast('Order placement failed', { type: 'error' });
            throw new Error('Order placement failed');
        }
        const result = await response.json();
        const orderId = result.order_id; // Expect backend to return { order_id: xx }

        console.log(result);

        showToast('Order placed successfully!', { type: 'success' });
        console.log('Order placed with ID:', orderId);

        const bookedItems = cartItems.map(item => ({
            order_id: orderId,
            id: item.id,
            quantity: item.quantity,
            user_id: userId,
            status:'preparing',
        }));

        // Then, place the order meals
        const responseMeal = await fetch(`/placeOrderMeal`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(bookedItems)
        });

        if (!responseMeal.ok) throw new Error('Order meals placement failed');
        const mealResult = await responseMeal.json();
        console.log('Order meals result:', mealResult);

        // Clear cart
        cartItems.length = 0;
        renderCartItems();
        updateSubtotal();

        await fetch('/clearCart', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: userId })
        });

        console.log('Cart cleared successfully.');

    } catch (error) {
        console.error('Booking failed:', error);
    }
}

async function fetchOrderId(reservationId) {
    try {
        const response = await fetch(`/getOrderIdByReservation?reservationId=${reservationId}`);
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Server error response:', errorText);
            return null;
        }

        const data = await response.json();
        if (data.error) {
            console.error(data.error);
            showToast('No order found for this reservation.', { type: 'warning' });
            return null;
        }

        console.log('Order ID:', data.order_id);
        return data.order_id;
    } catch (error) {
        console.error('Error fetching order ID:', error);
        return null;
    }
}

document.getElementById('payNowBtn').addEventListener('click', async () => {
    if (!reservationId) {
        showToast('Reservation ID is not available. Please try again later.', { type: 'error' });
        return;
    }

    const orderId = await fetchOrderId(reservationId);

    if (!orderId) {
        showToast('No order to pay', { type: 'warning' });
        return;
    }

    // Navigate to the payments page if an order exists
    window.location.href = `/payment?reservationId=${reservationId}`;
});

// Update quantity with server sync
function updateQuantity(id, change) {
    const item = cartItems.find(item => item.id === id);
    if (!item) return;

    const newQuantity = item.quantity + change;
    if (newQuantity > 0) {
        item.quantity = newQuantity;
    } else {
        removeItem(id);
        return;
    }

    // console.log('Updating quantity:', { userId, meal_id: id, quantity: newQuantity }); // Debugging log

    fetch('/updateCartQuantity', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            user_id: userId,
            meal_id: id,
            quantity: newQuantity
        })
    })
    .then(response => {
        if (!response.ok) throw new Error('Update failed');
        return response.json(); // Parse response if needed
    })
    .then(data => {
        console.log('Server response:', data); // Debugging log
        renderCartItems();
        updateSubtotal();
    })
    .catch(error => console.error('Update error:', error));
}

// Remove item with server sync
async function removeItem(id) {

    const result = await showConfirmation(
        "Delete Item",
        "Are you sure you want to delete this item? This action cannot be undone."
        );


    if (!result) {
        showToast('Item not removed', { type: 'warning' });
        return;
    }

    fetch('/removeFromCart', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            user_id: userId, // Fixed variable name
            meal_id: id
        })
    })
    .then(response => {
        if (!response.ok) throw new Error('Removal failed');
        
        const index = cartItems.findIndex(item => item.id === id);
        if (index !== -1) {
            cartItems.splice(index, 1);
            renderCartItems();
            showToast('Item removed successfully!', { type: 'success' });
            updateSubtotal();
        }
    })
    .catch(error => console.error('Removal error:', error));
}

// Calculate subtotal
function updateSubtotal() {
    const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    allOrderTotal.textContent = `Rs.${totalPrice.toFixed(2)}`;
    subtotalElement.textContent = `Rs.${subtotal.toFixed(2)}`;
    document.getElementById('bookingBtn').textContent = `Booking (${cartItems.length})`;

}

// Clear cart
document.getElementById('clearCartBtn').addEventListener('click', async () => {

    const result = await showConfirmation(
        "Delete Item", 
        "Are you sure you want to delete this item? This action cannot be undone."
      );

    if (result) {
        fetch('/clearCart', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: userId })
        })
        .then(response => {
            if (!response.ok) throw new Error('Clear failed');
            cartItems.length = 0;
            renderCartItems();
            updateSubtotal();
            showToast('Cart cleared successfully!', { type: 'success' });
        })
        .catch(error => console.error('Clear error:', error));
    }
});



// Render booked items (keep your original function)
function renderBookedItems() {
    if (bookedItems.length === 0) {
        bookedItemsContainer.innerHTML = ` <div class="empty-cart">
                <i class="fa-solid fa-cart-flatbed-suitcase"></i>
                <p>No booked item found</p>
                <button class="btn btn-dark" id="startShoppingBtn">Start Shopping</button>
            </div>`;
        return;
    }

    bookedItemsContainer.innerHTML = '';
    bookedItems.forEach(item => {
        const bookedItemElement = document.createElement('div');
        bookedItemElement.className = 'booked-item';
        bookedItemElement.innerHTML = `
            <div class="booked-item-details notification">
                <div class="item-info">
                    <h3>${item.name}</h3>
                    <p class="item-quantity">Quantity: ${item.quantity}</p>
                </div>
            ${item.status == 'preparing' ? `<div class="meal-status status-pending">
                    ${item.status}
                </div>` : `<div class="meal-status status-ready">
                    ${item.status}
                </div>`}
                
            </div>
        `;
        bookedItemsContainer.appendChild(bookedItemElement);
    });
}






function showConfirmation(title, message) {
    return new Promise((resolve) => {
      // Create overlay
      const overlay = document.createElement('div');
      overlay.className = 'confirm-overlay';
      
      // Create dialog
      const dialog = document.createElement('div');
      dialog.className = 'confirm-dialog';
      
      // Create title
      const titleElement = document.createElement('h3');
      titleElement.className = 'confirm-title';
      titleElement.textContent = title;
      
      // Create message
      const messageElement = document.createElement('div');
      messageElement.className = 'confirm-message';
      messageElement.textContent = message;
      
      // Create buttons container
      const buttons = document.createElement('div');
      buttons.className = 'confirm-buttons';
      
      // Create Yes button
      const yesButton = document.createElement('button');
      yesButton.className = 'confirm-button yes';
      yesButton.textContent = 'Yes';
      
      // Create No button
      const noButton = document.createElement('button');
      noButton.className = 'confirm-button no';
      noButton.textContent = 'No';
      
      // Add event listeners
      yesButton.addEventListener('click', () => {
        overlay.remove();
        resolve(true);
      });
      
      noButton.addEventListener('click', () => {
        overlay.remove();
        resolve(false);
      });
      
      // Assemble elements
      buttons.appendChild(noButton);
      buttons.appendChild(yesButton);
      dialog.appendChild(titleElement);
      dialog.appendChild(messageElement);
      dialog.appendChild(buttons);
      overlay.appendChild(dialog);
      document.body.appendChild(overlay);
      
      // Trigger animation
      setTimeout(() => overlay.classList.add('show'), 10);
    });
  }




  //alert
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