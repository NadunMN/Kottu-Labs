async function fetchReservations(selectedDate = null, selectedTime = null) {
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
    console.log('Branch name:', branchName);
    const currentDate = selectedDate || new Date().toISOString().split('T')[0];

    // Filter reservations for the selected date and branch
    const filteredData = data.filter(reservation => {
      const reservationDate = new Date(reservation.reservation_date).toISOString().slice(0, 10);
      return reservationDate === currentDate && reservation.branch_id === branch_id;
    });

    // Count pending reservations
    const pendingCount = filteredData.filter(reservation => reservation.confirmation_status !== 1).length;

    reservationContent.innerHTML = `
      <div class="main-section">
        <div class="topic-bar">
          <div class="topic-bar-text">
            <h2>Customer Arrivals - ${branchName} </h2>
            <span>${currentDate}</span>
            <h4>${filteredData.length} reservations available  &emsp; ${pendingCount} pending reservations</h4>
          </div>
          <div class="date-filter-container">
            <div class="date-input-group">
                <label for="date-filter">Select Date:</label>
                <input type="date" id="date-filter" value="${currentDate}"  />
            </div>
            <button id="current-date-button">Go to Current Date</button>
          </div>

        </div> 
        
        <table class="menu-table" id="menu-table">
          <thead>
            <tr>
              <th>Reservation No</th>
              <th>Date</th>
              <th>Time</th>
              <th>No. Guests</th>
              <th>Type</th>
              <th>Status</th>
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

    // Sort reservations: pending first, then confirmed, sorted by time
    filteredData.sort((a, b) => {
      // Prioritize pending reservations over confirmed ones
      if (a.confirmation_status !== 1 && b.confirmation_status === 1) return -1;
      if (a.confirmation_status === 1 && b.confirmation_status !== 1) return 1;

      // If both have the same status, sort by time
      return a.reservation_time.localeCompare(b.reservation_time);
    });

    // Populate the table with filtered reservation data
    filteredData.forEach((reservation) => {
      
      const row = document.createElement("tr");
      row.innerHTML = `
        <td class="reservation-id">${reservation.reservation_no}</td>
        <td>${reservation.reservation_date}</td>
        <td>${reservation.reservation_time}</td>
        <td>${reservation.number_of_guests}</td>
        <td>${reservation.type === 'dinein' ? 'Dine In' : 'Take Away'}</td>
        <td class="status">
            <span class="status-${reservation.confirmation_status}">
                ${reservation.confirmation_status === 1 ? "Confirmed" : 'pending'}
            </span>
        </td>
      `;
      tableContent.appendChild(row);
    });

    document.getElementById("date-filter").addEventListener("change", () => {
      const selectedDate = new Date(document.getElementById("date-filter").value).toISOString().slice(0, 10);
      fetchReservations(selectedDate);
    });

    document.getElementById("current-date-button").addEventListener("click", () => {
      const currentDate = new Date().toISOString().split('T')[0];
      document.getElementById("date-filter").value = currentDate;
      fetchReservations(currentDate);
    });

  } catch (error) {
    console.error("Fetch error:", error);
    document.getElementById("main-content").innerHTML = "<p>Error loading reservations.</p>";
  }
}

fetchReservations();
