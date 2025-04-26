let allOrders = [];

// Load orders data when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadOrdersData();  // Changed function name to match implementation
    
    // Set up event listeners for filter buttons
    document.getElementById('applyFilters').addEventListener('click', applyFilters);
    document.getElementById('resetFilters').addEventListener('click', resetFilters);
    
    document.getElementById('printReportBtn').addEventListener('click', printOrderReport);
});

/**
 * Load orders data from server
 */
function loadOrdersData() {
    // Show loading indicator
    document.getElementById('applyFilters').classList.add("loading");
    
    fetch("/admin/reports/orders")
    .then((response) => response.json())
    .then((data) => {
      allOrders = data;
      renderOrderTable(allOrders);
      
      // Remove or fix this line - orderReportModal isn't defined
      // orderReportModal.style.display = "block";
      
      // Set today's date as default
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('reportDate').value = today;
      
      document.getElementById('applyFilters').classList.remove("loading");
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
      document.getElementById('applyFilters').classList.remove("loading");
      alert("Failed to load order report data. Please try again");
    });
}


document.getElementById('applyFilters').addEventListener('click', function() {
    const selectedDate = document.getElementById('reportDate').value;
    const selectedBranch = document.getElementById('branchFilter').value;
    const minPrice = parseFloat(document.getElementById('minPrice').value) || 0;
    const maxPrice = parseFloat(document.getElementById('maxPrice').value) || Infinity;
    
    let filteredOrders = [...allOrders]; // Start with all orders
    
    // Apply date filter if selected
    if (selectedDate) {
      filteredOrders = filteredOrders.filter(order => {
        const orderDate = new Date(order.order_date).toISOString().split('T')[0];
        return orderDate === selectedDate;
      });
    }
    
    // Apply branch filter if selected
    if (selectedBranch) {
      filteredOrders = filteredOrders.filter(order => order.branchName === selectedBranch);
    }
    
    // Apply price range filter
    filteredOrders = filteredOrders.filter(order => {
      const orderPrice = Number(order.order_price) || 0;
      return orderPrice >= minPrice && 
             (maxPrice === Infinity || orderPrice <= maxPrice);
    });
    
    renderOrderTable(filteredOrders);
  });
  
  // Reset all filters
  document.getElementById('resetFilters').addEventListener('click', function() {
    document.getElementById('reportDate').value = '';
    document.getElementById('branchFilter').value = '';
    document.getElementById('minPrice').value = '';
    document.getElementById('maxPrice').value = '';
    renderOrderTable(allOrders);
  });
  
  // Function to render the order table
  function renderOrderTable(orders) {
    const tbody = document.getElementById('orderReportTableBody');
    tbody.innerHTML = "";
    
    let totalSum = 0;
    
    if (orders.length === 0) {
      const row = document.createElement('tr');
      row.innerHTML = `<td colspan="6" style="text-align: center;">No orders match the current filters</td>`;
      tbody.appendChild(row);
      return;
    }
    
    orders.forEach((order) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${order.order_id}</td>
        <td>${new Date(order.order_date).toLocaleDateString()}</td>
        <td>${order.customer_name}</td>
        <td>${order.branchName}</td>
        <td>${order.reservation_type}</td>
        <td>${Number(order.order_price).toFixed(2)}</td>
      `;
      tbody.appendChild(row);
      totalSum += Number(order.order_price) || 0;
    });
    
    // Add total row
    const totalRow = document.createElement('tr');
    totalRow.style.fontWeight = "bold";
    totalRow.style.backgroundColor = "rgba(230, 57, 70, 0.1)";
    totalRow.innerHTML = `
      <td colspan="5" style="text-align: right;">
        Showing ${orders.length} of ${allOrders.length} orders | Total:
      </td>
      <td>Rs.${totalSum.toFixed(2)}</td>
    `;
    tbody.appendChild(totalRow);
  }
  
  

  function printOrderReport() {
    // Get current state
    const selectedDate = document.getElementById('reportDate').value;
    const selectedBranch = document.getElementById('branchFilter').value;
    const minPrice = document.getElementById('minPrice').value;
    const maxPrice = document.getElementById('maxPrice').value;
    
    // Create print elements that will only show when printing
    createPrintElements(selectedDate, selectedBranch, minPrice, maxPrice);
    
    // Disable print button to prevent multiple clicks
    const printBtn = document.getElementById('printReportBtn');
    printBtn.disabled = true;
    printBtn.classList.add('print-btn-disabled');
    
    // Set timeout to ensure print elements are rendered
    setTimeout(() => {
      // Trigger browser print dialog
      window.print();
      
      // Re-enable print button after printing
      setTimeout(() => {
        printBtn.disabled = false;
        printBtn.classList.remove('print-btn-disabled');
        
        // Clean up print elements
        removePrintElements();
      }, 1000);
    }, 200);
  }
  
  /**
   * Create print-specific elements for the report
   */
  function createPrintElements(selectedDate, selectedBranch, minPrice, maxPrice) {
    // Create container for print elements
    const printContainer = document.createElement('div');
    printContainer.className = 'print-only';
    printContainer.id = 'printContainer';
    
    // Format current date for the report
    const now = new Date();
    const formattedDate = now.toLocaleDateString() + ' ' + now.toLocaleTimeString();
    
    // Create header
    const header = document.createElement('div');
    header.className = 'print-header';
    
    // const title = document.createElement('h1');
    // title.textContent = 'Orders Report';
    // header.appendChild(title);
    
    const dateElement = document.createElement('div');
    dateElement.className = 'print-date';
    dateElement.textContent = 'Generated on: ' + formattedDate;
    header.appendChild(dateElement);
    
    printContainer.appendChild(header);
    
    // Create filter summary if any filters are applied
    if (selectedDate || selectedBranch || minPrice || maxPrice) {
      const filterSummary = document.createElement('div');
      filterSummary.className = 'print-filters';
      
      let filterText = '<strong>Filters Applied:</strong> ';
      
      if (selectedDate) {
        filterText += 'Date: ' + selectedDate + ' | ';
      }
      
      if (selectedBranch) {
        filterText += 'Branch: ' + selectedBranch + ' | ';
      }
      
      if (minPrice || maxPrice) {
        filterText += 'Price Range: ';
        if (minPrice) filterText += 'Rs.' + minPrice;
        filterText += ' to ';
        if (maxPrice) filterText += 'Rs.' + maxPrice;
        else filterText += 'any';
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
    
    // Add to document body
    document.body.appendChild(printContainer);
    
    // Mark the total row with a class for print styling
    const tbody = document.getElementById('orderReportTableBody');
    if (tbody && tbody.lastElementChild) {
      tbody.lastElementChild.classList.add('total-row');
    }
  }
  
  /**
   * Remove print elements after printing
   */
  function removePrintElements() {
    const printContainer = document.getElementById('printContainer');
    if (printContainer) {
      printContainer.remove();
    }
  }
  
  // Utility function to format currency
  function formatCurrency(amount) {
    return 'Rs.' + parseFloat(amount).toFixed(2);
  }