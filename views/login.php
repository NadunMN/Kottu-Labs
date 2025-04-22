<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/CSS/login.css">
</head>
<body>
    <div class="form-login">
        <div class="second-part">
            <h1>Login</h1>



            <?php $form = \app\core\form\Form::begin('', 'post')?>

            <!-- Email field with email icon -->
            <div class="form-group" data-icon="email">
                <?php echo $form->field($model, 'email') ?>
            </div>

            <!-- Mobile number field with user icon -->
            <div class="form-group" data-icon="user">
                <?php echo $form->field($model, 'mobile_number') ?>
            </div>

            <?php if(isset($error) && $error!='customer'): ?>
                <div class="form-group" data-icon="lock">
                    <?php echo $form->field($model, 'password')->passwordField() ?>
                    <?php if ($model->hasError('password')): ?>
                        <div class="alert alert-danger">
                            <?php echo $model->getFirstError('password'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary" onclick="sendOtp()">Log In</button>

            <?php echo \app\core\form\Form::end()?>

            <p>Don't have an account? <a href="/register">Sign Up</a></p>
            <div id="status"></div>
        </div>
    </div>
</body>
</html> 