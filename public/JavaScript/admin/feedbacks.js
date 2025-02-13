window.addEventListener("load", () => {
    console.log("Page loaded");

    fetch("/feedback/get")
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                console.error("Error:", data.error);
            } else {
                // Get the meal content container
                const mealContent = document.getElementById("main-content");

                if (data == null || data.length === 0) {
                    mealContent.innerHTML = "No Reviews available"; // Show a message if there are no meals
                } else {
                    mealContent.innerHTML = ""; // Clear previous content if data is available
                }

                mealContent.innerHTML = `
                    <div class="view-branch-menu-section">
                        <div class="topic-bar">
                            <div>
                                <h2 style="margin:0;">Customer Reviews</h2>
                                <h5 style="margin:0;">${data.length} review available</h5>
                            </div>
                        </div>
                        <div id="add-item-form" class="add-item-form hidden"></div>
                        <table class="menu-table" id="menu-table">
                            <thead>
                                <tr>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="table-content"></tbody>
                        </table>
                    </div>
                `;

                let reviewId;
                // Dynamically generate review elements
                data.forEach((review) => {
                    // Create a new table row
                    const row = document.createElement("tr");

                    // Populate row HTML
                    row.innerHTML = `
                        <td class="review-id">${review.rating}/5</td>
                        <td class="description-review">${review.review}</td>
                        <td >${review.userName}</td>
                        <td>${review.created_at}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="edit-btn" review-id='${review.review_id}'>Publish</button>
                                <button class="delete-btn" review-id='${review.review_id}'>Delete</button>
                            </div>
                        </td>
                    `;

                    // Append the row directly to the table body
                    document.getElementById("table-content").appendChild(row);
                });

                // Add event listeners to delete buttons
                const deleteButtons = document.querySelectorAll(".delete-btn");
                deleteButtons.forEach((button) => {
                    button.addEventListener("click", () => {
                        if (confirm("Are you sure you want to delete this review? This action cannot be undone.")) {
                            const reviewId = button.getAttribute("review-id");

                            const requestBody = JSON.stringify({ review_id: reviewId });
                            console.log("Request Body:", requestBody);

                            fetch("/feedback/delete", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                body: requestBody,
                            })
                                .then((response) => response.json())
                                .then((data) => {
                                    if (data.success) {
                                        alert("The review has been deleted.");
                                        button.closest("tr").remove();
                                    } else {
                                        alert("There was an error deleting the review: " + data.message);
                                        console.error("Error:", data.message);
                                    }
                                })
                                .catch((error) => console.error("Error:", error));
                        }
                    });
                });
            }
        })
        .catch((error) => {
            console.error("Error fetching review:", error);
        });
});
