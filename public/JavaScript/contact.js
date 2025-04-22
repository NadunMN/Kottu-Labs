const form = document.getElementById('reservationForm');

form.addEventListener('submit', function(e) {
    e.preventDefault();

    const subject = document.getElementById('contactform-subject').value;
    const email = document.getElementById('contactform-email').value;
    const body = document.getElementById('contactform-body').value;

    if (subject && email && body) {
        const formData = new FormData();
        formData.append('subject', subject);
        formData.append('email', email);
        formData.append('body', body);

        fetch('sendmail.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.text();
        })
        .then(data => {
            const thankYouDiv = document.createElement('div');
            thankYouDiv.className = 'thank-you-message';
            thankYouDiv.textContent = 'Thanks for contacting us.';

            const formSection = document.querySelector('.second-part');
            formSection.insertBefore(thankYouDiv, formSection.querySelector('h1').nextSibling);

            form.reset();
            thankYouDiv.scrollIntoView({ behavior: 'smooth' });

            setTimeout(() => {
                if (thankYouDiv.parentNode) {
                    thankYouDiv.parentNode.removeChild(thankYouDiv);
                }
            }, 5000);
        })
        .catch(error => {
            alert('There was an error sending your message. Please try again.');
            console.error(error);
        });
    } else {
        alert('Please fill in all fields.');
    }
});

