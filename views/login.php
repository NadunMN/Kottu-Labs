
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/login.css">
</head>
<body>


    <div class="form-login">
        

        <div class="second-part">
        <h1>Welcome Back!</h1>
        <h3>Your gateway to the ultimate flavor experience.</h3>

        <?php $form = \app\core\form\Form::begin('', 'post')?>

        <?php echo $form->field($model, 'email') ?>
        <?php echo $form->field($model, 'mobile_number') ?>


        <button type="submit" class="btn btn-primary">Log In</button>

        <div class="or">
        
        <hr style="border: none; border-top: 1px solid #EE3E3F; margin: 40px 0; width: 75%;">
        <p>or</p>
        <hr style="border: none; border-top: 1px solid #EE3E3F; margin: 40px 0; width: 75%;">

        </div>
        
        <button type="submit" class="btn btn-google"><img src="/Photo/icon/google.png">Log in with Google</button>


        <?php echo \app\core\form\Form::end()?>

        </div>
    </div>
        
</body>
</html>



