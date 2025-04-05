document.addEventListener("DOMContentLoaded", function () {
    const branchSelect = document.getElementById("branch-select");
    const searchSelection = document.getElementById("search-selection-2");
    const menuContainer = document.querySelector(".menu-items");
    const lengthMenu = document.querySelector(".how-many");
    const searchInput = document.getElementById("search");
    const searchButton = document.querySelector(".search-button-menu");

    let userId = null;

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

    // Fetch user data from the backend
    fetch('/user/data')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
            } else {
                userId = data.id;
            }
        })
        .catch(error => console.error('Error fetching user data:', error));

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
                                <button class="view-button add-to-cart" 
                                    data-meal-id="${meal.meal_id}">
                                    <img src="/Photo/icon/shopping-cart.png" alt="">
                                    ADD TO CART
                                </button>
                            </div>
                        </div>
                    `).join('');

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

            const requestBody = JSON.stringify({ meal_id: mealId, user_id: userId, quantity: 1 });
            console.log("Request Body:", requestBody);
            
            fetch('/cart/add', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                },
                body: requestBody,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Added to cart successfully!');
                } else {
                    alert('Failed to add to cart: ' + (data.message || 'Please try again.'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
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