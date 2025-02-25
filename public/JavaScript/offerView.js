document.addEventListener("DOMContentLoaded", function () {
    const offerMain = document.querySelector('.product-container'); // Ensure the class is correct
    const cardSection = document.querySelector('.product-grid'); // Ensure the class is correct

    const urlParams = new URLSearchParams(window.location.search);
    const offerId = urlParams.get('id');
    console.log("Offer ID:", offerId);

    // Function to attach event listeners to dynamically inserted elements
    function attachEventListeners() {
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', () => {
                const input = document.querySelector('.quantity-number');
                let value = parseInt(input.value);
                if (button.classList.contains('plus')) {
                    value++;
                } else {
                    value = value > 1 ? value - 1 : 1;
                }
                input.value = value;
            });
        });

        // Tab Switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                const tabId = tab.dataset.tab;
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

                tab.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });
    }

    if (offerId) {
        fetch(`/get/offer?offerId=${offerId}`)
            .then(response => {
                if (!response.ok) throw new Error("Network response was not ok");
                return response.json();
            })
            .then(data => {



                if (!data) {
                    window.location.href = '/offers'; // Redirect if offer not found
                    return;
                }
                 const offer = data[0];

                const mealIds = offer[0].meal_ids.split(",");
                console.log(mealIds);

                
                // const mealIdsArray = mealIds.split(",");
                // console.log(mealIdsArray); 


                console.log("Offer Data:", offer); // Debugging: Check API response

                const offerDetail = `
                    <div class="product-gallery">
                        <img src="${offer[0].offer_photo}" class="main-image" alt="${offer[0].offer_name || "No Title"}">
                    </div>

                    <div class="product-info">
                        <h1 class="product-title">${offer[0].offer_name || "No Title"}</h1>
                        <div class="price">Rs.${offer[0].offer_price || "0.00"}</div>
                        <div class="reviews">${"★".repeat(offer.rating || 0)}${"☆".repeat(5 - (offer.rating || 0))} (${offer.reviews || 0} Reviews)</div>
                        <p class="description">${offer[0].offer_description || "No Description"}</p>

                        <div class="quantity-selector">
                            <span class="quantity-label">Quantity:</span>
                            <div class="quantity-input">
                                <button class="quantity-btn minus">-</button>
                                <input type="number" class="quantity-number" value="1" min="1">
                                <button class="quantity-btn plus">+</button>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button class="btn btn-cart" ${offer.status && offer.status.toLowerCase() === "out of stock" ? 'disabled' : ''}>
                                ${offer.status && offer.status.toLowerCase() === "out of stock" ? "OUT OF STOCK" : "ADD TO CART"}
                            </button>
                        </div>

                        <div class="product-tabs">
                            <div class="tab active" data-tab="details">Details</div>
                            <div class="tab" data-tab="features">Features</div>
                            <div class="tab" data-tab="shipping">Shipping</div>
                            <div class="tab" data-tab="care">Care Instruction</div>
                        </div>

                        <div id="details" class="tab-content active">Product details information...</div>
                        <div id="features" class="tab-content">Product features description...</div>
                        <div id="shipping" class="tab-content">Shipping information and policies...</div>
                        <div id="care" class="tab-content">Care instructions and maintenance...</div>
                    </div>
                `;

                // Insert offer details into the page
                offerMain.innerHTML = offerDetail;



                fetch("/menuitem/data")
                    .then((response) => response.json())
                    .then((data)=>{
                        console.log(data);

                        const matchingMeals = data.filter((meal) => mealIds.includes(meal.meal_id.toString()));

                        console.log("Matching Meals:", matchingMeals);

                        const mealCards = matchingMeals.map((meal) => `
                                        <div class="card">
                                            <div class="image-div">
                                                <img src="${meal.meal_photo}" alt="Product Image" class="card-image" />
                                            </div>
                                            
                                            <div class="card-content">
                                                <h2 class="card-title">${meal.meal_name}</h2>
                                                <div class="card-price">Rs. ${meal.meal_price}</div>
                                            </div>
                                        </div>
                                        `).join('');

                        cardSection.innerHTML = mealCards;
                    })
                    .catch((error) => {
                        console.error("Error fetching data:", error);
                    });
                    



                // Attach event listeners after inserting elements
                attachEventListeners();
            })
            .catch(error => {
                console.error("Error fetching offer:", error);
                window.location.href = '/offers'; // Redirect on error
            });
    } else {
        // Redirect if no ID is provided
        window.location.href = '/offers';
    }
});