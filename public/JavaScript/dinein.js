document.addEventListener("DOMContentLoaded", function() {
    const dateInput = document.getElementById('reservation-date');
    const today = new Date();
    const oneMonthLater = new Date();
    oneMonthLater.setMonth(today.getMonth() + 1);

    const formatDate = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    dateInput.setAttribute('min', formatDate(today));
    dateInput.setAttribute('max', formatDate(oneMonthLater));

    let userId; // Declare userId in a scope accessible to both fetch and submit event listener

    // Fetch user data from the backend
    fetch('/user/data')
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.error) {
            console.error(data.error);
        } else {
            // Store user ID
            userId = data.id;
            console.log('User:', userId);
        }
    })
    .catch(error => console.error('Error fetching user data:', error));

    document.getElementById('reservationForm').addEventListener("submit", function(event) {
        event.preventDefault();
      
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        data.user_id = userId;
        const requestBody = JSON.stringify(data);
        console.log('Request Body:', requestBody); 
      
        fetch("/reservation/add", {
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