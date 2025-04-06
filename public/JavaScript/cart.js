// Initial data
const cartItems = [];
let bookedItems = []; // Allow reassignment

let userId;
let reservationId;
let branchId;
let totalPrice = 0;

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
            <div class="empty-cart">
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
function handleDelete(e) {
    const id = parseInt(e.currentTarget.dataset.id);
    const cartItemElement = e.currentTarget.closest('.cart-item');
    if (confirm('Are you sure you want to delete this item?')) {
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
    if (cartItems.length === 0) {
        alert('Your cart is empty! Please add items to your cart before booking.');
        return;
    }

    if (!confirm('Are you sure you want to place this order?')) {
        return;
    }


    const orderData = {
        order_date: new Date().toISOString().split('T')[0],
        order_status: 0,
        branch_id: branchId,
        reservation_no: reservationId,
        user_id: userId,
        order_time: new Date().toTimeString().split(' ')[0],
        order_price: cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0).toFixed(2)
    };

    console.log('Order data:', orderData); // Debugging log



    try {
        // First, place the order and get order ID
        const response = await fetch('/placeOrder', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(orderData)
        });

        if (!response.ok) throw new Error('Order placement failed');
        const result = await response.json();
        const orderId = result.order_id; // Expect backend to return { order_id: xx }

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
function removeItem(id) {
    if (!confirm('Are you sure you want to remove this item?')) return;

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
document.getElementById('clearCartBtn').addEventListener('click', () => {
    if (confirm('Are you sure you want to clear your cart?')) {
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