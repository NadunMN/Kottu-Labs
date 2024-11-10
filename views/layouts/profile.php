<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/userdashboard.css">

</head>
<body>
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
                    <h1>Nadun Madusankan</h1>
                    <h4>nadunmadusanka@gmail.com</h4>
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

                <button onclick="window.location.href='/myaccount'">View Profile</button>

            </div>

        </div>
    </div>

   {{content}}
   <?php include __DIR__ . '/../footer.php'; ?>

</body>
</html>