<?php
      /** @var $this \app\core\view */
      /** @var $model \app\models\ContactForm */

    
      use app\core\form\TextareaField;
      $this->title = 'Contact'
    ?>

<h1>contact</h1>

<?php $form = \app\core\form\Form::begin('','post')?>
<?php echo $form->field($model, 'subject')?>
<?php echo $form->field($model, 'email')?>
<?php echo new TextareaField($model, 'body')?>

<button type="submit" class="btn btn-primary">Submit</button>


<?php \app\core\form\Form::end(); ?>




<!-- <form action="" method="post">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div> 
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form> -->

