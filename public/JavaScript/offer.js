document.addEventListener("DOMContentLoaded", function () {

    const branchSelect = document.getElementById("branch-select");
    const menuContainer = document.querySelector(".menu-items");
    const searchInput = document.getElementById("search");
    const searchButton = document.querySelector(".search-button-menu");


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
                    menuContainer.innerHTML = "<p class=\"width-window\" >No Offer found</p>";
                    return;
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
                            <button class="view-button">VIEW DETAILS</button>
                            </div>
                        </div>


                        
                `).join('');

                
                menuContainer.innerHTML = offerCards;
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
