<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="/CSS/otp.css">
</head>
<body>
    <div class="container">
        <h1>Verification Code</h1>
        <p>Please enter the verification code sent to <br>+1 ******789</p>

        <form id="otpForm" novalidate>
            <div class="otp-field">
                <input type="number" maxlength="1" aria-label="Digit 1" required />
                <input type="number" maxlength="1" aria-label="Digit 2" required />
                <input type="number" maxlength="1" aria-label="Digit 3" required />
                <input type="number" maxlength="1" aria-label="Digit 4" required />
                <input type="number" maxlength="1" aria-label="Digit 5" required />
                <input type="number" maxlength="1" aria-label="Digit 6" required />
            </div>

            <button type="submit" id="verifyButton" disabled>Verify</button>
        </form>

        <div class="timer">
            Time remaining: <span id="countdown">01:30</span>
        </div>

        <a href="#" class="resend">Resend OTP</a>
    </div>

    <script src="/JavaScript/otp.js"></script>
</body>
</html>
