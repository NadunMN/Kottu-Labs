document.addEventListener("DOMContentLoaded", function () {
    const offerMain = document.querySelector('.product-container'); // Ensure the class is correct
    const cardSection = document.querySelector('.product-grid'); // Ensure the class is correct

    const urlParams = new URLSearchParams(window.location.search);
    const offerId = urlParams.get('id');
    console.log("Offer ID:", offerId);
    let userId= null;

    fetch('/user/data')
       .then(response => response.json())
       .then(data => {
              console.log("User Data:", data);
              if (data && data.id) {
                userId = data.id; // Set userId if available
              } else {
                console.error("User ID not found in response");
              }
       })
         .catch(error => {
                console.error("Error fetching user data:", error);
         })


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
                        <div class="reviews">★★★★★★</div>
                        <p class="description">${offer[0].offer_description || "No Description"}</p>

                        

                        <div class="action-buttons">
                            <button id="dinein" class="btn btn-cart dinein" ${offer.status && offer.status.toLowerCase() === "out of stock" ? 'disabled' : ''}>
                                ${offer.status && offer.status.toLowerCase() === "out of stock" ? "OUT OF STOCK" : "ADD TO DINEIN"}
                            </button>

                            <button class="btn btn-cart takeaway" ${offer.status && offer.status.toLowerCase() === "out of stock" ? 'disabled' : ''}>
                                ${offer.status && offer.status.toLowerCase() === "out of stock" ? "OUT OF STOCK" : "ADD TO TAKEAWAY"}
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
                `;                // Insert offer details into the page
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

                
                // Add event listener for the Dine-In button
                let dineinBtn = document.getElementById('dinein');
                    dineinBtn.addEventListener('click', () => {
                        // Create the data to send to the server
                        const dineinData = {
                            user_id: userId, // Use the userId from the fetched data
                            offer_id: offerId, // Use the offerId from the URL
                            quantity: 1
                        };
                        console.log("Dine-In Data:", dineinData); // Debugging: Check data being sent

                        // Send the data to the server
                        fetch('/cart/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(dineinData),
                        })
                            .then((response) => {
                                if (!response.ok) {
                                    throw new Error('Failed to add to Dine-In cart');
                                }
                                return response.json();
                            })
                            .then((data) => {
                                console.log('Added to Dine-In cart:', data);
                                alert('Item added to Dine-In cart successfully!');
                            })
                            .catch((error) => {
                                console.error('Error adding to Dine-In cart:', error);
                                alert('Failed to add item to Dine-In cart.');
                            });
                    });
                







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