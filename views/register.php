<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/CSS/login.css">
</head>
<body>
    <div class="form-login">
        <div class="second-part">
            <h1>Register</h1>

            <?php $form = \app\core\form\Form::begin('', 'post')?>

            <!-- Name fields with user icon -->
            <div class="form-group" data-icon="user">
                <?php echo $form->field($model, 'firstname') ?>
            </div>
            <div class="form-group" data-icon="user">
                <?php echo $form->field($model, 'lastname') ?>
            </div>

            <!-- Email field with email icon -->
            <div class="form-group" data-icon="email">
                <?php echo $form->field($model, 'email') ?>
            </div>

            <!-- Mobile field with phone icon -->
            <div class="form-group" data-icon="phone">
                <?php echo $form->field($model, 'mobile_number') ?>
            </div>

            <!-- Password field with lock icon -->
            <div class="form-group" data-icon="lock">
                <?php echo $form->field($model, 'password')->passwordField() ?>
            </div>

            <!-- Confirm Password field with lock icon -->
            <div class="form-group" data-icon="lock">
                <?php echo $form->field($model, 'confirmPassword')->passwordField() ?>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <p style="margin-top: 10px;">Have an account? <a href="/login">Sign In</a></p>

            <?php echo \app\core\form\Form::end()?>
        </div>
    </div>
</body>
</html>