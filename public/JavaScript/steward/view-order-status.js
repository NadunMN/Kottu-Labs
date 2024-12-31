document.addEventListener("DOMContentLoaded", () => {
  // Sample data array
  const orderStatusData = [
      { orderId: "097", name: "Thirani Imanya", order: "Prawns Dolphin Kottu", tableNo: "04", status: "Ready" },
      { orderId: "101", name: "Nadun Madushabka", order: "Sea Food Kottu", tableNo: "02", status: "Ready" },
      { orderId: "097", name: "Amal Perera", order: "Chicken Cheese Kottu", tableNo: "04", status: "Processing" },
      { orderId: "102", name: "Abdul Raheem", order: "Mutton String Hopper Kottu", tableNo: "03", status: "Processing" },
      { orderId: "102", name: "Kevin Silva", order: "Redbull", tableNo: "03", status: "Processing" }
  ];

  const mainContent = document.getElementById("main-content");

  // Render order status content
  function renderOrderStatus() {
      mainContent.innerHTML = `
          <div class="view-users-section">
              <h2>Order Status</h2>
              <div class="filter-section">
                  <input type="text" id="tableFilter" placeholder="Filter by Table No...">
                  <button onclick="filterOrders()">Filter</button>
                  <button onclick="resetFilter()">Reset</button>
              </div>
              <table>
                  <thead>
                      <tr>
                          <th>Order ID</th>
                          <th>Name</th>
                          <th>Order</th>
                          <th>Table No.</th>
                          <th>Status</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody id="order-status-body">
                  </tbody>
              </table>
          </div>`;

      populateOrderTable();
  }

  // Populate order status table
  function populateOrderTable() {
      const orderStatusBody = document.getElementById("order-status-body");
      orderStatusBody.innerHTML = ''; // Clear existing content

      orderStatusData.forEach(order => {
          const row = document.createElement("tr");
          const statusColor = order.status === "Ready" ? "green" : "red";
          row.innerHTML = `
              <td>${order.orderId}</td>
              <td>${order.name}</td>
              <td>${order.order}</td>
              <td>${order.tableNo}</td>
              <td style="color: ${statusColor};">${order.status}</td>
              <td>
                  ${order.status === "Ready" ? '<button class="done-btn">Done</button>' : ''}
              </td>
          `;
          orderStatusBody.appendChild(row);
      });
  }

  // Filter orders by table number
  window.filterOrders = function() {
      const filterValue = document.getElementById("tableFilter").value;
      const filteredOrders = orderStatusData.filter(order => 
          order.tableNo.includes(filterValue)
      );
      
      const orderStatusBody = document.getElementById("order-status-body");
      orderStatusBody.innerHTML = '';
      
      filteredOrders.forEach(order => {
          const row = document.createElement("tr");
          const statusColor = order.status === "Ready" ? "green" : "red";
          row.innerHTML = `
              <td>${order.orderId}</td>
              <td>${order.name}</td>
              <td>${order.order}</td>
              <td>${order.tableNo}</td>
              <td style="color: ${statusColor};">${order.status}</td>
              <td>
                  ${order.status === "Ready" ? '<button class="done-btn">Done</button>' : ''}
              </td>
          `;
          orderStatusBody.appendChild(row);
      });
  };

  // Reset filter
  window.resetFilter = function() {
      document.getElementById("tableFilter").value = '';
      populateOrderTable();
  };

  // Initial render
  renderOrderStatus();
});