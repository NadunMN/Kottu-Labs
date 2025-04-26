<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Interface</title>
    <link rel="stylesheet" href="/CSS/paymentCollection.css">
</head>
<body>

<div class="payment-container-wrapper">
  <div class="payment-container">
    <div class="payment-header">
      <h1>Complete Your Payment</h1>
    </div>
    
    <div class="payment-body">
      <div class="payment-summary">
        <div class="payment-total">
          <span>Total</span>
          <span id="payment-total">$75.99</span>
        </div>
        <div class="payment-description">
          Order #12345 - 3 items
        </div>
      </div>
      
      <div class="payment-method-selector">
        <div class="payment-method-title">Select Payment Method</div>
        <div class="payment-methods">
          <div class="method-option" onclick="selectMethod('card')" id="card-option">
            <div class="icon icon-card"></div>
            <div class="method-name">Card</div>
          </div>
          <div class="method-option" onclick="selectMethod('cash')" id="cash-option">
            <div class="icon icon-cash"></div>
            <div class="method-name">Cash</div>
          </div>
        </div>
      </div>
      
      <form class="payment-form" data-method="card">
        <!-- <div class="card-details">
          <div class="form-group">
            <label for="card-number">Card Number</label>
            <input type="text" id="card-number" placeholder="1234 5678 9012 3456">
          </div>
        </div>
        
        <div class="card-details">
          <div class="form-group">
            <label for="name">Cardholder Name</label>
            <input type="text" id="name" placeholder="John Smith">
          </div>
        </div>
        
        <div class="card-details">
          <div class="form-group">
            <label for="expiry">Expiry Date</label>
            <input type="text" id="expiry" placeholder="MM/YY">
          </div>
          <div class="form-group">
            <label for="cvv">CVV</label>
            <input type="text" id="cvv" placeholder="123">
          </div>
        </div>
        
        <div class="cash-details">
          <div class="cash-payment">
            <div class="icon icon-cash icon-large-cash"></div>
            <h3>Cash Payment</h3>
            <p class="cash-instructions">Please have the exact amount ready for delivery or at checkout counter.</p>
          </div>
        </div>
         -->
        <button type="button" class="btn" id="pay-button">Pay Now</button>
      </form>
    </div>
  </div>
  </div>
  
  <script src="/JavaScript/paymentCollection.js"></script>
</body>
</html>