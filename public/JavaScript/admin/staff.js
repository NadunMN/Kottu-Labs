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
  .then((response) => {
    if (!response.ok) {  // Check for HTTP errors
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  })
  .then((data) => {
    const staffContent = document.getElementById("table-content");
    staffContent.innerHTML = ""; // Clear content initially

    if (data.error) {
      console.error("Error:", data.error);
      staffContent.innerHTML = "Error loading staff data";
      return;
    }

    if (!data || data.length === 0) {
      staffContent.innerHTML = "No Staff available";
      return;
    }

    data.forEach((staff) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${staff.id}</td>
        <td>${staff.firstname+ " "+ staff.lastname }</td>
        <td>${staff.position}</td>
        <td>${staff.branch_name}</td>
        <td>
          <div class="action-buttons">
            <button class="edit-btn" data-staff-id="${staff.staff_id}">Edit</button>
            <button class="delete-btn" data-staff-id="${staff.staff_id}">Delete</button>
          </div>
        </td>
      `;
      staffContent.appendChild(row);
    });
  })
  .catch((error) => {
    console.error("Fetch error:", error);
    document.getElementById("table-content").innerHTML = "Error loading staff data";
  });


});
