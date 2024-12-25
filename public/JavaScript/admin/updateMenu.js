fetch("/menuitem/data")
            .then((response) => response.json())
            .then((data) => {
              if (data.error) {
                console.error("Error:", data.error);
              } else {
                // Get the meal content container
                const mealContent = document.getElementById("main-content");

                if (data == null || data.length === 0) {
                  mealContent.innerHTML = "No meals available"; // Show a message if there are no meals
                } else {
                  mealContent.innerHTML = ""; // Clear previous content if data is available
                }

                mealContent.innerHTML = `

                                    <div class="view-branch-menu-section">
                                            <div class="topic-bar">
                                                <div>
                                                    <h2 style="margin:0;">Nawala</h2>
                                                    <h5 style="margin:0;">36 meals available</h5>
                                                </div>

                                                <div>
                                                    <button class="add-item-btn">Add New Item</button>
                                                </div>

                                            </div>

                                            <div id="add-item-form" class="add-item-form hidden">
                                            <form id="add-form" action="">
                                            <h3>Add New Menu Item</h3>
                                                    <div class="form-group">
                                                        <label for="item-id">Meal Id</label>
                                                        <input type="text" id="item-id" name="meal_id" placeholder="Enter Meal id">
                                                    </div>
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
                                                            <option value="Appetizers">Appetizers</option>
                                                            <option value="Pasta">Pasta</option>
                                                            <option value="Dolphin Kottu">Dolphin Kottu</option>
                                                            <option value="KL Inventions">KL Inventions</option>
                                                            <option value="Wraps & Rotti Sandwiches">Wraps & Rotti Sandwiches</option>
                                                            <option value="Parata">Parata</option>
                                                            <option value="Devilled Portions">Devilled Portions</option>
                                                            <option value="KL Special Fried Rice">KL Special Fried Rice</option>
                                                            <option value="Classic Kottu">Classic Kottu</option>
                                                            <option value="Cheese Kottu">Cheese Kottu</option>
                                                            <option value="String Hopper Kottu">String Hopper Kottu</option>
                                                            <option value="Mocktails">Mocktails</option>
                                                            <option value="Beverages">Beverages</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="submit" name="submit" class="save-item-btn" placeholder="Submit">

                                                    </div>

                                                    <div class="form-group">
                                                        <button class="cancel-item-btn">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                               
                                            <table class="menu-table" id="menu-table">
                                                <thead>
                                                    <tr>
                                                        <th>Meal ID</th>
                                                        <th>Name</th>
                                                        <th>Type</th>
                                                        <th>Price</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-content"></tbody>
                                            </table>
                                        </div>

                                `;

                let mealId;
                // Dynamically generate meal elements
                data.forEach((meal) => {
                  // Create a new table row
                  const row = document.createElement("tr");

                  // Populate row HTML
                  row.innerHTML = `
                                        <td class="meal-id" >${
                                          meal.meal_id
                                        }</td>
                                        <td>${meal.meal_name}</td>
                                        <td>${meal.meal_description}</td>
                                        <td>Rs.${meal.meal_price}</td>
                                        
                                        <td>
                                            

                                            <div class="action-buttons">
                                                <button class="edit-btn" meal-id='${
                                                  meal.meal_id
                                                }'>Edit</button>
                                                <button class="delete-btn" meal-id ='${
                                                  meal.meal_id
                                                }'>Delete</button>
                                            </div>
                                        </td>
                                    `;

                  // Append the row directly to the table body
                  document.getElementById("table-content").appendChild(row);
                });

                // Get Elements
                const openFormBtn = document.querySelector(".add-item-btn");
                const closeFormBtn = document.querySelector(".cancel-item-btn");
                const addItemForm = document.getElementById("add-item-form");
                const addForm = document.getElementById("add-form");

                // Open the Popup
                openFormBtn.addEventListener("click", () => {
                  addItemForm.classList.remove("hidden");
                  resetForm();
                  addForm.removeEventListener("submit", updateItem);
                  addForm.addEventListener("submit", addNewItem);
                });

                // Close the Popup
                closeFormBtn.addEventListener("click", (event) => {
                  addItemForm.classList.add("hidden");
                  event.preventDefault();
                  resetForm();
                });

                // Add event listeners to the status buttons to toggle availability
                const statusButtons = document.querySelectorAll(".status-btn");
                statusButtons.forEach((button) => {
                  button.addEventListener("click", () => {
                    if (button.classList.contains("available")) {
                      button.classList.remove("available");
                      button.classList.add("unavailable");
                      button.textContent = "Unavailable";
                    } else {
                      button.classList.remove("unavailable");
                      button.classList.add("available");
                      button.textContent = "Available";
                    }
                  });
                });

                // Edit Button Event Listener
                document.querySelectorAll(".edit-btn").forEach((button) => {
                  button.addEventListener("click", function () {
                    mealId = button.getAttribute("meal-id");
                    console.log(mealId);
                    const row = button.closest("tr");
                    const mealName =
                      row.querySelector("td:nth-child(2)").innerText;
                    const mealDescription =
                      row.querySelector("td:nth-child(3)").innerText;
                    const mealPrice = row
                      .querySelector("td:nth-child(4)")
                      .innerText.replace("Rs.", "");

                    // Open the form and fill it with the existing data
                    addItemForm.classList.remove("hidden");
                    document.getElementById("item-id").value = mealId;
                    document.getElementById("item-name").value = mealName;
                    document.getElementById("item-price").value = mealPrice;
                    document.getElementById("meal_description").value =
                      mealDescription;

                    // Change form action to update
                    addForm.removeEventListener("submit", addNewItem);
                    addForm.addEventListener("submit", updateItem);
                  });
                });

                function addNewItem(event) {
                  event.preventDefault();
                  const formData = new FormData(addForm);
                  const data = Object.fromEntries(formData.entries());

                  const requestBody = JSON.stringify(data);
                  fetch("/menuitem/add", {
                    method: "POST",
                    headers: {
                      "Content-Type": "application/json",
                    },
                    body: requestBody,
                  })
                    .then((response) => {
                      if (!response.ok) {
                        throw new Error(
                          `HTTP error! status: ${response.status}`
                        );
                      }
                      return response.json();
                    })
                    .then((data) => {
                      console.log("Success:", data);
                      addItemForm.classList.add("hidden");
                      resetForm();
                    })
                    .catch((error) => {
                      console.error("Error:", error);
                    });
                }

                // Function to update an existing item
                function updateItem(event) {
                  event.preventDefault();
                  const formData = new FormData(addForm);
                  let data = Object.fromEntries(formData.entries());
                  data.older_id = mealId;
                  const requestBody = JSON.stringify(data);
                  console.log("Request Body:", requestBody);
                  fetch("/menuitem/update", {
                    method: "POST",
                    headers: {
                      "Content-Type": "application/json",
                    },
                    body: requestBody,
                  })
                    .then((response) => {
                      if (!response.ok) {
                        throw new Error(
                          `HTTP error! status: ${response.status}`
                        );
                      }
                      return response.json();
                    })
                    .then((data) => {
                      console.log("Success:", data);
                      addItemForm.classList.add("hidden");
                      resetForm();
                      addForm.removeEventListener("submit", updateItem);
                      addForm.addEventListener("submit", addNewItem);
                    })
                    .catch((error) => {
                      console.error("Error:", error);
                    });
                }

                // Function to reset the form
                function resetForm() {
                  addForm.reset();
                  document.getElementById("item-id").value = "";
                }

                // Add event listeners to delete buttons
                const deleteButtons = document.querySelectorAll(".delete-btn");
                deleteButtons.forEach((button) => {
                  button.addEventListener("click", () => {
                    // const row = button.closest('tr');
                    // row.remove();

                    if (
                      confirm(
                        "Are you sure you want to delete this meal? This action cannot be undone."
                      )
                    ) {
                      const mealId = button.getAttribute("meal-id");

                      const requestBody = JSON.stringify({ meal_id: mealId });
                      console.log("Request Body:", requestBody);

                      fetch("/mealitem/delete", {
                        method: "POST",
                        headers: {
                          "Content-Type": "application/json",
                        },
                        body: requestBody,
                      })
                        .then((response) => response.json())
                        .then((data) => {
                          if (data.success) {
                            alert("The meal has been deleted.");
                            button.closest("tr").remove();

                          } else {
                            alert(
                              "There was an error deleting the meal: " +
                                data.message
                            );
                            console.error("Error:", data.message);
                          }
                        })
                        .catch((error) => console.error("Error:", error));
                    }
                  });
                });
              }
            });