<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmed - Thank You!</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            text-align: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 16px;
            max-width: 700px;
            width: 100%;
        }

        .success-animation {
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            border-radius: 50%;
            background-color: #ebf9f1;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scaleIn 0.5s ease-out;
        }

        .icon {
            font-size: 40px;
            color: #28a745;
            animation: checkmark 0.5s ease-out 0.5s forwards;
            opacity: 0;
            transform: scale(0);
        }

        @keyframes scaleIn {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }

        @keyframes checkmark {
            from { 
                opacity: 0;
                transform: scale(0);
            }
            to { 
                opacity: 1;
                transform: scale(1);
            }
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .reservation-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
        }

        .reservation-details p {
            color: #495057;
            margin: 10px 0;
            font-size: 16px;
            line-height: 1.5;
        }

        .message {
            color: #666;
            margin: 20px 0;
            line-height: 1.6;
        }

        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #2c3e50;
            color: white;
        }

        .btn-secondary {
            background-color: #fff;
            color: #2c3e50;
            border: 2px solid #2c3e50;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary:hover {
            background-color: #EE3E3F;
        }

        .btn-secondary:hover {
            background-color: #f8f9fa;
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-animation">
            <div class="icon">✔</div>
        </div>
        <h2>Reservation Confirmed!</h2>
        
        <!-- <div class="reservation-details">
            <p><strong>Reservation ID:</strong> <span id="reservationId">RES-2024-<?php echo rand(1000, 9999); ?></span></p>
            <p><strong>Date:</strong> <span id="reservationDate"><?php echo $_POST['date'] ?? 'Your selected date'; ?></span></p>
            <p><strong>Time:</strong> <span id="reservationTime"><?php echo $_POST['time'] ?? 'Your selected time'; ?></span></p>
            <p><strong>Party Size:</strong> <span id="partySize"><?php echo $_POST['guests'] ?? 'Your party size'; ?></span></p>
        </div> -->

        <p class="message">
            Thank you for choosing our restaurant! A confirmation email has been sent to your inbox. 
            Please save your reservation ID for future reference.
        </p>

        <div class="buttons">
            <button class="btn btn-primary" onclick="goHome()">Return to Home</button>
            <!-- <button class="btn btn-secondary" onclick="viewReservation()">View Reservation</button> -->
        </div>
    </div>

    <script>
        function goHome() {
            window.location.href = "/";
        }

        function viewReservation() {
            const reservationId = document.getElementById('reservationId').textContent;
            window.location.href = `/reservations/${reservationId}`;
        }
    </script>
</body>
</html>