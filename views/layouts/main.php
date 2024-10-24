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
    </head>
  <body>

  <div class="container">
    
  <?php if(Application::$app->session->getFlash('success')): ?>
    <div class="alert alert-success">
      <?php echo Application::$app->session->getFlash('success') ?>
    </div> 
  <?php endif; ?>
  <?php include __DIR__ . '/../NavBar.php'; ?>
  {{content}}
  <?php include __DIR__ . '/../footer.php'; ?>


  </div>
  </body>
</html>