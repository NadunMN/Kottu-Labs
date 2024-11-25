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
    <!-- Hero Section -->
    <section class="container1" aria-label="Page Header">
        <div class="title">
            <h1>Contact Us</h1>
        </div>
    </section>

    <section class="container2">
        <div class="info-item">
            <img src="/Photo/icon/restaurant1.png" alt="restaurant icon" class="icon" />
            <div class="text-container">
                <h3>Waattala Branch</h3>
                <div class="address-container">
                    <img src="/Photo/icon/location.png" alt="restaurant icon" class="iconL" />
                    <p>190, 3 Negombo Rd,<br>Wattala.</p>
                </div>
                <div class="phone-container">
                    <img src="/Photo/icon/phone.png" alt="restaurant icon" class="iconP" />
                    <p>076 130 1478</p>
                </div>
            </div>
        </div>

        <div class="info-item">
            <img src="/Photo/icon/restaurant1.png" alt="restaurant icon" class="icon" />
            <div class="text-container">
                <h3>Kelaniya Branch</h3>
                <div class="address-container">
                    <img src="/Photo/icon/location.png" alt="restaurant icon" class="iconL" />
                    <p>540, Kandy Rd, <br>Kelaniya.</p>
                </div>
                <div class="phone-container">
                    <img src="/Photo/icon/phone.png" alt="restaurant icon" class="iconP" />
                    <p>077 712 0815</p>
                </div>
            </div>
        </div>

        <div class="info-item"><img src="/Photo/icon/restaurant1.png" alt="restaurant icon" class="icon" />
            <div class="text-container">
                <h3>Kotahena Branch</h3>
                <div class="address-container">
                    <img src="/Photo/icon/location.png" alt="restaurant icon" class="iconL" />
                    <p>51C, Green Ln, <br>Colombo 13.</p>
                </div>
                <div class="phone-container">
                    <img src="/Photo/icon/phone.png" alt="restaurant icon" class="iconP" />
                    <p>077 123 4567</p>
                </div>
            </div>
            </div>
        </div>
    </section>
  
    <div class="form-login">
        
        <div class="second-part">
            <h1>Send Message</h1>

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

