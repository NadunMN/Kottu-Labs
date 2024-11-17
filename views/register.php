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

<h1>Join Kottu Labs!</h1>
<h3>Sign up for exclusive perks and experiences.</h3>

<?php $form = \app\core\form\Form::begin('', 'post')?>

<?php echo $form->field($model, 'firstname') ?>
<?php echo $form->field($model, 'lastname') ?>
<?php echo $form->field($model, 'email') ?>
<?php echo $form->field($model, 'mobile_number') ?>
<?php echo $form->field($model, 'password')->passwordField() ?>
<?php echo $form->field($model, 'confirmPassword')->passwordField() ?>

<button type="submit" class="btn btn-primary">Submit</button>


<?php echo \app\core\form\Form::end()?>

</div>
</div>

    
</body>
</html>

