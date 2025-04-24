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
    // console.log("Total Registrations:", data);
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


  const orderReportModal = document.getElementById("orderReportModal");
  const orderReportButton = document.querySelector(".report-btn:first-of-type");
  const closeModal = document.querySelector(".close-modal");

  orderReportButton.addEventListener("click",function(){
    this.classList.add("loading");

    fetch("/admin/reports/orders")
      .then((response) => response.json())
      .then((data)=>{
        const tbody = document.getElementById("orderReportTableBody");
        tbody.innerHTML = ""; // clear existing rows if any

        let totalSum = 0;

        data.forEach((order)=>{
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${order.order_id}</td>
            <td>${order.order_date}</td>
            <td>${order.customer_name}</td>
            <td>${order.branchName}</td>
            <td>Rs.${order.order_price}</td>
          `;
          tbody.appendChild(row);

          totalSum += Number(order.order_price) || 0;
        });

        const totalRow = document.createElement("tr");
        totalRow.style.fontWeight = "bold";
        totalRow.style.backgroundColor = "rgba(230, 57, 70, 0.1)";
        totalRow.innerHTML = `
          <td colspan="4" style="text-align: right;">Total:</td>
          <td>Rs.${totalSum}</td>
        `;
        tbody.appendChild(totalRow);

        orderReportModal.style.display = "block";
        orderReportButton.classList.remove("loading");
      })
      .catch((error) => {
        console.error("Error fetching data:", error);
        orderReportButton.classList.remove("loading");
        alert("Failed to load order report data. Please try again");
      });
  });

  closeModal.addEventListener("click", function() {
      orderReportModal.style.display = "none";
  });

  window.addEventListener("click", function(event) {
    if (event.target === orderReportModal) {
      orderReportModal.style.display = "none";
    }
  });