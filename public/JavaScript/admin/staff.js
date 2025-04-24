//staff.js

const toggleFormBtn = document.getElementById("toggleFormBtn");
const formContainer = document.getElementById("staffForm");

// Toggle form visibility
toggleFormBtn.addEventListener("click", () => {
  formContainer.classList.toggle("show");
  resetForm();
  formContainer.removeAttribute("data-staff-id");
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

    if (!response.ok) throw new Error("HTTP error! status: ${response.status}");
    
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
      if (!response.ok) throw new Error("HTTP error! status: ${response.status}");
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
    // Define formContainer
    const formContainer = document.getElementById("staffForm");
    fetch(`/user/data/staff?id=${staffId}`)
        .then(response => {
            if (!response.ok) throw new Error(data.error);
            return response.json();
            })
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
                alert("Error loading staff data for edit");
                return;
            }
            
            formContainer.classList.add("show");

            formContainer.elements["firstname"].value = data.firstname;
            formContainer.elements["lastname"].value = data.lastname;
            formContainer.elements["email"].value = data.email;
            formContainer.elements["mobile_number"].value = data.mobile_number;
            formContainer.elements["address"].value = data.address;
            formContainer.elements["password"].value = data.password;
            formContainer.elements["confirmPassword"].value = data.confirmPassword;
            formContainer.elements["photo"].value = data.photo || null;
            if (data.date_of_birth) {
              try {
                // Convert from database format to yyyy-mm-dd if needed
                const dateObj = new Date(data.date_of_birth);
                if (!isNaN(dateObj.getTime())) { // Check if it's a valid date
                  const formattedDate = dateObj.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                  formContainer.elements["date_of_birth"].value = formattedDate;
                  console.log("Set date to:", formattedDate); // Debug
                } else {
                  console.warn("Invalid date:", data.date_of_birth);
                }
              } catch (e) {
                console.error("Error formatting date:", e);
              }
            }
            if (data.branch_id) {
              formContainer.elements["branch_id"].value = data.branch_id;
            } else if (data.branch_name) {
              // Handle branch by name if needed
              const branchSelect = formContainer.elements["branch_id"];
              for (let i = 0; i < branchSelect.options.length; i++) {
                if (branchSelect.options[i].textContent.toLowerCase() === data.branch_name.toLowerCase()) {
                  branchSelect.selectedIndex = i;
                  break;
                }
              }
            }

            if (data.gender) {
              console.log('Selected gender:', data.gender);  // Debugging
              const genderRadios = formContainer.elements["gender"];
              for (let i = 0; i < genderRadios.length; i++) {
                if (genderRadios[i].value === data.gender) {
                  genderRadios[i].checked = true;
                  break;
                }
              }
            } else {
              console.log('No gender data available.');
            }

            function capitalize(str) {
              return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
            }
            
            if (data.position) {
              formContainer.elements["position"].value = capitalize(data.position);
            }
            
            if (data.nationality) {
              formContainer.elements["nationality"].value = data.nationality || "";
            }

            const genderMap = {
              male: "male",
              female: "female",
              other: "other"
            };
            
            if (data.gender) {
              const genderRadios = formContainer.elements["gender"];
              for (let i = 0; i < genderRadios.length; i++) {
                if (genderRadios[i].value === data.gender) {
                  genderRadios[i].checked = true;
                  break;
                }
              }
            }
            
            // Pre-select position
            if (data.position) {
              const positionSelect = formContainer.elements["position"];
              positionSelect.value = data.position || "";
            }
            
            formContainer.addEventListener("submit", function(event) {
              event.preventDefault();
                
              const formData = {};
              
              Array.from(formContainer.elements).forEach(element => {
                if (element.name && element.name !== "" && element.type !== "file") {
                    // For radio buttons, only include checked ones
                    if (element.type === "radio") {
                        if (element.checked) {
                            formData[element.name] = element.value;
                        }
                    } 
                    // For other elements (except files and submit)
                    else if (element.type !== "submit") {
                        formData[element.name] = element.value;
                    }
                }
              });

              // Explicitly set photo to null to avoid sending an array
              formData.photo = null;
              
              // Add staff ID
              formData.id = staffId;
  
              fetch("/staff/update", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(formData)
              })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      alert("Staff member updated successfully!");
                      loadStaffData();
                      formContainer.classList.remove("show");
                      resetForm();
                  } else {
                      alert("Error updating staff member: " + (data.message || "Unknown error"));
                  }
              })
              .catch(error => {
                console.error("Error:", error);
                alert("Error processing request. Please check console for details.");
               });
            
              }
              
            );

            

        });


    console.log("Edit staff member:", staffId);
  }
});

// Initialize
document.addEventListener("DOMContentLoaded", loadStaffData);