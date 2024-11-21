<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Branch - Kottu Labs</title>
    <link rel="stylesheet" href="/CSS/selectBranch.css">
</head>
<body>

    <!-- Select Branch Section -->
    <div class="select-branch-header">
        <h1>Select Your Branch</h1>
    </div>

    <!-- Branch Selection -->
    <div class="branch-container">
        <div class="branch" data-branch="Nawala">
            <img src="/Photo/Thirani_pics/Kotahena.jpg" alt="Nawala Branch" class="branch-img" onclick="window.location.href='/menu'">
            <p>Nawala</p>
        </div>
        <div class="branch" data-branch="Kelaniya">
            <img src="/Photo/Thirani_pics/kelaniya.jpg" alt="Kelaniya Branch" class="branch-img" onclick="window.location.href='/menu'">
            <p>Kelaniya</p>
        </div>
        <div class="branch" data-branch="Wattala">
            <img src="/Photo/Thirani_pics/wattala.png" alt="Wattala Branch" class="branch-img" onclick="window.location.href='/menu'">
            <p>Wattala</p>
        </div>
    </div>

    <script src="/JavaScript/selectBranch.js"></script>
</body>
</html>



