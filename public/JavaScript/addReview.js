
let userId;

// Fetch user data from the backend
// Fetch reviews from the server
fetch('/review/data')
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error('Error:', data.error);
        } else {
            // Assume user ID from the first review
            const userId = data[0]?.user_id || 'Unknown User';
            console.log('User:', userId);
            console.log('Reviews:', data);

            // Get the reviews content container
            const reviewsContent = document.getElementById('reviewsContent');

            if (data == null || data.length === 0) {
                reviewsContent.innerHTML = 'No reviews available'; // Show a message if there are no reviews
            } else {
                reviewsContent.innerHTML = ''; // Clear previous content if data is available
            }
            

            // Dynamically generate review elements
            data.forEach(review => {
                // Create review container
                const reviewDiv = document.createElement('div');
                reviewDiv.className = 'review';

                // Populate review HTML
                reviewDiv.innerHTML = `
                    <div class="review-header">
                        <div class="review-name">
                            <div></div>
                            <h4 id="name">${review.userName || 'Anonymous'}</h4>
                            <h6 id="date">${review.created_at.substring(0,10) || 'Date not available'}</h6>
                        </div>
                        <div class="review-rate">
                            <h5>${review.rating || '0.0'}.0</h5>
                            <div class="starts">
                                ${renderStars(review.rating || 0)}
                            </div>
                        </div>
                    </div>
                    <div class="review-body">
                        <p>${review.review || 'No review content available.'}</p>
                    </div>
                `;

                // Append review to the container
                reviewsContent.appendChild(reviewDiv);
            });
        }
    })
    .catch(error => console.error('Error fetching reviews:', error));

// Function to render stars based on rating
function renderStars(rating) {
    const maxStars = 5;
    let starsHTML = '';

    for (let i = 0; i < maxStars; i++) {
        if (i < Math.floor(rating)) {
            starsHTML += "<div class='review-rate-start style='background-image: url(/Photo/icon/star_gold.png);'></div>";
        } else {
            starsHTML += "<div class='review-rate-start style='background-image: url(/Photo/icon/star_gold.png);'></div>";
        }
    }

    return starsHTML;
}



































    



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


