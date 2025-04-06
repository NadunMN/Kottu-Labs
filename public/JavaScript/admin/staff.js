const toggleFormBtn = document.getElementById("toggleFormBtn");
const formContainer = document.getElementById("staffForm");

toggleFormBtn.addEventListener("click", () => {
  formContainer.classList.toggle("show");
  toggleFormBtn.classList.toggle("show");
});
