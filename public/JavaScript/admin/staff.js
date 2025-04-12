const toggleFormBtn = document.getElementById("toggleFormBtn");
const formContainer = document.getElementById("staffForm");

// Toggle form visibility
toggleFormBtn.addEventListener("click", () => {
  formContainer.classList.toggle("show");
});

// Form submission handler
formContainer.addEventListener("submit", addNewItem);

async function addNewItem(event) {
  event.preventDefault();
  
  const formData = new FormData(formContainer);
  const fileInput = document.getElementById("photo");

  try {
    

    if (fileInput.files[0]) {
      formData.append(
        "photo",
        "/Photo/Staff/" + fileInput.files[0].name
      );
    }

    console.log("Form Data:", Object.fromEntries(formData));

    // Submit staff data
    const response = await fetch("/staff/add", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(Object.fromEntries(formData))
    });

    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
    
    console.log("Success:", await response.json());
    formContainer.classList.remove("show");
    resetForm();
    loadStaffData();
  } catch (error) {
    console.error("Error:", error);
    alert("Error processing request. Please check console for details.");
  }
}

function resetForm() {
  formContainer.reset();
  document.getElementById("photo").value = null;
}

// Staff data management
function loadStaffData() {
  fetch("/staff/data")
    .then(response => {
      if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
      return response.json();
    })
    .then(updateStaffTable)
    .catch(error => {
      console.error("Fetch error:", error);
      document.getElementById("table-content").innerHTML = "Error loading staff data";
    });
}

function updateStaffTable(data) {
  const staffContent = document.getElementById("table-content");
  staffContent.innerHTML = "";

  if (data.error) {
    console.error("Error:", data.error);
    staffContent.innerHTML = "Error loading staff data";
    return;
  }

  if (!data?.length) {
    staffContent.innerHTML = "No Staff available";
    return;
  }

  data.forEach(staff => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${staff.id}</td>
      <td >
        <div class="staff-photo-container" style="width:65px; height:65px; border-radius:50%; overflow:hidden; position:relative;">
        <img src="${staff.photo}" alt="Staff Photo" style="width:100%; height:100%; object-fit:cover;" class="staff-photo">
        </div>
      </td>
      
      <td>${staff.firstname} ${staff.lastname}</td>
      <td>${staff.email}</td>
      <td>${staff.mobile_number}</td>
      <td>
        <div class="staff-created" data-position="${staff.position.toLowerCase()}">
          ${staff.position}
        </div>
      </td>
      <td>${staff.branch_name}</td>
      <td>
        <div class="staff-created" data-position="${staff.position.toLowerCase()}">
          ${staff.created_at}
        </div>
      </td>
      <td>
        <div class="action-buttons">
          <button class="edit-btn" data-staff-id="${staff.id}">Edit</button>
          <button class="delete-btn" data-staff-id="${staff.id}">Delete</button>
        </div>
      </td>
    `;
    staffContent.appendChild(row);
  });
}

// Event delegation for dynamic buttons
document.getElementById("table-content").addEventListener("click", async (event) => {
  
  const staffId = event.target.dataset.staffId;
  
  if (event.target.classList.contains("delete-btn")) {
    
    if (confirm("Are you sure you want to delete this staff member?")) {
      try {
        const response = await fetch("/staff/delete", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id: staffId })
        });
        
        const data = await response.json();
        if (!data.success) throw new Error(data.message);
        
        loadStaffData();
      } catch (error) {
        console.error("Error:", error);
        alert("Delete failed: " + error.message);
      }
    }
  }
  
  if (event.target.classList.contains("edit-btn")) {
    // Add edit functionality here
    console.log("Edit staff member:", staffId);
  }
});

// Initialize
document.addEventListener("DOMContentLoaded", loadStaffData);