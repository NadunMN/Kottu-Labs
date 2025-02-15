<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Reservation</title>
    <link rel="stylesheet" href="/CSS/cancelReserve.css">
</head>

<body>

    <div class="container">
        <img src="/Photos/KottuLabs_logo.png" alt="Kottu Labs Logo" class="logo">
        <h1>Cancel your Reservation </h1>
        <form>

            <div class="form-row">
                <label>Reservation Number:</label>
                <input type="text" required>
                <label> Phone Number:</label>
                <input type="tel" pattern="[0-9]{10}" required>
            </div>

            <button type="submit">Cancel Reservation</button>
        </form>
    </div>

</body>
</html>