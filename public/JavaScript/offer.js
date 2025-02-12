document.addEventListener("DOMContentLoaded", function () {

    const branchSelect = document.getElementById("branch-select");
    const menuContainer = document.querySelector(".menu-items");


    function loadMeals(branchId) {
        
        menuContainer.innerHTML = "<p class=\"width-window\">Loading...</p>";

        
        fetch(`/getofferlist?branchId=${branchId}`)
            .then(response => response.json())
            .then(data => {
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
            })
            .catch(error => {
                console.error('Error fetching meals:', error);
                menuContainer.innerHTML = "<p>Failed to load offer. Please try again later.</p>";
            });
    }

    
    loadMeals(branchSelect.value);

    branchSelect.addEventListener("change", function () {
        loadMeals(this.value);
    });

});
