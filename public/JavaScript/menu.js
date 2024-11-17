document.addEventListener('DOMContentLoaded', () => {
    const menuItems = [
        { name: "Chicken Pasta", price: 1000, category: "Pasta" },
        { name: "Sea Food Pasta", price: 1200, category: "Pasta" },
        { name: "Fish Pasta", price: 800, category: "Pasta" },
        { name: "Beef Pasta", price: 1000, category: "Pasta" },
        { name: "Prawns Pasta", price: 200, category: "Pasta" },
        { name: "Mutton Pasta", price: 400, category: "Pasta" },
        { name: "Mushroom Pasta", price: 250, category: "Pasta" },
        { name: "Chicken Dolphin Kottu", price: 350, category: "Dolphin Kottu" },
        { name: "Sea Food Dolphin Kottu", price: 350, category: "Dolphin Kottu" },
        { name: "Fish Dolphin Kottu", price: 350, category: "Dolphin Kottu" },
        { name: "Beef Dolphin Kottu", price: 350, category: "Dolphin Kottu" },
        { name: "Prawns Dolphin Kottu", price: 350, category: "Dolphin Kottu" },
        { name: "Mutton Dolphin Kottu", price: 350, category: "Dolphin Kottu" },
        { name: "Mushroom Dolphin Kottu", price: 350, category: "Dolphin Kottu" },
        { name: "Egg Dolphin Kottu", price: 350, category: "Dolphin Kottu" },
        { name: "Baby Corn Fries", price: 350, category: "Appetizers" },
        { name: "Cheesy Mash Potatoes", price: 350, category: "Appetizers" },
        { name: "Cheese Omelette", price: 350, category: "Appetizers" },
        { name: "Lankan Omelette", price: 350, category: "Appetizers" },
        { name: "Cheesy Chicken Masala", price: 350, category: "KL Inventions" },
        { name: "String Hopper Kiri Malu", price: 350, category: "KL Inventions" },
        { name: "Egg Rotti Dolphin-Chicken", price: 350, category: "KL Inventions" },
        { name: "Low Carb Sea Food", price: 350, category: "KL Inventions" },
        { name: "Pasta Prawns", price: 350, category: "KL Inventions" },
        { name: "Chicken Wrap", price: 350, category: "Wraps & Rotti Sandwiches" },
        { name: "Egg Wrap", price: 350, category: "Wraps & Rotti Sandwiches" },
        { name: "Beef Wrap", price: 350, category: "Wraps & Rotti Sandwiches" },
        { name: "Chicken Ham and Cheese", price: 350, category: "Wraps & Rotti Sandwiches" },
        { name: "Chocolate Rotti", price: 350, category: "Wraps & Rotti Sandwiches" },
        { name: "Kadala Curry Parata", price: 350, category: "Parata" },
        { name: "Chicken Curry Parata", price: 350, category: "Parata" },
        { name: "Beef Curry Parata", price: 350, category: "Parata" },
        { name: "Mutton Curry Parata", price: 350, category: "Parata" },
        { name: "Garlic Parata", price: 350, category: "Parata" },
        { name: "Chicken", price: 350, category: "Devilled Portions" },
        { name: "Beef", price: 350, category: "Devilled Portions" },
        { name: "Sea Food", price: 350, category: "Devilled Portions" },
        { name: "Fish", price: 350, category: "Devilled Portions" },
        { name: "Mutton", price: 350, category: "Devilled Portions" },
        { name: "Chicken Fried Rice", price: 350, category: "KL Special Fried Rice" },
        { name: "Beef Fried Rice", price: 350, category: "KL Special Fried Rice" },
        { name: "Sea Food Fried Rice", price: 350, category: "KL Special Fried Rice" },
        { name: "Fish Fried Rice", price: 350, category: "KL Special Fried Rice" },
        { name: "Mutton Fried Rice", price: 350, category: "KL Special Fried Rice" },
        { name: "Tropical Bull", price: 350, category: "Mocktails" },
        { name: "Meloncita", price: 350, category: "Mocktails" },
        { name: "Redbull Mojito", price: 350, category: "Mocktails" },
        { name: "Breeze", price: 350, category: "Mocktails" },
        { name: "Iced Milo", price: 350, category: "Beverages" },
        { name: "Red Bull", price: 350, category: "Beverages" },
        { name: "Red Bull Red", price: 350, category: "Beverages" },
        { name: "Coca Cola", price: 350, category: "Beverages" },
        { name: "Sprite", price: 350, category: "Beverages" },
        { name: "Lion Ginger Beer", price: 350, category: "Beverages" },
        { name: "Water", price: 350, category: "Beverages" },
        { name: "Chicken", price: 350, category: "Classic Kottu" },
        { name: "Sea Food", price: 350, category: "Classic Kottu" },
        { name: "Fish", price: 350, category: "Classic Kottu" },
        { name: "Beef", price: 350, category: "Classic Kottu" },
        { name: "Prawns", price: 350, category: "Classic Kottu" },
        { name: "Mutton", price: 350, category: "Classic Kottu" },
        { name: "Mushroom", price: 350, category: "Classic Kottu" },
        { name: "Egg", price: 350, category: "Classic Kottu" },
        { name: "Chicken", price: 350, category: "Cheese Kottu" },
        { name: "Sea Food", price: 350, category: "Cheese Kottu" },
        { name: "Fish", price: 350, category: "Cheese Kottu" },
        { name: "Beef", price: 350, category: "Cheese Kottu" },
        { name: "Prawns", price: 350, category: "Cheese Kottu" },
        { name: "Mutton", price: 350, category: "Cheese Kottu" },
        { name: "Mushroom", price: 350, category: "Cheese Kottu" },
        { name: "Egg", price: 350, category: "Cheese Kottu" },
        { name: "Chicken", price: 350, category: "String Hopper Kottu" },
        { name: "Sea Food", price: 350, category: "String Hopper Kottu" },
        { name: "Fish", price: 350, category: "String Hopper Kottu" },
        { name: "Beef", price: 350, category: "String Hopper Kottu" },
        { name: "Prawns", price: 350, category: "String Hopper Kottu" },
        { name: "Mutton", price: 350, category: "String Hopper Kottu" },
        { name: "Mushroom", price: 350, category: "String Hopper Kottu" },
        { name: "Egg", price: 350, category: "String Hopper Kottu" }
        
    ];

    const cartContainer = document.querySelector('#cart-items');
    const cartTotalElement = document.querySelector('.cart-total');
    const sidebar = document.querySelector('#sidebar');
    const menuIcon = document.querySelector('#menu-icon');
    const closeIcon = document.querySelector('#close-icon');
    const tabs = document.querySelectorAll('.tab');
    const menuContainer = document.querySelector('.menu-items');
    const searchInput = document.querySelector('#search');

    let currentCategory = "kottu";

    function updateCart() {
        let cartTotal = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            const price = parseFloat(item.querySelector('.cart-item-price').textContent.replace('Rs ', ''));
            const quantityInput = item.querySelector('.cart-item-quantity input');
            const quantity = parseInt(quantityInput.value, 10);
            cartTotal += price * quantity;
        });
        cartTotalElement.textContent = `Rs ${cartTotal.toFixed(2)}`;
    }

    function handleCartItemControls(item) {
        const increaseBtn = item.querySelector('.increase-quantity');
        const decreaseBtn = item.querySelector('.decrease-quantity');
        const deleteBtn = item.querySelector('.cart-item-delete');
        const quantityInput = item.querySelector('.cart-item-quantity input');

        increaseBtn.addEventListener('click', () => {
            let currentQuantity = parseInt(quantityInput.value, 10);
            quantityInput.value = currentQuantity + 1;
            updateCart();
        });

        decreaseBtn.addEventListener('click', () => {
            let currentQuantity = parseInt(quantityInput.value, 10);
            if (currentQuantity > 1) {
                quantityInput.value = currentQuantity - 1;
            } else {
                item.remove(); // Remove item from cart if quantity is 1 and decrease is clicked
            }
            updateCart();
        });

        deleteBtn.addEventListener('click', () => {
            item.remove();
            updateCart();
        });
    }

    function displayMenuItems(items) {
        menuContainer.innerHTML = "";
        items.forEach(item => {
            const menuItem = document.createElement('div');
            menuItem.className = 'menu-item';
            menuItem.innerHTML = `
                <h2>${item.name}</h2>
                <p>Rs ${item.price.toFixed(2)}</p>
                <button onclick="addToCart('${item.name}', ${item.price})">Add to Cart</button>
            `;
            menuContainer.appendChild(menuItem);
        });
    }

    function filterMenuItems(category) {
        const filteredItems = menuItems.filter(item => item.category === category);
        displayMenuItems(filteredItems);
    }

    function searchMenuItems(query) {
        const lowerCaseQuery = query.toLowerCase();
        const filteredItems = menuItems
            .filter(item => item.category === currentCategory)
            .filter(item => item.name.toLowerCase().includes(lowerCaseQuery));
        displayMenuItems(filteredItems);
    }

    window.addToCart = function(name, price) {
        const existingItem = Array.from(cartContainer.children).find(item => item.querySelector('.cart-item-name').textContent === name);
        if (existingItem) {
            const quantityInput = existingItem.querySelector('.cart-item-quantity input');
            quantityInput.value = parseInt(quantityInput.value, 10) + 1;
        } else {
            const item = document.createElement('div');
            item.className = 'cart-item';
            item.innerHTML = `
                <span class="cart-item-name">${name}</span>
                <div class="cart-item-quantity">
                    <button class="decrease-quantity">-</button>
                    <input type="text" value="1" readonly />
                    <button class="increase-quantity">+</button>
                </div>
                <span class="cart-item-price">Rs ${price.toFixed(2)}</span>
                <button class="cart-item-delete">Delete</button>
            `;
            cartContainer.appendChild(item);
            handleCartItemControls(item); // Attach controls to the new item
        }
        updateCart();
    }

    // Set default category
    filterMenuItems(currentCategory);

    tabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            tabs.forEach(t => t.classList.remove('active'));
            e.target.classList.add('active');
            currentCategory = e.target.dataset.category;
            filterMenuItems(currentCategory);
            searchInput.value = ''; // Clear search input when category changes
            searchMenuItems('');
        });
    });

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value;
        searchMenuItems(query);
    });

    menuIcon.addEventListener('click', () => {
        sidebar.classList.add('open');
    });

    closeIcon.addEventListener('click', () => {
        sidebar.classList.remove('open');
    });
});