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



