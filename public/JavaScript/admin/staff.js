const toggleFormBtn = document.getElementById("toggleFormBtn");
const formContainer = document.getElementById("staffForm"); // This should be your <form> element

toggleFormBtn.addEventListener("click", () => {
  formContainer.classList.toggle("show");
});

formContainer.addEventListener("submit", addNewItem);

function addNewItem(event) {
  event.preventDefault();

  const fileInput = document.getElementById("photo");
  const formData = new FormData(formContainer); // Use the form directly

  if (fileInput.files[0]) {
    formData.append(
      "photo",
      "/Photo/Staff/" + fileInput.files[0].name
    );
  }

  const data = Object.fromEntries(formData.entries());

  const requestBody = JSON.stringify(data);
  console.log("Request Body:", data);

  fetch("/staff/add", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: requestBody,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      console.log("Success:", data);
      formContainer.classList.remove("show");
      resetForm();
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function resetForm() {
  formContainer.reset();
  document.getElementById("photo").value = null;
}













document.addEventListener("DOMContentLoaded", () => {

  fetch("/staff/data")
  .then((response) => response.json())
  .then((data) => {
    if (data.error) {
      console.error("Error:", data.error);
    } else {
      // Get the meal content container
      const staffContent = document.getElementById("table-content");

      if (data == null || data.length === 0) {
        staffContent.innerHTML = "No meals available"; // Show a message if there are no meals
      } else {
        staffContent.innerHTML = ""; // Clear previous content if data is available
      }

      staffContent.innerHTML = ` `;

      // Dynamically generate meal elements
      data.forEach((staff) => {
        // console.log(meal.branch_ids);
        // Create a new table row
        const row = document.createElement("tr");

        // Populate row HTML
        row.innerHTML = `
                                        <td class="meal-id" >${staff.meal_id}</td>
                                        <td>${staff.meal_name}</td>
                                        <td meal-description= '${staff.staff_description}'>${staff.staff_description} </td>
                                        <td>Rs.${staff.staff_price}</td>
                                        <td>${
                                          staff.branch_ids == "1" ? "Wattala" : staff.branch_ids == "2" ? "Kelaniya" : staff.branch_ids== "3" ? "Kotahena"
                                          : staff.branch_ids == '1,2' ? "Wattala, Kelaniya" : staff.branch_ids == '1,3' ? "Wattala, Kotahena" : staff.branch_ids == '2,3' ? "Kelaniya, Kotahena" : "All Branches"
                                          }</td>
                                        
                                        <td>
                                            

                                            <div class="action-buttons">
                                                <button class="edit-btn" staff-id='${staff.staff_id}'>Edit</button>
                                                <button class="delete-btn" staff-id ='${staff.staff_id}'>Delete</button>
                                            </div>
                                        </td>
                                    `;

        // Append the row directly to the table body
        document.getElementById("table-content").appendChild(row);
      });
    
    }

       });


});
