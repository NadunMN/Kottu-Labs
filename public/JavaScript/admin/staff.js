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
    // Handle file upload first if a file is selected
    if (fileInput.files[0]) {
      const uploadData = new FormData();
      uploadData.append("photo", fileInput.files[0]);
      
      const uploadResponse = await fetch("/staff/upload", {
        method: "POST",
        body: uploadData
      });
      
      const { path } = await uploadResponse.json();
      formData.set("photo", path); // Update form data with server path
    }

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
      <td>${staff.firstname} ${staff.lastname}</td>
      <td>${staff.position}</td>
      <td>${staff.branch_name}</td>
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