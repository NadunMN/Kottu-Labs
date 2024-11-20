<?php
/** @var $this \app\core\View */
/** @var $model \app\models\ContactForm */

use app\core\form\TextareaField;
use app\core\form\Form;

$this->title = 'Contact';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/CSS/contact.css">
</head>
<body>

<div class="contact-container">
    <div class="contact-info">
        <h1>Contact Us</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
        <div class="info-item">
            <i class="icon">&#x1F4CD;</i> <!-- Location Icon -->
            <span>
                <strong>Address:</strong><br>
                4671 Sugar Camp Road, Owatonna, Minnesota, 55060
            </span>
        </div>
        <div class="info-item">
            <i class="icon">&#x260E;</i> <!-- Phone Icon -->
            <span>
                <strong>Phone:</strong><br>
                507-475-60945-6094
            </span>
        </div>
        <div class="info-item">
            <i class="icon">&#x1F4E7;</i> <!-- Email Icon -->
            <span>
                <strong>Email:</strong><br>
                wrub7d7810e@temporary-mail.net
            </span>
        </div>
    </div>
  
    <div class="form-login">
        
        <div class="second-part">
            <h1>Contact</h1>

            <?php $form = Form::begin('', 'post') ?>
            <?php echo $form->field($model, 'subject') ?>
            <?php echo $form->field($model, 'email') ?>
            <?php echo new TextareaField($model, 'body') ?>
            <button type="submit" class="btn btn-primary">Submit</button>
            <?php Form::end(); ?>
        </div>
    </div>
</div>  
</body>
</html>

