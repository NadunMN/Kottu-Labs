document.addEventListener('DOMContentLoaded', (event) => {
  const boxes = document.querySelectorAll(".box");
  let selectedIndex = -1;
  let rating =0;
  let userId;

  // Fetch user data from the backend
  fetch('/user/data')
  .then(response => response.json())
  .then(data => {
      if (data.error) {
          console.error(data.error);
      } else {
          // Store user ID
          userId = data.id;
        //   console.log('User:', data);
      }
  })
  .catch(error => console.error('Error fetching user data:', error));


  boxes.forEach((box, index) => {
      box.addEventListener("mouseover", () => {
          for (let i = 0; i <= index; i++) {
              boxes[i].classList.add("hover");
          }
      });

      box.addEventListener("mouseout", () => {
          if (selectedIndex === -1) {
              boxes.forEach((b) => b.classList.remove("hover"));
          } else {
              boxes.forEach((b, i) => {
                  if (i > selectedIndex) b.classList.remove("hover");
              });
          }
      });

      box.addEventListener("click", () => {
          selectedIndex = index;
          rating = selectedIndex + 1;
          console.log(selectRate);
          boxes.forEach((b, i) => {
              if (i <= selectedIndex) {
                  b.classList.add("hover");
              } else {
                  b.classList.remove("hover");
              }
          });
      });

      box.addEventListener("dblclick", () => {
          selectedIndex = -1;
          boxes.forEach((b) => b.classList.remove("hover"));
      });
  });


  document.getElementById('add-form').addEventListener("submit", function(event) {
    event.preventDefault();
  
    if (userId === undefined) {
      console.error('User ID is not set.');
      return;
    }

    if (rating === 0) {
      console.error('Rating is not selected.');
      return;
    }

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    data.rating = rating; // Add selectRate to the form data
    data.user_id = userId; // Add user ID to the form data
    const requestBody = JSON.stringify(data);
    console.log('Request Body:', requestBody); 
  
    fetch("review/add", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: requestBody,
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Success:", data);
        })
        .catch(error => {
            console.error("Error:", error);
        });
    
  });

  
});


