async function fetchReservations() {
  try {
    const response = await fetch("/reservation/stewardData");
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
      reservationContent.innerHTML = `<div id="orderContent" class="empty-state">
        <div class="icon-container">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
        </div>
        <h2>No Reservations Yet</h2>
        <p>It looks like Branch haven't any reservations yet.</p>
        
    </div>`;
      return;
    }

    // Fetch user branch ID before rendering
    let branch_id = null;
    try {
      const userResponse = await fetch('/user/data');
      if (!userResponse.ok) {
        throw new Error("Network response was not ok");
      }
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
    const currentDate = new Date().toLocaleDateString('en-CA'); // Format: YYYY-MM-DD

    // Count pending reservations
    const pendingCount = data.filter(reservation => reservation.confirmation_status !== 1).length;

    reservationContent.innerHTML = `
      <div class="main-section">
        <div class="topic-bar">
          <div class="topic-bar-text">
            <h2>Customer Arrivals - ${branchName} </h2>
            <span>${currentDate}</span>
            <h4>${data.length} reservations available  &emsp; ${pendingCount} pending reservations</h4>
          </div>
        </div> 
        
        <table class="menu-table" id="menu-table">
          <thead>
            <tr>
              <th>Reservation No</th>
              <th>Time</th>
              <th>No. Guests</th>
              <th>Type</th>
              <th>Status</th>
              <th>Table No</th>
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
    data.sort((a, b) => {
      if (a.confirmation_status !== 1 && b.confirmation_status === 1) return -1;
      if (a.confirmation_status === 1 && b.confirmation_status !== 1) return 1;
      return a.reservation_time.localeCompare(b.reservation_time);
    });

    // Populate the table with reservation data
    data.forEach((reservation) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td class="reservation-id">${reservation.reservation_no}</td>
        <td>${reservation.reservation_time}</td>
        <td>${reservation.number_of_guests}</td>
        <td>${reservation.type === 'dinein' ? 'Dine In' : 'Take Away'}</td>
        <td class="status">
        <span class="status-${reservation.confirmation_status}">
            ${
          reservation.confirmation_status === 2
            ? 'Reservation Complete'
            : reservation.confirmation_status === 1
            ? 'Confirmed'
            : 'Pending'
            }
        </span>
        </td>
        <td>${reservation.table_number === 0 ? 'Null' : reservation.table_number}</td>
      `;
      tableContent.appendChild(row);
    });

  } catch (error) {
    console.error("Fetch error:", error);
    document.getElementById("main-content").innerHTML = "<p>Error loading reservations.</p>";
  }
}

// Refresh reservations every minute
setInterval(() => {
  fetchReservations();
}, 60000);

fetchReservations();