// Initial data
const cartItems = [];
const bookedItems = []; // Your original booked items array

let userId;

// DOM Elements
const cartItemsContainer = document.getElementById('cartItemsContainer');
const bookedItemsContainer = document.getElementById('bookedItemsContainer');
const subtotalElement = document.getElementById('subtotal');
const menuContainer = document.getElementById('menuContainer');

// Fetch user data and initialize cart
fetch('/user/data')
.then(response => response.json())
.then(userData => {
    if (userData.error) {
        console.error(userData.error);
        return;
    }
    
    userId = userData.id;
    
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

// Event listeners for cart interactions
function addCartEventListeners() {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            const id = parseInt(e.currentTarget.dataset.id);
            const cartItemElement = e.currentTarget.closest('.cart-item'); // Get the row element
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
                    // Remove the item from the cartItems array
                    const index = cartItems.findIndex(item => item.id === id);
                    if (index !== -1) {
                        cartItems.splice(index, 1);
                    }
                    // Remove the row from the DOM
                    cartItemElement.remove();
                    updateSubtotal(); // Update subtotal after deletion
                })
                .catch(error => console.error('Deletion error:', error));
            }
        });
    });

    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            const id = parseInt(e.currentTarget.dataset.id);
            console.log('Button clicked:', id);
            const isPlus = button.classList.contains('plus');
            updateQuantity(id, isPlus ? 1 : -1);
        });
    });
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
            userId,
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

// Initial render
renderBookedItems();

// Render booked items (keep your original function)
function renderBookedItems() {
    // Your existing booked items rendering logic
}