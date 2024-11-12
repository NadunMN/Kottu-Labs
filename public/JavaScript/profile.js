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
    
                // Display user data in the frontend
                document.getElementById('fname').placeholder = data.firstname;
                document.getElementById('lname').placeholder = data.lastname;
                document.getElementById('phone').placeholder = data.mobile_number;
                document.getElementById('email').placeholder = data.email;
    
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
        
