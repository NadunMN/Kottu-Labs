<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment UI</title>
    <link rel="stylesheet" href="/CSS/payments.css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  </head>
  
  <body>
    <div class="payment-container">
      <h1> 
        <img src="/Photo/icon/method.png" alt="payyment-icon" class="payment-icon">  
        Select Payment Method
      </h1>
      <div class="payment-options">
        <label>
          <input type="radio" name="payment-method" value="card" onclick="showCardPayment()"/>
          <span>
            Pay by Card 
            <img src="/Photo/icon/visa.png" alt="Visa" />
            <img src="/Photo/icon/master.png" alt="Mastercard"/>
          </span>
        </label>     
        <label>
          <input type="radio" name="payment-method" value="cash" onclick="showCashPayment()"/>
          <span> Pay by Cash <img src="/photo/icon/dollars.png" alt="$" /></span>
        </label>
      </div>
      <div class="payment-section-wrapper">
        
        <div id="cash-payment" class="payment-section hidden">
          <p class="cash-message-box">
            A waiter will assist you shortly to complete the payment.
          </p>
          <button onclick="continuePayment()">Continue</button>
        </div>
      </div>
    </div>
    <script src="/JavaScript/payment.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
  </body>
</html>
