let userId;
let reviewId;

// Fetch user data from the backend
// Fetch reviews from the server
function fetchReviews() {
fetch('/review/data')
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error('Error:', data.error);
        } else {
            // Get the reviews content container
            const reviewsContent = document.getElementById('reviewsContent');

            if (data == null || data.length === 0) {
                reviewsContent.innerHTML = 'No reviews available'; 
            } else {
                reviewsContent.innerHTML = ''; // Clear previous content if data is available
            }

            // Sort the reviews by date (newest first)
            data.sort((a, b) => {
                return new Date(b.created_at) - new Date(a.created_at);
            });

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
                            <button class="edit-icon" review-id ='${review.review_id}'></button>
                            <button class="delete-icon" review-id ='${review.review_id}' ></button>
                            
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

                reviewId= review.review_id;

                // Append review to the container
                reviewsContent.appendChild(reviewDiv);
            });

            // Add event listeners for delete buttons after reviews are generated
            document.querySelectorAll('.delete-icon').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this review? This action cannot be undone.')) {
                        const reviewId = button.getAttribute('review-id');
                        const requestBody = JSON.stringify({ review_id: reviewId });
                        console.log('Request Body:', requestBody);

                        fetch('/review/delete', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: requestBody
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('The review has been deleted.');
                                fetchReviews(); // Refresh the reviews
                            } else {
                                alert('There was an error deleting the review: ' + data.message);
                                console.error('Error:', data.message);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                });
            });




            // Add event listeners for edit buttons after reviews are generated
            document.querySelectorAll('.edit-icon').forEach(button => {
                button.addEventListener('click', function() {

                    const newdiv = document.querySelector('.review-body');
                    newdiv.classList.add('.review-body-new');

                    const reviewDiv = button.closest('.review');
                    const reviewElement = button.closest('.review-header').nextElementSibling; // Get the corresponding review-body
                    const reviewTextElement = reviewElement.querySelector('p'); // Select the paragraph element with the review text
                    const oldText = reviewTextElement.innerText; // Get the current review text
            
                    // Prevent multiple text areas
                    if (reviewElement.querySelector('textarea')) return;

                    // Create message div
                    const messageDiv = document.createElement('div');
                    messageDiv.style.color = 'green';
                    messageDiv.style.marginTop = '10px';
                    messageDiv.style.display = 'none';

                    // Add message div before the review element
                    reviewElement.insertBefore(messageDiv, reviewElement.firstChild);
                    
                    // Create a textarea and pre-fill it with the old text
                    const textArea = document.createElement('textarea');
                    textArea.value = oldText;
                    textArea.classList.add('edit-textarea');

                    // Create a div to hold the buttons
                    const buttonContainer = document.createElement('div');
                    buttonContainer.classList.add('button-container');

                    // Create Save and Cancel buttons
                    const saveButton = document.createElement('button');
                    saveButton.innerText = 'Save';
                    saveButton.classList.add('save-button');
            
                    const cancelButton = document.createElement('button');
                    cancelButton.innerText = 'Cancel';
                    cancelButton.classList.add('cancel-button');

                    // Append the buttons to the div
                    buttonContainer.appendChild(saveButton);
                    buttonContainer.appendChild(cancelButton);
            
                    // Hide the original text and add the textarea and buttons
                    reviewTextElement.style.display = 'none';
                    reviewElement.appendChild(textArea);
                    reviewElement.appendChild(buttonContainer);
                    reviewElement.appendChild(messageDiv);
            
                    // Save button functionality
                    saveButton.addEventListener('click', () => {
                        const newText = textArea.value;
                        const reviewId = button.getAttribute('review-id'); // Retrieve review ID
                        console.log('Review ID:', reviewId);
                        console.log('New Text:', newText);
            
                        fetch('/review/update', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ review_id: reviewId, review: newText })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                reviewTextElement.innerText = newText;
                                messageDiv.textContent = 'Saved!';
                                messageDiv.style.display = 'block';

                                // Hide buttons immediately
                                textArea.remove();
                                buttonContainer.remove();
                                reviewTextElement.style.display = '';
                                
                                // Hide message after 1.5 seconds and clean up
                                setTimeout(() => {
                                    messageDiv.style.display = 'none';
                                    messageDiv.remove();
                                    newdiv.classList.remove('.review-body-new');
                                }, 3000);
                            } else {
                                messageDiv.style.color = 'red';
                                messageDiv.textContent = 'Error updating the review: ' + data.message;
                                messageDiv.style.display = 'block';
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    });
            
                    // Cancel button functionality
                    cancelButton.addEventListener('click', cleanUp);
            
                    // Cleanup function to restore original view
                    function cleanUp() {
                        textArea.remove();
                        saveButton.remove();
                        cancelButton.remove();
                        reviewTextElement.style.display = ''; // Show original text
                        newdiv.classList.remove('.review-body-new');
                    }
                });
            });
            
            
        }

        
    })
    .catch(error => console.error('Error fetching reviews:', error));
}
// Function to render stars based on rating
function renderStars(rating) {
    const maxStars = 5;
    let starsHTML = '';

    for (let i = 0; i < maxStars; i++) {
        if (i < Math.floor(rating)) {
            starsHTML += "<div class='review-rate-start' style='background-image: url(/Photo/icon/star_gold.png);'></div>";
        } else {
            starsHTML += "<div class='review-rate-start' style='background-image: url(/Photo/icon/star.png);'></div>";
        }
    }

    return starsHTML;
}


document.addEventListener('DOMContentLoaded', (event) => {

    // Call fetchReviews when page loads
    fetchReviews();

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
  
    let errorDiv = document.getElementById('rating-error');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.id = 'rating-error';
        errorDiv.style.color = 'red';
        errorDiv.style.marginBottom = '10px';
        // Insert error div before the form
        this.insertBefore(errorDiv, this.firstChild);
    }
    const reviewText = this.querySelector('textarea[name="review"]').value.trim();


    if (userId === undefined) {
        console.error('User ID is not set.');
        errorDiv.textContent = 'Please log in to submit a review.';
        return;
    }

    if (rating === 0) {
        console.error('Rating is not selected.');
        errorDiv.textContent = 'Please select a rating before submitting.';
        return;
    }
    if (!reviewText) {
        console.error('Review text is empty.');
        errorDiv.textContent = 'Please write a review before submitting.';
        return;
    }

    // Clear error message if validation passes
    errorDiv.textContent = '';

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
            errorDiv.style.color = 'green';
            errorDiv.textContent = 'Review submitted successfully!';

            this.querySelector('textarea[name="review"]').value = '';

            selectedIndex = -1;
            rating = 0;
            boxes.forEach(b => b.classList.remove("hover"));

            fetchReviews();

            setTimeout(() => {
                errorDiv.textContent = '';
            }, 1500);
        })
        .catch(error => {
            console.error("Error:", error);
            errorDiv.style.color = 'red';
            errorDiv.textContent = 'Error submitting review. Please try again.';
        });
    
  });

  
});





