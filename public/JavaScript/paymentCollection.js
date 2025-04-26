    const paymentTotal = document.getElementById('payment-total');
    const paymentDescription = document.querySelector('.payment-description');
    const paymentForm = document.querySelector('.payment-form');

    let userId;

    // Get the current URL's query parameters
    const urlParams = new URLSearchParams(window.location.search);

    // Retrieve the `id` parameter (or any other parameter)
    const reservationNo = urlParams.get('reservationNo');

    console.log("Reservation No:", reservationNo); // Log the reservation number for debugging
    
    localStorage.setItem('reservationNo', reservationNo); // Store the reservation number in local storage
    // console.log("Temp ID:", reservationNo); // Log the temp_id for debugging

    fetch('/user/data')
    .then(response => response.json())
    .then(data => {
        // Assuming the user ID is in the first object of the array
        userId = data.id; // Store the user ID for later use
        console.log("User ID:", userId); // Log the user ID for debugging

        // You can now use `userId` in your code as needed
    })
    .catch(error => {
        console.error('Error fetching user data:', error); // Log any errors for debugging
    })


    fetch(`/getpaymet/data?reservationNo=${reservationNo}`)
    .then(response => response.json())
    .then(data => {
        // Calculate total price
        const totalPrice = data.reduce((sum, payment) => {
            return sum + parseFloat(payment.meal_price*payment.quantity);
        }, 0);

        // Format to 2 decimal places
        const formattedTotal = totalPrice.toFixed(2);
        
        // Display in your HTML element (replace 'totalAmount' with your element's ID)
        paymentTotal.textContent = `Rs.${formattedTotal}`;

        // Map payment descriptions into meal name - quantity - price
        const paymentDescriptions = data.map(payment => {
            return `${payment.meal_name}-${payment.quantity} , Rs.${(payment.meal_price * payment.quantity).toFixed(2)}`;
        });

        console.log("Payment Descriptions:", paymentDescriptions); // Log the payment descriptions for debugging

        paymentDescription.innerHTML = ''; // Clear previous content

        // Join descriptions with line breaks and display in the payment description element
        paymentDescription.innerHTML = paymentDescriptions.join('<br>');


    })
    .catch(error => {
        console.error('Error fetching payment data:', error);
    });

    



function selectMethod(method) {
    // Remove selected class from all options
    document.querySelectorAll('.method-option').forEach(option => {
      option.classList.remove('selected');
    });
    
    // Add selected class to clicked option
    document.getElementById(method + '-option').classList.add('selected');
    
    // Update form data-method attribute
    document.querySelector('.payment-form').setAttribute('data-method', method);
    
    // Update button text
    const payButton = document.getElementById('pay-button');
    if (method === 'card') {
      payButton.textContent = 'Pay Now';
    } else {
      payButton.textContent = 'Confirm Cash Payment';
    }
  }
  
  // Initialize with card selected
  window.onload = function() {
    selectMethod('card');
  };


    // Add event listener to the form submission
    document.getElementById('pay-button').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get the selected payment method
        const method = paymentForm.getAttribute('data-method');

        // Prepare data to send to the server
        const data = {
            method: method,
            reservationNo: reservationNo,
            stewardId: userId // Include the user ID in the data
        };

        console.log("Data to send:", data); // Log the data for debugging

        // Send data to the server using fetch
        fetch('/payment/confirm/steward', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            console.log("Server response:", result); // Log the server response for debugging

            if (result.success) {
                alert('Payment successful!'); // Show success message
                window.location.href = '/'; // Redirect to home page or any other page
            } else {
                alert('Payment failed. Please try again.'); // Show error message
            }
        })
        .catch(error => {
            console.error('Error during payment:', error); // Log any errors for debugging
            alert('An error occurred. Please try again later.'); // Show error message
        });
    });