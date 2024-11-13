    // Get the current path
    const currentPath = window.location.pathname;
    
    // Select the button element
    const button = document.getElementById("view-profile");

    // Check the current path and update the button accordingly
    if (currentPath === '/profile') {
      button.textContent = "View Profile";
      button.onclick = () => { window.location.href = '/myaccount'; };
    } else if (currentPath === '/myaccount') {
      button.textContent = "View Dashboard";
      button.onclick = () => { window.location.href = '/profile'; };
    }



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
                console.log('User:', data);
                // Display user data in the frontend
                document.getElementById('fname').value = data.firstname;
                document.getElementById('lname').value = data.lastname;
                document.getElementById('phone').value = data.mobile_number;
                document.getElementById('email').value = data.email;
                document.getElementById('address').value = data.address;
            }
        })
        .catch(error => console.error('Error fetching user data:', error));
    
        
// Delete button event listener
document.getElementById('delete').addEventListener('click', function() {
    if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
        const requestBody = JSON.stringify({ id: userId });
        console.log('Request Body:', requestBody); // Log the request body

        fetch('/user/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: requestBody // Use the stored user ID here
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Your account has been deleted.');
                window.location.href = '/';
            } else {
                alert('There was an error deleting your account: ' + data.message);
                console.error('Error:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
});

document.getElementById('update-form').addEventListener("submit", function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    data.id = userId; // Add user ID to the data
    const requestBody = JSON.stringify(data);
    console.log('Request Body:', requestBody); 

    fetch('/user/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: requestBody 
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Your details have been updated.');
        } else {
            alert('There was an error updating your details: ' + data.message);
            console.error('Error:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
        
