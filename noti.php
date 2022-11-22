<?php  if (count($errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors as $success) : ?>
  	  <p><?php echo $success ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>


<?php  if (count($success) > 0) : ?>
  <div class="success">
  	<?php foreach ($success as $success) : ?>
  	  <p><?php echo $success ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>