<form action="" method="POST">
	<div id="login-box">
		<input type="hidden" name="form_id" value="Form_Auth_Login" />
		<div>
			<?php if ( ! empty($form->errors)): ?>
				<ul class="<?php echo Kohana::$config->load('bform.css.errors.ul_class') ?>">
					<?php foreach ($form->errors as $e): ?>
						<li><strong><?php echo $e['driver_name'] ?><?php echo (strpos($e['driver_name'], ':') !== FALSE ? '' : ':') ?></strong> <?php echo $e['error'] ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif ?>
		</div>
		<div>
			<?php echo $form->user_name->render(TRUE) ?>
			<?php echo $form->user_password->render(TRUE) ?>
		</div>
	</div>
	<div id="button" >
		<input type="submit" value="<?php echo ___('users.login') ?>" class="btn" />
	</div>
</form>