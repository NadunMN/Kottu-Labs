// Fetch user data from the backend
fetch('/user/data')
       .then(response => response.json())
       .then(data => {
           if (data.error) {
               console.error(data.error);
           } else {
               // Display user data in the frontend
               document.getElementById('user-name').textContent = `${data.firstname} ${data.lastname}`;
               document.getElementById('user-email').textContent = `${data.email}`;

               // Fetch reservation data after userId is set
               const userId = data.id;
            fetch(`/usergetReservationDataOrder?userId=${userId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error("Error:", data.error);
                  } else {
                    // Get the reservation content container
                    const reservationContent = document.getElementById("table-container");
              
                    if (data == null || data.length === 0) {
                        reservationContent.innerHTML = `
                            <div class="no-offers-container" 
                                style="text-align: center; 
                                        display: flex; 
                                        flex-direction: column; 
                                        align-items: center; 
                                        justify-content: center; 
                                        padding: 2rem; 
                                        width: 100%;
                                        height: 250px;
                                        border-radius: 10px; 
                                        margin: 20px;">

                                <i class="fa-solid fa-truck" 
                                style="font-size: 3rem; 
                                        color: #6c757d; 
                                        margin-bottom: 1rem;"></i>

                                <h3 style="font-size: 1.5rem; 
                                        color: #343a40; 
                                        margin-bottom: 0.5rem; 
                                        font-weight: 600;">
                                    No Reservation Found!
                                </h3>

                                <p style="color: #6c757d; 
                                        font-size: 1rem; 
                                        max-width: 400px; 
                                        line-height: 1.5;">
                                    Add a Reservation!
                                </p>
                            </div>
                        `;
                    } else {
                        reservationContent.innerHTML = "";
                        reservationContent.innerHTML = `
                          <table class="menu-table" id="menu-table">
                              <thead>
                                  <tr>
                                      <th>Reservation Number</th>
                                      <th>Reservation Name</th>
                                      <th>Reservation Date</th>
                                      <th>Reservation Time</th>
                                      <th>Type</th>
                                      <th>Status</th>
                                      <th>Actions</th>
                                  </tr>
                              </thead>
                              <tbody id="table-content-row"></tbody>
                          </table>
                        `;

                        const confirmationStatus = {
                          0: "Pending",
                          1: "Confirmed"
                        };
                  
                        // Dynamically generate reservation elements
                        data.forEach((reservation) => {
                          // Create a new table row
                          const row = document.createElement("tr");
                  
                          // Populate row HTML
                          row.innerHTML = `
                            <td class="meal-id" >
                                <div class="staff-created" data-position="2">
                                    ${reservation.confirmation_number}
                                </div>
                            </td>
                            <td>${reservation.reservation_name}</td>
                            <td>${reservation.reservation_date}</td>
                            <td>${reservation.reservation_time}</td>
                            <td>${reservation.type}</td>
                            <td>
                                <div class="staff-created" data-position="${reservation.confirmation_status}">
                                    ${confirmationStatus[reservation.confirmation_status]}
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons action-btn">
                                    ${
                                        reservation.confirmation_status == 0 
                                        ? `<button class="delete-btn" reservation-no='${reservation.reservation_no}'>Delete</button>` 
                                        : `<button class="delete-btn" reservation-no='${reservation.reservation_no}' disabled style="background-color: #6c757d; cursor: not-allowed;">Delete</button>`
                                    }
                                </div>
                            </td>
                          `;
                  
                          // Append the row directly to the table body
                          document.getElementById("table-content-row").appendChild(row);
                        });
                        
                        // Add event listeners to delete buttons
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
                    }
                  }
            })
            .catch(error => {
                console.error('Error fetching reservation:', error);
            });
           }
           }
       )
       .catch(error => console.error('Error fetching user data:', error));