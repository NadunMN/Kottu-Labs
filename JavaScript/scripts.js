document.getElementById('reservationForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;

    if (name && email && message) {
        alert('Thank you for your message!');
        document.getElementById('reservationForm').reset();
    } else {
        alert('Please fill in all fields.');
    }
});
