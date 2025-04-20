const takeAway = document.getElementById("notification-takeawaycart");

// Fetch takeaway cart data
fetch('/gettakeawayCartData?userId=1')
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      takeAway.innerHTML = `<p>${data.error}</p>`;
      return;
    }
    
    if (data.length === 0) {
      takeAway.style.display = "none"; // Hide the cart if empty
      return;
    } else {

          // Add click event listener to navigate to cart page
      takeAway.onclick = function() {
        window.location.href = '/takeaway/cart'; // Replace with your actual cart URL
      };
      // Update the cart with proper structure
      takeAway.innerHTML = `
        <div style="background-color: #EE3E3F; width: 24px; height: 24px; border-radius: 50%; display: flex; justify-content: center; align-items: center; position: absolute; top: -8px; right: -8px; font-size: 12px; font-weight: bold;">${data.length}</div>
        <svg style="width: 24px; height: 24px; margin-right:10px;" viewBox="0 0 24 24" fill="white">
          <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
        </svg>
        Takeaway Cart
      `;
    }
  })
  .catch(error => {
    console.error('Error fetching takeaway cart data:', error);
    takeAway.innerHTML = `<p>Error loading cart data. Please try again later.</p>`;
  });

// If you also need the regular cart functionality
const cartDiv = document.getElementById("notification-cart");
if (cartDiv) { // Check if this element exists
  fetch('/getMealscart?userId=1')
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        cartDiv.innerHTML = `<p>${data.error}</p>`;
        return;
      }
      
      if (data.length === 0) {
        cartDiv.style.display = "none"; // Hide the cart if empty
        return;
      } else {

                  // Add click event listener to navigate to cart page
      cartDiv.onclick = function() {
        window.location.href = '/cart'; // Replace with your actual cart URL
      };

        cartDiv.innerHTML = `
        <div style="background-color: #EE3E3F; width: 24px; height: 24px; border-radius: 50%; display: flex; justify-content: center; align-items: center; position: absolute; top: -8px; right: -8px; font-size: 12px; font-weight: bold;">${data.length}</div>
        <svg style="width: 24px; height: 24px; margin-right:10px;" viewBox="0 0 24 24" fill="white">
          <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
        </svg>
        Cart
      `;
      }
    })
    .catch(error => {
      console.error('Error fetching cart data:', error);
      cartDiv.innerHTML = `<p>Error loading cart data. Please try again later.</p>`;
    });
}