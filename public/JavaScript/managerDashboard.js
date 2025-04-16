document.addEventListener("DOMContentLoaded", () => {
  // Select all sidebar list items
  const sidebarOptions = document.querySelectorAll(".sidebar ul li");
  const mainContent = document.getElementById("main-content");

  // Default selection to "view-users"
  // Default selection to "view-users"
  const defaultOption = document.getElementById("update-menu");
  defaultOption.classList.add("selected");

  let branchName='';
  fetch('/manager/branch')  // URL of the PHP controller
    .then(response => response.json())  // Parse JSON response
    .then(data => {
        if (data.branchName) {
            branchName = data.branchName;  // Extract branch name from the response
            console.log("Manager's Branch: " + data.branchName);

            // Display branch name in the HTML element with id "branchDisplay"
            document.getElementById('branchDisplay').innerHTML = `Branch Name: ${branchName}`;
        } else {
            console.log('Error: ' + data.error);
        }
    })
    .catch(error => console.log('Error:', error));

  // Render default content
  mainContent.innerHTML = ``;

  // Event listener for each sidebar option
  sidebarOptions.forEach((option) => {
    option.addEventListener("click", () => {
      // Remove 'selected' class from all options
      sidebarOptions.forEach((opt) => opt.classList.remove("selected"));
      // Add 'selected' class to the clicked option
      option.classList.add("selected");

      // Render appropriate content
      const optionId = option.id;

      switch (optionId) {
        case "update-menu":
          fetch("/managermenuitem/data")
            .then((response) => response.json())
            .then((data) => {
              const mealContent = document.getElementById("main-content");

              if (data.error) {
                console.error("Error:", data.error);
                mealContent.innerHTML = "Error loading meals";
              } else if (data == null || data.length === 0) {
                mealContent.innerHTML = "No meals available";
                return; 
              } else {

                mealContent.innerHTML = `
                                    <div class="view-branch-menu-section">
                                            <div class="topic-bar">
                                                <div>
                                                    <h2 style="margin:0;">${branchName}</h2>
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
                                                        <th>Meal ID</th>
                                                        <th>Name</th>
                                                        <th>Type</th>
                                                        <th>Price</th>
                                                        <th>Availability</th>
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

                                        <button class="status-btn ${
                                          meal.meal_status == 1
                                          ? "available" : "unavailable"
                                        }">
                                                ${
                                                  meal.meal_status == 1
                                                    ? "Available"
                                                    : "Unavailable"
                                                }
                                            </button>
                                            
                                        </td>
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
                    const row = button.closest("tr");
                    const mealId = row.querySelector(".meal-id").textContent.trim();
                    const isAvailable = button.classList.contains("available");
                    const newStatus = isAvailable ? 0 : 1;
                
                    fetch("/menuitem/status", {
                      method: "POST",
                      headers: {
                        "Content-Type": "application/json",
                      },
                      body: JSON.stringify({
                        meal_id: mealId,
                        status: newStatus,
                      }),
                    })
                      .then((res) => res.json())
                      .then((data) => {
                        if (data.success) {
                          button.classList.toggle("available");
                          button.classList.toggle("unavailable");
                          button.textContent = newStatus ? "Available" : "Unavailable";
                        } else {
                          alert("Failed to update status.");
                        }
                      })
                      .catch((err) => {
                        console.error("Error:", err);
                        alert("Something went wrong.");
                      });
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

          break;

        case "view-reservations":
            fetch("/reservation/data")
            .then((response) => {
              if (!response.ok) {
                throw new Error("Network response was not ok");
              }
              return response.json();
            })
            .then((data) => {
              if (!Array.isArray(data)) {
                console.error("Data is not an array");
                document.getElementById("main-content").innerHTML = "<p>Error: Invalid data format</p>";
                return;
              }
          
              const reservationContent = document.getElementById("main-content");
          
              if (!data || data.length === 0) {
                reservationContent.innerHTML = "<p>No reservations available</p>";
                return;
              }
          
              // Clear the content and build the table structure
              reservationContent.innerHTML = `
                <div class="view-branch-menu-section">
                  <div class="topic-bar">
                    <div>
                      <h2>Nawala</h2>
                      <h5>${data.length} reservations available</h5>
                    </div>
                  </div>
                  <table class="menu-table" id="menu-table">
                    <thead>
                      <tr>
                        <th>Reservation No</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>No. Guests</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="table-content"></tbody>
                  </table>
                </div>
              `;
          
              const tableContent = document.getElementById("table-content");
          
              if (!tableContent) {
                console.error("Table content element not found.");
                return;
              }
          
              // Populate the table with reservation data
              data.forEach((reservation) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                  <td class="reservation-id">${reservation.reservation_no}</td>
                  <td>${reservation.reservation_date}</td>
                  <td>${reservation.reservation_time}</td>
                  <td>${reservation.number_of_guests}</td>
                  <td>
                    <button class="status-btn ${reservation.confirmation_status ? "available" : "unavailable"}">
                      ${reservation.confirmation_status ? "Confirmed" : "Pending"}
                    </button>
                  </td>
                  <td>
                    <div class="action-buttons">
                      <button class="delete-btn" reservation-no='${reservation.reservation_no}'>Delete</button>
                    </div>
                  </td>
                `;
                tableContent.appendChild(row);
              });
          
              // Handle status button toggle
              const statusButtons = document.querySelectorAll(".status-btn");
              statusButtons.forEach((button) => {
                button.addEventListener("click", () => {
                  const isAvailable = button.classList.contains("available");
                  button.classList.toggle("available", !isAvailable);
                  button.classList.toggle("unavailable", isAvailable);
                  button.textContent = isAvailable ? "Pending" : "Confirmed";
                  fetch('/reservation/update', {
                    method: 'POST',
                    headers: {
                      "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                      'confirmation_status': isAvailable ? 0 : 1,
                      'reservation_no': button.closest("tr").querySelector(".reservation-id").textContent
                    })
                  });
                });
              });
          
            
              // Handle delete button click
              document.querySelectorAll(".delete-btn").forEach((button) => {
                button.addEventListener("click", () => {
                  if (confirm("Are you sure you want to delete this reservation? This action cannot be undone.")) {
                    const reservationNo = button.getAttribute("reservation-no");
          
                    const requestBody = JSON.stringify({ reservation_no: reservationNo });
                    console.log("Request Body:", requestBody);
          
                    fetch("/reservation/delete", {
                      method: "POST",
                      headers: {
                        "Content-Type": "application/json",
                      },
                      body: requestBody,
                    })
                      .then((response) => {
                        if (!response.ok) {
                          throw new Error("Network response was not ok");
                        }
                        return response.json();
                      })
                      .then((data) => {
                        if (data.success) {
                          alert("The reservation has been deleted.");
                          button.closest("tr").remove();
                        } else {
                          alert("There was an error deleting the reservation: " + data.message);
                          console.error("Error:", data.message);
                        }
                      })
                      .catch((error) => {
                        console.error("Error:", error);
                        alert("Failed to delete the reservation.");
                      });
                  }
                });
              });
            })
            .catch((error) => {
              console.error("Fetch error:", error);
              document.getElementById("main-content").innerHTML = "<p>Error loading reservations.</p>";
            });
          
         break;

        case "update-offers":
          mainContent.innerHTML = ``;
          fetch("/offer/data")

        case "feedbacks":
          mainContent.innerHTML = `
                        <div class="feedbacks-section">
                            <h2>Customer Feedbacks</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Rating</th>
                                        <th>Review</th>
                                        <th>Customer Name</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>5/5</td>
                                        <td>Excellent service and amazing food!</td>
                                        <td>Thirani Imanya</td>
                                        <td>2024-11-20</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4/5</td>
                                        <td>Great experience, but waiting time was long.</td>
                                        <td>Nadun Madushanka</td>
                                        <td>2024-11-21</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5/5</td>
                                        <td>The kottu was out of this world!</td>
                                        <td>Imeth Methnuka</td>
                                        <td>2024-11-22</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3/5</td>
                                        <td>Food was good, but the drinks could be better.</td>
                                        <td>Abdul Raheem</td>
                                        <td>2024-11-23</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>`;
          break;

        case "order-history":
          mainContent.innerHTML = `
                        <div class="order-history-section">
                            <h2>Order History</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Customer Name</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#1001</td>
                                        <td>2024-11-20</td>
                                        <td>18:30</td>
                                        <td>John Doe</td>
                                        <td>$45.00</td>
                                        <td>Completed</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>View</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#1002</td>
                                        <td>2024-11-21</td>
                                        <td>19:00</td>
                                        <td>Jane Smith</td>
                                        <td>$25.00</td>
                                        <td>Pending</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>View</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#1003</td>
                                        <td>2024-11-22</td>
                                        <td>20:15</td>
                                        <td>Michael Brown</td>
                                        <td>$60.00</td>
                                        <td>Completed</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>View</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#1004</td>
                                        <td>2024-11-23</td>
                                        <td>17:45</td>
                                        <td>Linda Lee</td>
                                        <td>$30.00</td>
                                        <td>Cancelled</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button>View</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>`;
          break;

        default:
          mainContent.innerHTML = `<h2>${optionId.replace(
            "-",
            " "
          )}</h2><p>Content for this section will go here.</p>`;
          break;
      }
    });
  });
});
