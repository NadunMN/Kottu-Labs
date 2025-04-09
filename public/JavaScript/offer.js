document.addEventListener("DOMContentLoaded", function () {

    const branchSelect = document.getElementById("branch-select");
    const menuContainer = document.querySelector(".menu-items");
    const searchInput = document.getElementById("search");
    const searchButton = document.querySelector(".search-button-menu");
    const lengthMenu = document.querySelector(".how-many");



    function loadMeals(branchId, searchTerm = "") {
        
        menuContainer.innerHTML = "<div class = \"loder-wrapper\"><div class=\"loader\"></div></div>";

        
        fetch(`/getofferlist?branchId=${branchId}&search=${searchTerm}`)
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
                                    No Offers Found!
                                </h3>
    
                                <p style="color: #6c757d; 
                                        font-size: 1rem; 
                                        max-width: 400px; 
                                        line-height: 1.5;">
                                    We'll notify you when new offers arrive!
                                </p>
                            </div>
                        `;
                        lengthMenu.innerHTML = "0 Meals Available";

                    return;
                } else {
                    lengthMenu.innerHTML = data.length + " Offers Available";
                    // console.log(data);
                }


                
                const offerCards = data.map(offer => `

                    
                        <div class="card">
                            <div class="card-lable">
                            <p>${offer.offer_status ? 'Available' : 'Not Available'}</p>
                            </div>
                            <img src="${offer.offer_photo}" alt="Product Image" class="card-image">
                            <div class="card-content">
                            <h2 class="card-title">${offer.offer_name}</h2>
                            <div class="card-price">Rs. ${offer.offer_price}</div>
                            <p class="card-description">
                                ${offer.offer_description}
                            </p>
                            <button class="view-button" offer-id="${offer.offer_id}">VIEW DETAILS</button>
                            </div>
                        </div>


                        
                `).join('');

                
                menuContainer.innerHTML = offerCards;

                menuContainer.addEventListener('click', function(e) {
            const button = e.target.closest('.view-button');
            if (button) {
                const offerId = button.getAttribute('offer-id');
                if (offerId) {
                    window.location.href = `/offer/offerview?id=${encodeURIComponent(offerId)}`;
                }
            }
        });
                
                },1000);
            })
            .catch(error => {
                console.error('Error fetching meals:', error);
                menuContainer.innerHTML = "<p>Failed to load offer. Please try again later.</p>";
            });
    }

    
    loadMeals(branchSelect.value);

    branchSelect.addEventListener("change", function () {
        loadMeals(this.value, searchInput.value.trim());
    });

    // Event listener for search button click
    searchButton.addEventListener("click", function () {
        const searchTerm = searchInput.value.trim();
        console.log(searchTerm);
        loadMeals(branchSelect.value, searchTerm);
    });

    // Event listener for Enter key in search input
    searchInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            const searchTerm = searchInput.value.trim();
            loadMeals(branchSelect.value, searchTerm);
        }
    });

});
