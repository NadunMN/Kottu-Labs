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
      document.getElementById("main-content").innerHTML =
        "<p>Error: Invalid data format</p>";
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
                    <button class="status-btn ${
                      reservation.confirmation_status
                        ? "available"
                        : "unavailable"
                    }">
                      ${
                        reservation.confirmation_status
                          ? "Confirmed"
                          : "Pending"
                      }
                    </button>
                  </td>
                  <td>
                    <div class="action-buttons">
                      <button class="delete-btn" reservation-no='${
                        reservation.reservation_no
                      }'>Delete</button>
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
        fetch("/reservation/update", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            confirmation_status: isAvailable ? 0 : 1,
            reservation_no: button
              .closest("tr")
              .querySelector(".reservation-id").textContent,
          }),
        });
      });
    });

    // Handle delete button click
    document.querySelectorAll(".delete-btn").forEach((button) => {
      button.addEventListener("click", () => {
        if (
          confirm(
            "Are you sure you want to delete this reservation? This action cannot be undone."
          )
        ) {
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
                alert(
                  "There was an error deleting the reservation: " + data.message
                );
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
    document.getElementById("main-content").innerHTML =
      "<p>Error loading reservations.</p>";
  });
