// Function to show the card payment section
function showCardPayment() {
  document.getElementById('cash-payment').classList.add('hidden');
  initiatePayHerePayment();
}

// Function to show the cash payment section
function showCashPayment() {
  document.getElementById('cash-payment').classList.remove('hidden');
}

// Function to get query parameters from the URL
function getQueryParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(param);
}

// Get the reservationId from the URL
const reservationId = getQueryParam('reservationId');
console.log("Reservation ID:", reservationId);
// Function to initiate PayHere payment
function initiatePayHerePayment() {
  if (!reservationId) {
      alert("Reservation ID is missing!");
      return;
  }

  let orderIdM; // Use the reservation ID as the order ID

  // Fetch order details for the reservation
  fetch(`/payment/getPaymentDetails?reservationId=${reservationId}`)
      .then(response => response.json())
      .then(data => {
          if (data.error) {
              alert(data.error);
              return;
          }
          console.log("Order details:", data);

          // PayHere payment configuration
          const payment = {
              sandbox: true, // Set to false for production
              merchant_id: data.merchant_id,
              return_url: data.return_url,
              cancel_url: data.cancel_url,
              notify_url: data.notify_url,
              order_id: data.order_id,
              items: Array.isArray(data.items) ? data.items.map(item => `${item.meal_name} x ${item.quantity}`).join(', ') : data.items,
              amount: data.amount,
              currency: data.currency,
              first_name: data.first_name,
              last_name: data.last_name,
              email: data.email,
              phone: data.phone,
              address: data.address,
              city: data.city,
              country: data.country,
              hash: data.hash,
          };


          payhere.onCompleted = function onCompleted(orderId) {
              console.log("Payment completed:", orderId);
              orderIdM = orderId; // Store the order ID for later use
              alert("Payment completed successfully!");
              // Redirect to success page or perform any other action

                          // Make an API call to update the payment status in the database
            fetch('/payment/confirm', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
              },
              body: JSON.stringify({
                  payment_id: orderId, // Use the correct payment_id
                  payment_status: 2,  // Status 2 indicates success
                  payment_type: 'card', // Payment type (e.g., 'card', 'cash')
              }),
          })
          .then(response => response.json())
          .then(result => {
              if (result.success) {
                  alert("Payment status updated successfully!");
              } else {
                  alert("Failed to update payment status.");
              }
          })
          .catch(error => {
              console.error("Error updating payment status:", error);
              alert("An error occurred while updating payment status.");
          });
          };
          // Initialize PayHere payment
          payhere.startPayment(payment);
      })
      .catch(error => {
          console.error("Error initiating payment:", error);
          alert("Failed to initiate payment. Please try again.");
      });

    


    }


    function continuePayment() {
        // Use reservationId from the URL instead of orderIdM
        console.log("Reservation ID:", reservationId);
    
        // Make an API call to update the payment status in the database
        fetch('/payment/confirm', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                payment_id:12 , // Use reservationId instead of orderIdM
                payment_status: 0,        // Status 0 indicates pending/awaiting cash payment
                payment_type: 'cash',
            }),
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert("Cash payment recorded successfully!");
                // Redirect or update UI as needed
            } else {
                alert("Failed to record cash payment.");
            }
        })
        .catch(error => {
            console.error("Error updating payment status:", error);
            alert("An error occurred. Please try again.");
        });
    }