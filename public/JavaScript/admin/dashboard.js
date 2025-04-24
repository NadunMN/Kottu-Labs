const wattalaValue = document.getElementById("value-wattala");
const kotahenaValue = document.getElementById("value-kotahena");
const kelaniyaValue = document.getElementById("value-kelaniya");
const registrations = document.getElementById("registrations");

fetch("/dashboard/getProfit")
  .then((response) => response.json())
  .then((data) => {
    data.forEach((item) => {
      const branch = item.branchName.toLowerCase();
      const value = item.total_price;

      if (branch === "wattala") {
        wattalaValue.innerHTML = `Rs.${value}`;
      } else if (branch === "kotahena") {
        kotahenaValue.innerHTML = `Rs.${value}`;
      } else if (branch === "kelaniya") {
        kelaniyaValue.innerHTML = `Rs.${value}`;
      }
    });
  })
  .catch((error) => {
    console.error("Error fetching data:", error);
  });

fetch("/dashboard/getRegistrationsCount")
  .then((response) => response.json())
  .then((data) => {
    const totalRegistrations = data[0].user_count;
    registrations.innerHTML = `${totalRegistrations}`;
  })
  .catch((error) => {
    console.error("Error fetching data:", error);
  });

fetch("/dashboard/getTopCustomer") 
  .then((response) => response.json())
  .then((data) => {
    const tbody = document.getElementById("customerTableBody");
    tbody.innerHTML = ""; // clear existing rows if any

    data.forEach((customer) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${customer.customerName + " "+ customer.customerLastName}</td>
        <td>${customer.branchName}</td>
        <td>${customer.total_reservations}</td>
      `;
      tbody.appendChild(row);
    });
  })
  .catch((error) => {
    console.error("Error fetching data:", error);
  });

// Order Report Modal Functionality
const orderReportModal = document.getElementById("orderReportModal");
const orderReportButton = document.querySelector(".report-btn:first-of-type");
const closeModal = document.querySelector(".close-modal");
let allOrders = [];

// Open modal and load data
orderReportButton.addEventListener("click", function() {
  this.classList.add("loading");
  
  fetch("/admin/reports/orders")
    .then((response) => response.json())
    .then((data) => {
      allOrders = data;
      renderOrderTable(allOrders);
      orderReportModal.style.display = "block";
      
      // Set today's date as default
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('reportDate').value = today;
      
      this.classList.remove("loading");
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
      this.classList.remove("loading");
      alert("Failed to load order report data. Please try again");
    });
});

// Close modal functionality
closeModal.addEventListener("click", function() {
  orderReportModal.style.display = "none";
});

window.addEventListener("click", function(event) {
  if (event.target === orderReportModal) {
    orderReportModal.style.display = "none";
  }
});

// Simple filtering functionality
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