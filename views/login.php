<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/login.css">
</head>
<body>
    <!-- <div class="upper-part">
    <div class="logo-img"></div>
               

    </div> -->
    <div class="form-login">
        <div class="second-part">
            <h1>Welcome Back!👋</h1>
            <h3>Your gateway to the ultimate flavor experience.</h3>

            <?php $form = \app\core\form\Form::begin('', 'post')?>

            <?php echo $form->field($model, 'email') ?>
            <?php echo $form->field($model, 'mobile_number') ?>

            <button type="submit" class="btn btn-primary" onclick="sendOtp()">Log In</button>

            <?php echo \app\core\form\Form::end()?>

            <p>Don't have an account? <a href="/register">Sign Up</a></p>

            <!-- Status div to display messages -->
            <div id="status"></div>
        </div>
    </div>

    
</body>
</html>