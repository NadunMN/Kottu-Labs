     // Initial data
     const cartItems = [
        {
            id: 1,
            name: 'Special Cheese kottu',
            unitPrice: 850,
            quantity: 2,
            status: 'complete',
            image: '/api/placeholder/100/100'
        },
        {
            id: 2,
            name: 'Chocolate Milkshake',
            unitPrice: 500,
            quantity: 1,
            status: 'complete',
            image: '/api/placeholder/100/100'
        },
        {
            id: 3,
            name: 'Seafood kottu',
            unitPrice: 700,
            quantity: 1,
            status: 'preparing',
            image: '/api/placeholder/100/100'
        },
        {
            id: 4,
            name: 'Chicken kottu',
            unitPrice: 600,
            quantity: 1,
            status: 'preparing',
            image: '/api/placeholder/100/100'
        }
    ];

    const bookedItems = [
        {
            id: 1,
            name: 'Special Cheese kottu',
            price: 850,
            image: '/api/placeholder/60/60'
        },
        {
            id: 2,
            name: 'Special Cheese kottu',
            price: 850,
            image: '/api/placeholder/60/60'
        },
        {
            id: 3,
            name: 'Special Cheese kottu',
            price: 850,
            image: '/api/placeholder/60/60'
        }
    ];

    // DOM Elements
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    const bookedItemsContainer = document.getElementById('bookedItemsContainer');
    const subtotalElement = document.getElementById('subtotal');
    const bookingBtn = document.getElementById('bookingBtn');
    const clearCartBtn = document.getElementById('clearCartBtn');
    const addItemBtn = document.getElementById('addItemBtn');
    const payNowBtn = document.getElementById('payNowBtn');

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
            const totalPrice = item.unitPrice * item.quantity;
            const cartItemElement = document.createElement('div');
            cartItemElement.className = 'cart-item';
            cartItemElement.innerHTML = `
                <div class="cart-item-image">
                    <img src="/Photo/Menu/cheese_kottu.jpg" alt="${item.name}">
                </div>
                <div class="cart-item-details">
                    <div class="item-top">
                        <h3 class="item-name">${item.name}</h3>
                        <h3 class="item-price">Rs.${totalPrice.toFixed(2)}</h3>
                    </div>
                    <div class="item-middle">
                        <div class="unit-price">Unit Price - <span>Rs.${item.unitPrice.toFixed(2)}</span></div>
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

        // Add event listeners for delete buttons
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const id = parseInt(e.currentTarget.getAttribute('data-id'));
                removeItem(id);
            });
        });

        // Add event listeners for quantity buttons
        document.querySelectorAll('.quantity-btn.plus').forEach(button => {
            button.addEventListener('click', (e) => {
                const id = parseInt(e.currentTarget.getAttribute('data-id'));
                updateQuantity(id, 1);
            });
        });

        document.querySelectorAll('.quantity-btn.minus').forEach(button => {
            button.addEventListener('click', (e) => {
                const id = parseInt(e.currentTarget.getAttribute('data-id'));
                updateQuantity(id, -1);
            });
        });
    }

    // Render booked items
    function renderBookedItems() {
        bookedItemsContainer.innerHTML = '';
        
        bookedItems.forEach(item => {
            const bookedItemElement = document.createElement('div');
            bookedItemElement.className = 'booked-item';
            bookedItemElement.innerHTML = `
                <div class="booked-img">
                    <img src="/Photo/Menu/pasta-Sea food.jpg" alt="${item.name}">
                </div>
                <div class="booked-info">
                    <div class="booked-name">${item.name}</div>
                    <div class="booked-price">Rs.${item.price.toFixed(2)}</div>
                </div>
                <button class="view-btn">View</button>
            `;
            bookedItemsContainer.appendChild(bookedItemElement);
        });
    }

    // Calculate and update subtotal
    function updateSubtotal() {
        const subtotal = cartItems.reduce((sum, item) => {
            return sum + (item.unitPrice * item.quantity);
        }, 0);
        
        subtotalElement.textContent = `Rs.${subtotal.toFixed(2)}`;
        bookingBtn.textContent = `Booking(${cartItems.length})`;
    }

    // Remove item from cart
    function removeItem(id) {
        const index = cartItems.findIndex(item => item.id === id);
        if (index !== -1) {
            cartItems.splice(index, 1);
            renderCartItems();
            updateSubtotal();
        }
    }

    // Update item quantity
    function updateQuantity(id, change) {
        const item = cartItems.find(item => item.id === id);
        if (item) {
            const newQuantity = item.quantity + change;
            if (newQuantity > 0) {
                item.quantity = newQuantity;
                renderCartItems();
                updateSubtotal();
            } else if (newQuantity === 0) {
                removeItem(id);
            }
        }
    }

    // Clear cart
    clearCartBtn.addEventListener('click', () => {
        if (confirm('Are you sure you want to clear your cart?')) {
            cartItems.length = 0;
            renderCartItems();
            updateSubtotal();
        }
    });

    // Add item (dummy function for demo)
    addItemBtn.addEventListener('click', () => {
        const newItem = {
            id: cartItems.length > 0 ? Math.max(...cartItems.map(item => item.id)) + 1 : 1,
            name: 'New Item',
            unitPrice: 500,
            quantity: 1,
            status: 'preparing',
            image: '/api/placeholder/100/100'
        };
        
        cartItems.push(newItem);
        renderCartItems();
        updateSubtotal();
    });

    // Pay now button action
    payNowBtn.addEventListener('click', () => {
        alert('Proceeding to payment...');
    });

    // Initialize
    renderCartItems();
    renderBookedItems();
    updateSubtotal();

    // Add event listener for start shopping button if cart is empty
    document.addEventListener('click', (e) => {
        if (e.target.id === 'startShoppingBtn') {
            alert('Redirecting to menu...');
        }
    });