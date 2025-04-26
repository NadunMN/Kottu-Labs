let allReservationData = [];

// Load meals data when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadMealsData();
    
    // Set up event listeners for filter buttons
    document.getElementById('applyMealFilters').addEventListener('click', applyFilters);
    document.getElementById('resetMealFilters').addEventListener('click', resetFilters);
    document.getElementById('printMealReportBtn').addEventListener('click', printReservationReport);
});

/**
 * Load meals data from server
 */
function loadMealsData() {
    // Show loading indicator
    document.getElementById('applyMealFilters').classList.add("loading");
    
    fetch("/admin/reports/reservations")
        .then((response) => response.json())
        .then((data) => {
            allReservationData = data;
            renderReservationTable(allReservationData);
            document.getElementById('applyMealFilters').classList.remove("loading");
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
            document.getElementById('applyMealFilters').classList.remove("loading");
            alert("Failed to load meal report data. Please try again");
        });
}

function applyFilters() {
    const startDate = document.getElementById('mealStartDate').value;
    const endDate = document.getElementById('mealEndDate').value;
    const timeSlot = document.getElementById('timeFilter').value;
    const branchId = document.getElementById('mealBranchFilter').value;
    
    // Build query parameters
    let params = new URLSearchParams();
    
    if (startDate) params.append('startDate', startDate);
    if (endDate) params.append('endDate', endDate);
    if (timeSlot) params.append('timeSlot', timeSlot);
    if (branchId) params.append('branchId', branchId);
    
    // Show loading state
    document.getElementById('applyMealFilters').classList.add("loading");
    
    fetch(`/admin/reports/reservations?${params.toString()}`)
        .then((response) => response.json())
        .then((data) => {
            renderReservationTable(data);
            document.getElementById('applyMealFilters').classList.remove("loading");
        })
        .catch((error) => {
            console.error("Error fetching filtered data:", error);
            document.getElementById('applyMealFilters').classList.remove("loading");
            alert("Failed to apply filters. Please try again");
        });
}

// Function to render the meal table
function renderReservationTable(reservations) {
    const tbody = document.getElementById('mealReportTableBody');
    tbody.innerHTML = "";
    
    let noOfReservations = 0;
    let totalGuests = 0;

    if (reservations.length === 0) {
        const row = document.createElement('tr');
        row.innerHTML = `<td colspan="6" style="text-align: center;">No reservation data available for the selected filters</td>`;
        tbody.appendChild(row);
        return;
    }
    
    reservations.forEach((reservation) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${reservation.reservation_no}</td>
            <td>${reservation.reservation_date}</td>
            <td>${reservation.reservation_time}</td>
            <td>${reservation.branch_name}</td>
            <td>${reservation.reservation_name}</td>
            <td>${reservation.number_of_guests}</td>
        `;
        tbody.appendChild(row);
        
        noOfReservations++;
        totalGuests += parseInt(reservation.number_of_guests) || 0;
    });
    
    // Add total row
    const totalRow = document.createElement('tr');
    totalRow.style.fontWeight = "bold";
    totalRow.style.backgroundColor = "rgba(230, 57, 70, 0.1)";
    totalRow.innerHTML = `
        <td colspan="4" style="text-align: right;">Total:</td>
        <td>${noOfReservations} reservations</td>
        <td>${totalGuests} guests</td>
    `;
    tbody.appendChild(totalRow);
}

function printReservationReport() {
    const startDate = document.getElementById('mealStartDate').value;
    const endDate = document.getElementById('mealEndDate').value;
    const timeSlot = document.getElementById('timeFilter').value;
    const timeSlotText = timeSlot ? document.getElementById('timeFilter').options[document.getElementById('timeFilter').selectedIndex].text : '';
    const branchId = document.getElementById('mealBranchFilter').value;
    const branchText = branchId ? document.getElementById('mealBranchFilter').options[document.getElementById('mealBranchFilter').selectedIndex].text : 'All Branches';
    
    createPrintElements(startDate, endDate, timeSlot, timeSlotText, branchId, branchText);
    
    const printBtn = document.getElementById('printMealReportBtn');
    printBtn.disabled = true;
    printBtn.classList.add('print-btn-disabled');
    
    setTimeout(() => {
        window.print();
        
        setTimeout(() => {
            printBtn.disabled = false;
            printBtn.classList.remove('print-btn-disabled');
            removePrintElements();
        }, 1000);
    }, 200);
}

function createPrintElements(startDate, endDate, timeSlot, timeSlotText, branchId, branchText) {
    const printContainer = document.createElement('div');
    printContainer.className = 'print-only';
    printContainer.id = 'mealPrintContainer';
    
    const now = new Date();
    const formattedDate = now.toLocaleDateString() + ' ' + now.toLocaleTimeString();
    
    const header = document.createElement('div');
    header.className = 'print-header';
    
    const title = document.createElement('h1');
    title.textContent = 'Reservations Report';
    header.appendChild(title);
    
    const dateElement = document.createElement('div');
    dateElement.className = 'print-date';
    dateElement.textContent = 'Generated on: ' + formattedDate;
    header.appendChild(dateElement);
    
    printContainer.appendChild(header);
    
    // Create filter summary
    if (startDate || endDate || timeSlot || branchId) {
        const filterSummary = document.createElement('div');
        filterSummary.className = 'print-filters';
        
        let filterText = '<strong>Filters Applied:</strong> ';
        
        if (startDate || endDate) {
            filterText += 'Date Range: ';
            if (startDate) filterText += startDate;
            filterText += ' to ';
            if (endDate) filterText += endDate;
            filterText += ' | ';
        }

        if (timeSlot) {
            filterText += 'Time Slot: ' + timeSlotText + ' | ';
        }
        
        if (branchId) {
            filterText += 'Branch: ' + branchText;
        }
        
        // Remove trailing separator if exists
        if (filterText.endsWith(' | ')) {
            filterText = filterText.slice(0, -3);
        }
        
        filterSummary.innerHTML = filterText;
        printContainer.appendChild(filterSummary);
    }
    
    // Create footer
    const footer = document.createElement('div');
    footer.className = 'print-footer';
    footer.innerHTML = '© ' + new Date().getFullYear() + ' Kottu-Labs. All rights reserved.';
    printContainer.appendChild(footer);
    
    document.body.appendChild(printContainer);
    
    // Mark the total row for styling
    const tbody = document.getElementById('mealReportTableBody');
    if (tbody && tbody.lastElementChild) {
        tbody.lastElementChild.classList.add('total-row');
    }
}



// Reset filters for meals report
function resetFilters() {
    // Clear all filter inputs
    document.getElementById('mealStartDate').value = '';
    document.getElementById('mealEndDate').value = '';
    document.getElementById('timeFilter').value = '';
    document.getElementById('mealBranchFilter').value = '';
  
    // Show loading state
    document.getElementById('resetMealFilters').classList.add("loading");
  
    // Fetch all data again (unfiltered)
    fetch("/admin/reports/reservations")
        .then((response) => response.json())
        .then((data) => {
            renderReservationTable(data);
            document.getElementById('resetMealFilters').classList.remove("loading");
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
            document.getElementById('resetMealFilters').classList.remove("loading");
            alert("Failed to reset filters. Please try again");
        });
}

function removePrintElements() {
    const printContainer = document.getElementById('mealPrintContainer');
    if (printContainer) {
        printContainer.remove();
    }
}