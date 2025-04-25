// Meals Report Modal Functionality
const mealReportModal = document.getElementById("mealReportModal");
const mealReportButton = document.querySelector(".report-btn:nth-of-type(2)");
const closeMealModal = document.getElementById("closeMealModal");
let allMealsData = [];

// Load meals data when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadMealsData();
    
    // Set up event listeners for filter buttons
    document.getElementById('applyMealFilters').addEventListener('click', applyFilters);
    document.getElementById('resetMealFilters').addEventListener('click', resetFilters);
    document.getElementById('printMealReportBtn').addEventListener('click', printMealReport);
});

/**
 * Load meals data from server
 */
function loadMealsData() {
    // Show loading indicator
    document.getElementById('applyMealFilters').classList.add("loading");
    
    fetch("/admin/reports/meals")
        .then((response) => response.json())
        .then((data) => {
            allMealsData = data;
            renderMealTable(allMealsData);
            document.getElementById('applyMealFilters').classList.remove("loading");
        })
        .catch((error) => {
            console.error("Error fetching data:", error);
            document.getElementById('applyMealFilters').classList.remove("loading");
            alert("Failed to load meal report data. Please try again");
        });
}

document.getElementById('applyMealFilters').addEventListener('click', function() {
    const startDate = document.getElementById('mealStartDate').value;
    const endDate = document.getElementById('mealEndDate').value;
    const branchId = document.getElementById('mealBranchFilter').value;
    
    // Build query parameters
    let params = new URLSearchParams();
    
    if (startDate) params.append('startDate', startDate);
    if (endDate) params.append('endDate', endDate);
    if (branchId) params.append('branchId', branchId);
    
    // Show loading state
    this.classList.add("loading");
    
    fetch(`/admin/reports/meals?${params.toString()}`)
        .then((response) => response.json())
        .then((data) => {
            renderMealTable(data);
            this.classList.remove("loading");
        })
        .catch((error) => {
            console.error("Error fetching filtered data:", error);
            this.classList.remove("loading");
            alert("Failed to apply filters. Please try again");
        });
});

// Function to render the meal table
function renderMealTable(meals) {
    const tbody = document.getElementById('mealReportTableBody');
    tbody.innerHTML = "";
    
    let totalRevenue = 0;
    let totalQuantity = 0;
    
    if (meals.length === 0) {
        const row = document.createElement('tr');
        row.innerHTML = `<td colspan="4" style="text-align: center;">No meals data available for the selected filters</td>`;
        tbody.appendChild(row);
        return;
    }
    
    meals.forEach((meal) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${meal.meal_id}</td>
            <td>${meal.meal_name}</td>
            <td>${meal.total_quantity}</td>
            <td>${Number(meal.total_revenue).toFixed(2)}</td>
        `;
        tbody.appendChild(row);
        
        totalRevenue += Number(meal.total_revenue) || 0;
        totalQuantity += Number(meal.total_quantity) || 0;
    });
    
    // Add total row
    const totalRow = document.createElement('tr');
    totalRow.style.fontWeight = "bold";
    totalRow.style.backgroundColor = "rgba(230, 57, 70, 0.1)";
    totalRow.innerHTML = `
        <td colspan="2" style="text-align: right;">Total:</td>
        <td>${totalQuantity}</td>
        <td>Rs.${totalRevenue.toFixed(2)}</td>
    `;
    tbody.appendChild(totalRow);
}

function printMealReport() {
    const startDate = document.getElementById('mealStartDate').value;
    const endDate = document.getElementById('mealEndDate').value;
    const branchId = document.getElementById('mealBranchFilter').value;
    const branchText = document.getElementById('mealBranchFilter').options[document.getElementById('mealBranchFilter').selectedIndex].text;
    
    createMealPrintElements(startDate, endDate, branchId, branchText);
    
    const printBtn = document.getElementById('printMealReportBtn');
    printBtn.disabled = true;
    printBtn.classList.add('print-btn-disabled');
    
    setTimeout(() => {
        window.print();
        
        setTimeout(() => {
            printBtn.disabled = false;
            printBtn.classList.remove('print-btn-disabled');
            removeMealPrintElements();
        }, 1000);
    }, 200);
}

function createMealPrintElements(startDate, endDate, branchId, branchText) {
    const printContainer = document.createElement('div');
    printContainer.className = 'print-only';
    printContainer.id = 'mealPrintContainer';
    
    const now = new Date();
    const formattedDate = now.toLocaleDateString() + ' ' + now.toLocaleTimeString();
    
    const header = document.createElement('div');
    header.className = 'print-header';
    
    const title = document.createElement('h1');
    title.textContent = 'Meals Sales Report';
    header.appendChild(title);
    
    const dateElement = document.createElement('div');
    dateElement.className = 'print-date';
    dateElement.textContent = 'Generated on: ' + formattedDate;
    header.appendChild(dateElement);
    
    printContainer.appendChild(header);
    
    // Create filter summary
    if (startDate || endDate || branchId) {
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
document.getElementById('resetMealFilters').addEventListener('click', function() {
  // Clear all filter inputs
  document.getElementById('mealStartDate').value = '';
  document.getElementById('mealEndDate').value = '';
  document.getElementById('mealBranchFilter').value = '';
  
  // Show loading state
  this.classList.add("loading");
  
  // Fetch all data again (unfiltered)
  fetch("/admin/reports/meals")
      .then((response) => response.json())
      .then((data) => {
          renderMealTable(data);
          this.classList.remove("loading");
      })
      .catch((error) => {
          console.error("Error fetching data:", error);
          this.classList.remove("loading");
          alert("Failed to reset filters. Please try again");
      });
});

function removeMealPrintElements() {
    const printContainer = document.getElementById('mealPrintContainer');
    if (printContainer) {
        printContainer.remove();
    }
}