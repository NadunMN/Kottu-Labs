document.addEventListener("DOMContentLoaded", function() 
{
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
});

/*document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("reservationForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Generate a random reservation number
        const reservationNumber = Math.floor(Math.random() * 1000000) + 1;

        // Display the reservation number in a popup message
        alert(`Your reservation number is: ${reservationNumber}`);

        // Display the success message after the first popup is closed
        alert('Reservation successfully completed. Enjoy dining');
    });
});*/
