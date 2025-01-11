document.addEventListener("DOMContentLoaded", function () {

    const branchSelect = document.getElementById("branch-select");
    const searchSelection = document.getElementById("search-selection-2");
    const menuContainer = document.querySelector(".menu-items");

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

    function loadMeals(branchId, selectionId) {
        console.log(selectionId);
        
        menuContainer.innerHTML = "<p class=\"width-window\">Loading...</p>";

        
        fetch(`/getMealsmenu?branchId=${branchId}&selectionId=${selectionId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    menuContainer.innerHTML = `<p>${data.error}</p>`;
                    return;
                }

                if (data.length === 0) {
                    menuContainer.innerHTML = "<p class=\"width-window\" >No meals found</p>";
                    return;
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
                            <div class="card-price">Rs. ${meal.meal_price}.00</div>
                            <button class="view-button"><img src="/Photo/icon/shopping-cart.png" alt="">ADD TO CART</button>
                        </div>
                        </div>


                        
                `).join('');

                
                menuContainer.innerHTML = mealCards;
            })
            .catch(error => {
                console.error('Error fetching meals:', error);
                menuContainer.innerHTML = "<p>Failed to load meals. Please try again later.</p>";
            });
    }

    
    loadMeals(branchSelect.value, searchSelection.value);

    branchSelect.addEventListener("change", function () {
        loadMeals(this.value, searchSelection.value);
    });

    searchSelection.addEventListener("change", function () {
        loadMeals(branchSelect.value, this.value);
    });
});
