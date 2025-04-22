document.addEventListener("DOMContentLoaded", function () {
    const staffContainer = document.querySelector(".ezy__team-grid");

    function staffGet() {
        // staffContainer.innerHTML = "<div class=\"loder-wrapper\"><div class=\"loader\"></div></div>";

        fetch('/staff/data')
            .then(response => response.json())
            .then(data => {
                
                    if (data.error) {
                        staffContainer.innerHTML = `<p>${data.error}</p>`;
                        return;
                    }
                    console.log(data);

                    if (data.length === 0) {
                        staffContainer.innerHTML = `
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
                        return;
                    } else {
                    }

                    const mealCards = data.map(staff => `
                                <div class="ezy__team-card">
                                    <img 
                                    src="${staff.photo}"
                                    alt="${staff.firstname + " "+staff.lastname  }" 
                                    class="ezy__team-card-image"
                                    >
                                    <div class="ezy__team-card-content">
                                    <h3 class="ezy__team-member-name">${staff.firstname + " "+staff.lastname  }</h3>
                                    <p class="ezy__team-member-position">${staff.position +'-' + staff.branch_name}</p>
                                    </div>
                                </div>
                    `).join('');

                    staffContainer.innerHTML = mealCards;
                
            })
            .catch(error => {
                console.error('Error fetching meals:', error);
                staffContainer.innerHTML = "<p>Failed to load meals. Please try again later.</p>";
            });
    }


    // Initial load
    staffGet();

   
});