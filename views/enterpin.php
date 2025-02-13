<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter PIN</title>
    <link rel="stylesheet" href="/CSS/enterpin.css">
</head>
<body>
    <div class="pin-topic">
        <h1>Enter Confirmation PIN</h1>
        <p>Please enter the PIN to continue</p>
    </div>

    <div class="pin-container">
        <div class="pin-box">
            <div class="pin-input-container">
                <input type="text" maxlength="1" class="pin-digit">
                <input type="text" maxlength="1" class="pin-digit">
                <input type="text" maxlength="1" class="pin-digit">
                <input type="text" maxlength="1" class="pin-digit">
                <input type="text" maxlength="1" class="pin-digit">
                <input type="text" maxlength="1" class="pin-digit">
            </div>
            <div class="pin-message">
                <!-- Error or success messages will appear here -->
            </div>
            <button class="submit-button">Submit</button>
        </div>
    </div>

    <script src="/JavaScript/enterpin.js"></script>
</body>
</html>