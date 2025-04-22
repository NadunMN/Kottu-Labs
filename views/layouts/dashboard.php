<?php
  use \app\core\Application;
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->title; ?></title>
    <link rel="stylesheet" href="/CSS/main.css">
    <link rel="stylesheet" href="/CSS/cartshow.css">


    </head>
  <body>

  <div class="container">
    
  <?php if(Application::$app->session->getFlash('success')): ?>
    <div class="alert alert-success">
      <?php echo Application::$app->session->getFlash('success') ?>
    </div> 
  <?php endif; ?>
  <?php include __DIR__ . '/../NavBar.php'; ?>

  <!-- <div
  id="notification-cart"
  style="
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color:rgb(0, 0, 0);
    color: white;
    padding: 15px 20px;
    border-radius: 100px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    z-index: 9999;
    display: flex;
    align-items: center;
    font-family: Arial, sans-serif;
    font-size: 14px;
    cursor: pointer;
    "
>
  <div style="background-color: #EE3E3F; width: 24px; height: 24px; border-radius: 50%; display: flex; justify-content: center; align-items: center; position: absolute; top: -8px; right: -8px; font-size: 12px; font-weight: bold;">3</div>
  <svg style="width: 24px; height: 24px; margin-right: 10px;" viewBox="0 0 24 24" fill="white">
    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
  </svg>
  Cart
</div>

<div
  id="notification-takeawaycart"
  style="
    position: fixed;
    bottom: 100px;
    right: 20px;
    background-color:rgb(0, 0, 0);
    color: white;
    padding: 15px 20px;
    border-radius: 100px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    z-index: 9999;
    display: flex;
    align-items: center;
    font-family: Arial, sans-serif;
    font-size: 14px;
    cursor: pointer;
  "
>
  <div style="background-color: #EE3E3F; width: 24px; height: 24px; border-radius: 50%; display: flex; justify-content: center; align-items: center; position: absolute; top: -8px; right: -8px; font-size: 12px; font-weight: bold;">3</div>
  <svg style="width: 24px; height: 24px; margin-right: 10px;" viewBox="0 0 24 24" fill="white">
    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
  </svg>
  Cart
</div> -->


  {{content}}


  </div>
  <script src="/JavaScript/cartshow.js"></script>

  </body>
</html>