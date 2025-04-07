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
