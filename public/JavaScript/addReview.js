const boxes = document.querySelectorAll(".box");

boxes.forEach((box, index) => {
  box.addEventListener("mouseover", () => {
    for (let i = 0; i <= index; i++) {
      boxes[i].classList.add("hover");
    }
  });

  box.addEventListener("mouseout", () => {
    boxes.forEach((b) => b.classList.remove("hover"));
  });
});
