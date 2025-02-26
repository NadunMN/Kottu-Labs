document.addEventListener("DOMContentLoaded", function () {
    const reservationForm = document.getElementById('reservationForm');
    const dateInput = document.getElementById('reservation-date');
    const randomNumber = Math.floor(Math.random() * 900000) + 100000;

    let userId;  // Declare userId for later use

    // Set date range for the reservation date
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
                userId = data.id;  // Store user ID
                console.log('User:', userId);
            }
        })
        .catch(error => console.error('Error fetching user data:', error));

    // Single submit event listener
    reservationForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission
    
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        data.user_id = userId;  // Add user ID to the form data
        data.confirmation_number = randomNumber;  // Add confirmation number to the form data
        data.type = 'dinein';  // Add reservation type to the form data
        const requestBody = JSON.stringify(data);
    
        console.log('Request Body:', requestBody);  // Log the request body for debugging
        localStorage.setItem('reservationData', requestBody);  // Store reservation data in local storage
    
        // Change form action
        reservationForm.action = `/reservationNumber?random=${randomNumber}`;
        
        // Submit the form programmatically after ensuring action is set
        setTimeout(() => {
            reservationForm.submit(); 
        }, 100); // Add a slight delay to ensure `action` is set
    
        // Redirect only **after** form submission is processed
        setTimeout(() => {
            window.location.href = '/confirmreservation';
        }, 500);
    });
    
});
