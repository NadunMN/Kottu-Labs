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

  // Fetch order details for the reservation
  fetch(`/payment/getOrderDetails?reservationId=${reservationId}`)
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
              items: Array.isArray(data.items) ? data.items.map(item => `${item.meal_id} x${item.quantity}`).join(', ') : data.items,
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
          console.log("Payment Object:", payment);
          // Initialize PayHere payment
          payhere.startPayment(payment);
      })
      .catch(error => {
          console.error("Error initiating payment:", error);
          alert("Failed to initiate payment. Please try again.");
      });
}