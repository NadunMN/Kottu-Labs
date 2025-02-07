async function fetchReservations() {
  try {
    const response = await fetch("/reservation/data");
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();
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

    // Fetch user branch ID before rendering
    let branch_id = null;
    try {
      const userResponse = await fetch('/user/data');
      const userData = await userResponse.json();
      if (userData.error) {
        console.error(userData.error);
      } else {
        branch_id = userData.branch_id;
      }
    } catch (error) {
      console.error('Error fetching user data:', error);
    }

    // Determine branch name
    const branchName = branch_id === 1 ? 'Wattala' : branch_id === 2 ? 'Kelaniya' : 'Kotahena';

    const currentDate = new Date().toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });

    reservationContent.innerHTML = `
      <div class="view-reservations-section">
        <div class="topic-bar">
          <div>
            <h2>${branchName} <span>${currentDate}</span></h2>
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
        <td class="status">
            <span class="status-${reservation.status}">
                ${reservation.status === 'confirmed' ? "Confirmed" : reservation.status === 'pending' ? "Pending" : "Not Come"}
            </span>
        </td>
        <td>
          <div class="action-buttons">
            <button class="delete-btn" reservation-no='${reservation.reservation_no}'>Delete</button>
          </div>
        </td>
      `;
      tableContent.appendChild(row);
    });


    // Handle delete button click
    document.querySelectorAll(".delete-btn").forEach((button) => {
      button.addEventListener("click", async () => {
        if (confirm("Are you sure you want to delete this reservation? This action cannot be undone.")) {
          const reservationNo = button.getAttribute("reservation-no");

          try {
            const response = await fetch("/reservation/delete", {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({ reservation_no: reservationNo }),
            });

            const result = await response.json();
            if (result.success) {
              alert("The reservation has been deleted.");
              button.closest("tr").remove();
            } else {
              alert("There was an error deleting the reservation: " + result.message);
              console.error("Error:", result.message);
            }
          } catch (error) {
            console.error("Error:", error);
            alert("Failed to delete the reservation.");
          }
        }
      });
    });

  } catch (error) {
    console.error("Fetch error:", error);
    document.getElementById("main-content").innerHTML = "<p>Error loading reservations.</p>";
  }
}

// Call the function to fetch and display reservations
fetchReservations();
