const wattalaValue = document.getElementById("value-wattala");
const kotahenaValue = document.getElementById("value-kotahena");
const kelaniyaValue = document.getElementById("value-kelaniya");
const registrations = document.getElementById("registrations");

// Set current date in the header
document.addEventListener('DOMContentLoaded', function() {
    const currentDateElement = document.getElementById('current-date');
    if (currentDateElement) {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const currentDate = new Date().toLocaleDateString('en-US', options);
        currentDateElement.textContent = currentDate;
    }
});

// Fetch branch profit data
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

// Fetch registrations count
fetch("/dashboard/getRegistrationsCount")
  .then((response) => response.json())
  .then((data) => {
    const totalRegistrations = data[0].user_count;
    registrations.innerHTML = `${totalRegistrations}`;
  })
  .catch((error) => {
    console.error("Error fetching data:", error);
  });

// Fetch top customers
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

// Event listeners for report buttons
document.addEventListener('DOMContentLoaded', function() {
    // Get Orders Report button
    const orderReportButton = document.querySelector(".report-btn:first-of-type");
    if (orderReportButton) {
        orderReportButton.addEventListener('click', function() {
            window.location.href = '/orderReport';
        });
    }
    
    // Get Meals Report button
    const mealReportButton = document.querySelector(".report-btn:nth-of-type(2)");
    if (mealReportButton) {
        mealReportButton.addEventListener('click', function() {
            window.location.href = '/mealReport';
        });
    }
});