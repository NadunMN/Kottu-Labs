<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment UI</title>
    <link rel="stylesheet" href="/CSS/payments.css" />
    <script src="https://js.stripe.com/v3/"></script>
  </head>


  <body>
    <div class="payment-container">
      <h1> 
        <img src="/Photo/icon/method.png" alt="payyment-icon" class="payment-icon">  
        Select Payment Method
      </h1>
      <div class="payment-options">
        <label>
          <input
            type="radio"
            name="payment-method"
            value="card"
            checked
            onclick="showCardPayment()"
          />
          <span>
            Pay by Card 
            <img src="/Photo/icon/visa.png" alt="Visa" />
            <img src="/Photo/icon/master.png" alt="Mastercard"/>
          </span>
        </label>
        <label>
          <input
            type="radio"
            name="payment-method"
            value="cash"
            onclick="showCashPayment()"
          />
        
          <span> Pay by Cash <img src="/photo/icon/dollars.png" alt="$" /></span>
        </label>
      </div>
      <div class="payment-section-wrapper">
        <div id="card-payment" class="payment-section">
          <form id="payment-form">
            <p>Enter card details:</p>
            <div id="card-element">
            </div>
            <button type="submit" id="submit">Submit Payment</button>
            <div id="card-errors" role="alert"></div>
          </form>
        </div>
        <div id="cash-payment" class="payment-section hidden">
          <p class="cash-message-box">
            A waiter will assist you shortly to complete the payment.
          </p>
          <button onclick="continuePayment()">Continue</button>
        </div>
      </div>
    </div>
    <script>
      function showCardPayment() {
        document.getElementById("card-payment").classList.remove("hidden");
        document.getElementById("cash-payment").classList.add("hidden");
      }

      function showCashPayment() {
        document.getElementById("cash-payment").classList.remove("hidden");
        document.getElementById("card-payment").classList.add("hidden");
      }

      function continuePayment() {
        alert("You chose to pay by cash. A waiter will assist you.");
      }

      // Initialize Stripe
      const stripe = Stripe("pk_test_51QFYneBsbayiOAU2WJLkWpsdh9S49kJgDMHzBYKuebz2EHqJqyyORBsGJlIeTLS6SSv1R3QJeRqnf5UUD0B69tCI008kaxAhiP"
      );
      const elements = stripe.elements();

      // Configure the Card Element to hide the ZIP/postal code field
      const card = elements.create("card", {
        style: {
          base: {
            fontSize: "16px",
            color: "#32325d",
            fontFamily: "Arial, sans-serif",
          },
        },
        hidePostalCode: true, // Hides the ZIP/postal code field
      });

      // Mount the Card Element
      card.mount("#card-element");

      const form = document.getElementById("payment-form");
      form.addEventListener("submit", async (event) => {
        event.preventDefault();
        const { error, paymentMethod } = await stripe.createPaymentMethod({
          type: "card",
          card: card,
        });

        if (error) {
          document.getElementById("card-errors").textContent = error.message;
        } else {
          alert("Payment successful! Payment Method ID: " + paymentMethod.id);
          console.log(paymentMethod);
        }
      });
    </script>
  </body>
</html>
