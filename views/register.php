<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="/CSS/login.css">
</head>
<body>

<div class="form-login">
        

        <div class="second-part">

<h1>Get Stared!👏</h1>
<h3>Sign up for exclusive perks and experiences.</h3>

<?php $form = \app\core\form\Form::begin('', 'post')?>

<?php echo $form->field($model, 'firstname') ?>
<?php echo $form->field($model, 'lastname') ?>
<?php echo $form->field($model, 'email') ?>
<?php echo $form->field($model, 'mobile_number') ?>


<button type="submit" class="btn btn-primary">Submit</button>
<p style="margin-top: 10px;">Have an account?<a href="/login">Sign In</a></p>


<?php echo \app\core\form\Form::end()?>

</div>
</div>

    
</body>
</html>

