<!-- <?php
/** @var $user \app\models\User */
$currentPath = $_SERVER['REQUEST_URI'];
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/userdashboard.css">

</head>
<body>

<script>

     // Fetch user data from the backend
     fetch('/user/data')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                } else {
                    // Display user data in the frontend
                    document.getElementById('user-name').textContent = `${data.firstname} ${data.lastname}`;
                    document.getElementById('user-email').textContent = `${data.email}`;
                }
            })
            .catch(error => console.error('Error fetching user data:', error));

</script>



<?php include __DIR__ . '/../NavBar.php'; ?>


<div class="userprofile-main">

<div class="content-wapper">

    <div class="userprofile-backcover">

    </div>

    <div class="userprofile-profile">
        <div class="userprofile-profile-wrapper">

            <div class="userprofile-profile-name-content">
                <div class="circle"></div>
                <div class="circle-name-wrapper">
                    <h1 id="user-name"></h1>
                    <h4 id="user-email"></h4>
                    <div class="circle-name-numbers">
                        <div class="ON-wrapper">
                            <h4>ON:</h4>
                            <h4>0234</h4>
                        </div>
                        <div class="ON-wrapper">
                            <h4>TN:</h4>
                            <h4>0234</h4>
                        </div>
                    </div>

                </div>

            </div>

            <div class="userprofile-profile-name">

                <button id="view-profile">View Profile</button>

            </div>

        </div>
    </div>

   {{content}}
   <?php include __DIR__ . '/../footer.php'; ?>
   <script src="/JavaScript/profile.js"></script>

</body>
</html>