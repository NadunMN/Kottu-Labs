<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
        }
        .icon {
            font-size: 50px;
            color: green;
        }
        h2 {
            color: #333;
        }
        p {
            color: #666;
        }
        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background-color: #EE3E3F;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="icon">✔</div>
        <h2>Reservation Successful!</h2>
        <p>Your table has been reserved. We look forward to serving you.</p>
        <button class="btn" onclick="goHome()">Go to Home Page</button>
    </div>

    <script>
        function goHome() {
            window.location.href = "/"; // Change this to your actual home page URL
        }
    </script>

</body>
</html>
