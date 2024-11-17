
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="../CSS/payment.css">
    <script src="https://js.stripe.com/v3/"></script> <!-- Stripe JS Library -->
</head>
<body>
    <div class="payment-container">
        <h1>Choose Your Payment Method</h1>
        <div class="payment-options">
            <button id="pay-cash" onclick="payByCash()">Pay by Cash</button>
            <button id="pay-card" onclick="payByCard()">Pay by Card</button>
        </div>

        <!-- Pay by Cash Confirmation -->
        <div id="cash-confirmation" style="display: none;">
            <p>A message has been sent to the admin. A waiter will assist you shortly to complete the payment.</p>
        </div>

        <!-- Stripe Card Payment Form -->
        <div id="card-payment-form" style="display: none;">
            <h2>Enter Card Details</h2>
            <form id="payment-form">
                <div id="card-element"><!-- Stripe card input --></div>
                <button type="submit" id="submit">Submit Payment</button>
            </form>
            <div id="card-errors" role="alert"></div>
        </div>
    </div>

    <!-- JavaScript for Stripe and Form Handling -->
    <script>
        const stripe = Stripe('pk_test_51QFYneBsbayiOAU2WJLkWpsdh9S49kJgDMHzBYKuebz2EHqJqyyORBsGJlIeTLS6SSv1R3QJeRqnf5UUD0B69tCI008kaxAhiP'); // Replace with your actual Publishable key from Stripe
        const elements = stripe.elements();
        const card = elements.create("card");
        
        card.mount("#card-element");

        // Function to handle "Pay by Cash"
        function payByCash() {
            document.getElementById("cash-confirmation").style.display = "block";
            document.getElementById("card-payment-form").style.display = "none";
        }

        // Function to handle "Pay by Card"
        function payByCard() {
            document.getElementById("cash-confirmation").style.display = "none";
            document.getElementById("card-payment-form").style.display = "block";
        }

        // Handle form submission for Stripe
        document.getElementById('payment-form').addEventListener('submit', async (event) => {
            event.preventDefault();

            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
            } else {
                alert("Payment successful! Thank you.");
                console.log("Payment Method ID:", paymentMethod.id);
            }
        });
    </script>
</body>
</html>
