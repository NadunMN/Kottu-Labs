function showCardPayment(){
    document.getElementById("cash-payment").classList.add("hidden");
    var xhttp=new XMLHttpRequest();
    xhttp.onreadystatechange=()=>{
        if(xhttp.readyState == 4 && xhttp.status == 200){
            // alert(xhttp.responseText);
            var obj= JSON.parse(xhttp.responseText);
            
            // Payment completed. It can be a successful failure.
            payhere.onCompleted = function onCompleted(orderId) {
                console.log("Payment completed. OrderID:" + orderId);
                // Note: validate the payment and show success or failure page to the customer
            };

            // Payment window closed
            payhere.onDismissed = function onDismissed() {
                // Note: Prompt user to pay again or show an error page
                console.log("Payment dismissed");
            };

            // Error occurred
            payhere.onError = function onError(error) {
                // Note: show an error page
                console.log("Error:"  + error);
            };

            // Put the payment variables here
            var payment = {
                "sandbox": true,
                "merchant_id": "1229387", 
                "return_url": "http://localhost:8080/payment",
                "cancel_url": "http://localhost:8080/payment",
                "notify_url": "http://sample.com/notify",
                "order_id": obj["order_id"],
                "items": "Door bell wireles",
                "amount": obj["amount"],
                "currency": obj["currency"],
                "hash": obj["hash"], 
                "first_name": "Saman",
                "last_name": "Perera",
                "email": "samanp@gmail.com",
                "phone": "0771234567",
                "address": "No.1, Galle Road",
                "city": "Colombo",
                "country": "Sri Lanka",
                "delivery_address": "No. 46, Galle road, Kalutara South",
                "delivery_city": "Kalutara",
                "delivery_country": "Sri Lanka",
                "custom_1": "",
                "custom_2": ""
            };
            payhere.startPayment(payment);
        }
    }
    xhttp.open("GET","pay.php",true);
    xhttp.send();
}

function showCashPayment() {
    document.getElementById("cash-payment").classList.remove("hidden");
    document.getElementById("card-payment").classList.add("hidden");
}

function continuePayment() {
    alert("You chose to pay by cash. A waiter will assist you.");
    window.location.href = "http://localhost:8080/offer";
}