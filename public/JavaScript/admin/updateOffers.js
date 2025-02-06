window.addEventListener("load", () => {
    console.log("Page loaded");
    const form = document.getElementById("update-form");

    // Retrieve selectedMeals from localStorage
    const selectedMealsJSON = localStorage.getItem("selectedMeals");
    const selectedMeals = JSON.parse(selectedMealsJSON);

    if (selectedMeals && selectedMeals.length > 0) {
        // console.log("Selected Meal IDs:", selectedMeals);

        fetch("/menuitem/data")
            .then((response) => response.json())
            .then((data) => {
                if (data.error) {
                    console.error("Error:", data.error);
                    return;
                }

                // Filter data to only include items with matching IDs in selectedMeals
                const matchingItems = data.filter(item => selectedMeals.includes(item.meal_id));

                // console.log("Matching Menu Items:", matchingItems);

                const container = document.querySelector("#selected-meals-container");
                container.innerHTML = ""; // Clear previous content

                matchingItems.forEach(item => {
                    const mealElement = document.createElement("div");
                    mealElement.classList.add("meal-item");
                    mealElement.innerHTML = `
                        <div class="meal-name">${item.meal_name}</div>
                    `;
                    container.appendChild(mealElement);
                });

            })
            .catch((error) => {
                console.error("Error fetching menu item data:", error);
            });
    } // Close the if statement

    form.addEventListener("submit", async (event) => {
        

        // Show confirmation dialog
        const isConfirmed = confirm("Are you sure you want to submit the form?");

        if (isConfirmed) {
            // Create an object to hold form data
            const formData = new FormData(form);
            const formObject = Object.fromEntries(formData.entries());

            // Combine form data and selectedMeals into one object
            const requestBody = {
                ...formObject, // Spread form data
                selectedMeals, // Add selectedMeals array
            };

            console.log(requestBody);

            try {
                const response = await fetch("/offer/add", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(requestBody),
                });

                const result = await response.json();

                if (response.ok) {
                    // Clear localStorage after successful form submission
                    localStorage.removeItem("selectedMeals");
                    document.getElementById("response-message").innerText = "Offer added successfully!";
                } else {
                    document.getElementById("response-message").innerText = "Error: " + result.message;
                }
            } catch (error) {
                console.error("Error submitting form:", error);
                document.getElementById("response-message").innerText = "Failed to connect to server.";
            }
        } else {
            // User clicked "Cancel", do nothing or provide feedback
            console.log("Form submission cancelled by user.");
        }
    });

}); // Close the window event listener