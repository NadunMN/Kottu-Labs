document.addEventListener("DOMContentLoaded", function () {

    const branchSelect = document.getElementById("branch-select");
    const menuContainer = document.querySelector(".menu-items");


    function loadMeals(branchId) {
        
        menuContainer.innerHTML = "<p>Loading...</p>";

        
        fetch(`/getMealsmenu?branchId=${branchId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    menuContainer.innerHTML = `<p>${data.error}</p>`;
                    return;
                }

                
                const mealCards = data.map(meal => `
                    <div class="card">
                        <div class="card-lable ${meal.meal_status? '' : 'not-available'}">
                            <p>${meal.meal_status ? 'AVAILABLE' : 'NOT AVAILABLE'}</p>
                        </div>
                        <img src="${meal.meal_photo}" alt="Meal Image" class="card-image">
                        <div class="card-content">
                            <h2 class="card-title">${meal.meal_name}</h2>
                            <div class="card-price">Rs. ${meal.meal_price}/=</div>
                            <button class="view-button">ADD TO CART</button>
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

    
    loadMeals(branchSelect.value);

    branchSelect.addEventListener("change", function () {
        loadMeals(this.value);
    });
});
