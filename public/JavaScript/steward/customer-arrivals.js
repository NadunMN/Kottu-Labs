document.addEventListener("DOMContentLoaded", () => {
    // Sample data array
    const arrivalsData = [
        { reservationNo: "R001", time: "19:00", heads: "4", bookedBy: "Thirani Imanya", tableNumber: "12", arrived: "YES" },
        { reservationNo: "R002", time: "20:30", heads: "2", bookedBy: "Nadun Madushanka", tableNumber: "5", arrived: "YES" },
        { reservationNo: "R003", time: "18:45", heads: "6", bookedBy: "Imeth Methnuka", tableNumber: "8", arrived: "NO" },
        { reservationNo: "R004", time: "21:00", heads: "3", bookedBy: "Praneesh Surendran", tableNumber: "3", arrived: "NO" }
    ];

    // Available tables for selection
    const availableTables = Array.from({length: 8}, (_, i) => (i + 1).toString().padStart(2, '0'));

    const mainContent = document.getElementById("main-content");

    function renderCustomerArrivals() {
        mainContent.innerHTML = `
            <div class="customer-arrivals-section">
                <h2>Customer Arrivals</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Reservation No.</th>
                            <th>Time</th>
                            <th>No. of Heads</th>
                            <th>Booked By</th>
                            <th>Table Number</th>
                            <th>Arrived</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="arrivals-body">
                    </tbody>
                </table>
            </div>`;

        populateArrivalsTable();
        addEventListeners();
    }

    function populateArrivalsTable() {
        const arrivalsBody = document.getElementById("arrivals-body");
        arrivalsBody.innerHTML = ''; // Clear existing content

        arrivalsData.forEach(arrival => {
            const row = document.createElement("tr");
            const arrivalColor = arrival.arrived === "YES" ? "green" : "red";
            row.innerHTML = `
                <td>${arrival.reservationNo}</td>
                <td>${arrival.time}</td>
                <td>${arrival.heads}</td>
                <td>${arrival.bookedBy}</td>
                <td>
                    <select class="table-select" data-reservation="${arrival.reservationNo}">
                        <option value="">Select Table</option>
                        ${availableTables.map(table => 
                            `<option value="${table}" ${arrival.tableNumber === table ? 'selected' : ''}>
                                ${table}
                            </option>`
                        ).join('')}
                    </select>
                </td>
                <td style="color: ${arrivalColor};">${arrival.arrived}</td>
                <td>
                    ${arrival.arrived === "YES" ? 
                        '<button class="confirm-btn">Confirm</button>' : 
                        '<button class="delete-btn">Delete</button>'}
                </td>
            `;
            arrivalsBody.appendChild(row);
        });
    }

    function addEventListeners() {
        // Handle table selection changes
        document.querySelectorAll('.table-select').forEach(select => {
            select.addEventListener('change', (e) => {
                const reservationNo = e.target.dataset.reservation;
                const newTableNumber = e.target.value;
                updateTableNumber(reservationNo, newTableNumber);
            });
        });

        // Handle confirm button clicks
        document.querySelectorAll('.confirm-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const row = e.target.closest('tr');
                handleConfirmation(row);
            });
        });

        // Handle delete button clicks
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const row = e.target.closest('tr');
                handleDeletion(row);
            });
        });
    }

    function updateTableNumber(reservationNo, newTableNumber) {
        // Find the reservation and update its table number
        const reservation = arrivalsData.find(r => r.reservationNo === reservationNo);
        if (reservation) {
            reservation.tableNumber = newTableNumber;
            // Here you would typically make an API call to update the backend
            console.log(`Updated table number to ${newTableNumber} for reservation ${reservationNo}`);
        }
    }

    function handleConfirmation(row) {
        // Here you would typically make an API call to confirm the arrival
        const reservationNo = row.cells[0].textContent;
        console.log(`Confirmed arrival for reservation ${reservationNo}`);
        row.remove();
    }

    function handleDeletion(row) {
        // Here you would typically make an API call to delete the reservation
        const reservationNo = row.cells[0].textContent;
        console.log(`Deleted reservation ${reservationNo}`);
        row.remove();
    }

    // Initial render
    renderCustomerArrivals();
});