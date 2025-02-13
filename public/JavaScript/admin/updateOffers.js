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
            const fileInput = document.getElementById("offer_photo");
            const formData = new FormData(form);

            if (fileInput.files[0]) {
                formData.append(
                  "offer_photo",
                  "/Photo/offers/" + fileInput.files[0].name
                );
              }

            const formObject = Object.fromEntries(formData.entries());

            // Combine form data and selectedMeals into one object
            const requestBody = {
                ...formObject,
                ...selectedMeals.reduce((acc, mealId, index) => {
                    acc[`meal${index + 1}`] = mealId; // Add meal keys at the root level
                    return acc;
                }, {})
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

    fetch("/offer/get")
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                console.error("Error:", data.error);
            } else {
                // Get the meal content container
                const mealContent = document.getElementById("offers-container");

                if (data == null || data.length === 0) {
                    mealContent.innerHTML = "No offer available"; // Show a message if there are no meals
                } else {
                    mealContent.innerHTML = ""; // Clear previous content if data is available
                }

                mealContent.innerHTML = `

                                    <div class="view-branch-menu-section">
                                            <div class="topic-bar">
                                                <div>
                                                    <h2 style="margin:0;">Meals</h2>
                                                    <h5 style="margin:0;">${data.length} meals available</h5>
                                                </div>

                                                <div>
                                                    <button class="add-item-btn">Add New Item</button>
                                                </div>

                                            </div>

                                            <div id="add-item-form" class="add-item-form hidden">
    <form id="add-form" action="">
        <h3>Add New Menu Item</h3>
        <div class="form-group-main">
        
        <div>
        <div class="form-group">
            <label for="item-name">Meal Name</label>
            <input type="text" id="item-name" name="meal_name" placeholder="Enter item name">
        </div>

        <div class="form-group">
            <label for="item-price">Meal Price</label>
            <input type="number" id="item-price" name="meal_price" placeholder="Enter price" min="0" step="0.01">
        </div>


        <div class="form-group">
            <label for="meal_description">Description</label>
            <select id="meal_description" name="meal_description" required>
                <option  value="1">All</option>
            <option  value="2">Classic Kottu</option>
            <option  value="3">Dolphin Kottu</option>
            <option  value="4">Cheese Kottu</option>
            <option  value="5">String Hopper Kottu</option>
            <option  value="6">KL Special Fried Rice</option>
            <option  value="7">Pasta</option>
            <option  value="8">Appetizers</option>
            <option  value="9">KL Inventions</option>
            <option  value="10">Wraps & Rotti Sandwiches</option>
            <option  value="11">Parata</option>
            <option  value="12">Devilled Portions</option>
            <option  value="13">Mocktails</option>
            <option  value="14">Beverages</option>
            </select>
        </div>

        <div class="check-box-container">
          <div class="branch-group">
              <input type="checkbox" id="wattala" name="branch1" value="1">
              <label for="wattala">Wattala</label>
          </div>

          <div class="branch-group">
              <input type="checkbox" id="kelaniya" name="branch2" value="2">
              <label for="kelaniya">Kelaniya</label>
          </div>

          <div class="branch-group">
              <input type="checkbox" id="kotahena" name="branch3" value="3">
              <label for="kotahena">Kotahena</label>
          </div>
    </div>


        </div>


        <!-- Image Upload Section -->

        
        <div class="form-group">
            <label for="meal_photo">Item Image</label>
            <div class="image-upload-container">
                <div class="image-preview" id="imagePreview">
                    <img src="placeholder.jpg" alt="Preview" id="preview-image">
                    <div class="upload-placeholder">
                        <i class="upload-icon">📸</i>
                        <span>Click or drag image here</span>
                    </div>
                </div>
                <input type="file" 
                       id="meal_photo" 
                       name="item_photo" 
                       accept="image/*"
                       class="image-input">
            </div>
            <span class="image-help-text">Recommended: 500x500px, Max size: 2MB</span>
        </div>

        </div>

        <div class="button-group">

          <div class="form-group">
              <button class="cancel-item-btn">Cancel</button>
          </div>

          <div class="form-group">
              <input type="submit" name="submit" class="save-item-btn" placeholder="Submit">
          </div>

        </div>
    </form>
</div>
                                               
                                            <table class="menu-table" id="menu-table">
                                                <thead>
                                                    <tr>
                                                        <th>Offer ID</th>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th>Price</th>
                                                        <th>Branch</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-content"></tbody>
                                            </table>
                                        </div>

                                `;

                                const imageInput = document.getElementById("meal_photo");
                                const imagePreview = document.getElementById("imagePreview");
                                const previewImage = document.getElementById("preview-image");
                                const newPlaceHolder = document.querySelectorAll(".upload-placeholder");
                          
                                imageInput.addEventListener("change", function (event) {
                                  const file = event.target.files[0]; // Get the selected file
                                  if (file) {
                                    newPlaceHolder.forEach((placeholder) =>
                                      placeholder.classList.add("hidden-img")
                                    ); // Hide the placeholder
                                    const reader = new FileReader(); // Create a FileReader to read the file
                          
                                    reader.onload = function (e) {
                                      let imageURL = e.target.result;
                                      previewImage.src = imageURL; // Set the src of the img to the file content
                                      imagePreview.classList.add("has-image"); // Add a class to indicate the image is loaded
                          
                                      // window.uploadedImage = imageURL;
                                    };
                          
                                    reader.readAsDataURL(file); // Read the file as a data URL
                                  }
                                });
                          
                                let offerId;
                                // Dynamically generate meal elements
                                data.forEach((offer) => {
                                  // console.log(meal.branch_ids);
                                  // Create a new table row
                                  const row = document.createElement("tr");
                          
                                  // Populate row HTML
                                  row.innerHTML = `
                                                                  <td class="meal-id" >${offer.offer_id}</td>
                                                                  <td>${offer.offer_name}</td>
                                                                  <td>${offer.offer_description}</td>
                                                                  <td>Rs.${offer.offer_price}</td>
                                                                  <td>${
                                                                    offer.branch_ids == "1" ? "Wattala" : offer.branch_ids == "2" ? "Kelaniya" : offer.branch_ids== "3" ? "Kotahena"
                                                                    : offer.branch_ids == '1,2' ? "Wattala, Kelaniya" : offer.branch_ids == '1,3' ? "Wattala, Kotahena" : offer.branch_ids == '2,3' ? "Kelaniya, Kotahena" : "All Branches"
                                                                    }</td>
                                                                  
                                                                  <td>
                                                                      
                          
                                                                      <div class="action-buttons">
                                                                          <button class="edit-btn" meal-id='${offer.offer_id}'>Edit</button>
                                                                          <button class="delete-btn" meal-id ='${offer.offer_id}'>Delete</button>
                                                                      </div>
                                                                  </td>
                                                              `;
                          
                                  // Append the row directly to the table body
                                  document.getElementById("table-content").appendChild(row);
                                });

                            }
        })
        .catch((error) => {
            console.error("Error fetching menu item data:", error);
        });
});




















