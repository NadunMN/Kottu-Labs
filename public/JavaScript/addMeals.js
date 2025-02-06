document.addEventListener("DOMContentLoaded", function () {
    const branchSelect = document.getElementById("branch-select");
    const searchSelection = document.getElementById("search-selection-2");
    const menuContainer = document.querySelector(".menu-items");
    const doneButton = document.getElementById("done-button");

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

    let selectedMeals = new Set();

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
                        <div class="card-content">
                            <h2 class="card-title">${meal.meal_name}</h2>
                            <div class="card-price">Rs. ${meal.meal_price}</div>
                            <button class="view-button" data-meal-id="${meal.meal_id}">
                                ${selectedMeals.has(meal.meal_id) ? "DESELECT MEAL" : "SELECT MEAL"}
                            </button>
                        </div>
                    </div>
                `).join('');

                menuContainer.innerHTML = mealCards;

                // Add event listeners to the "Select Meal" buttons
                const selectButtons = document.querySelectorAll(".view-button");
                selectButtons.forEach(button => {
                    const mealId = button.getAttribute("data-meal-id");

                    // If the meal is already selected, update its style
                    if (selectedMeals.has(mealId)) {
                        button.textContent = "DESELECT MEAL";
                        button.style.backgroundColor = "#8B0000";
                    }

                    button.addEventListener("click", function () {
                        const mealId = this.getAttribute("data-meal-id");

                        if (selectedMeals.has(mealId)) {
                            // Deselect the meal
                            selectedMeals.delete(mealId);
                            this.textContent = "SELECT MEAL";
                            this.style.backgroundColor = ""; // Reset to original color
                        } else {
                            // Select the meal
                            selectedMeals.add(mealId);
                            this.textContent = "DESELECT MEAL";
                            this.style.backgroundColor = "#8B0000"; // Change color to red
                        }

                        const selectedMealsArray = Array.from(selectedMeals);
                        console.log(selectedMealsArray);

                        // Enable/disable the "Done" button based on whether any meal is selected
                        doneButton.disabled = selectedMeals.size === 0;
                    });
                });
            })
            .catch(error => {
                console.error('Error fetching meals:', error);
                menuContainer.innerHTML = "<p>Failed to load meals. Please try again later.</p>";
            });
    }

    // Initial load
    loadMeals(branchSelect.value, searchSelection.value);

    // Event listeners for branch and search selection changes
    branchSelect.addEventListener("change", function () {
        loadMeals(this.value, searchSelection.value);
    });

    searchSelection.addEventListener("change", function () {
        loadMeals(branchSelect.value, this.value);
    });

    doneButton.addEventListener("click", function () {
        const selectedMealsArray = Array.from(selectedMeals);
        console.log(selectedMealsArray);
    
        // Store selected meals in localStorage
        localStorage.setItem("selectedMeals", JSON.stringify(selectedMealsArray));
    
        // Go back to the previous page
        history.back();
    });
    
    

  

});