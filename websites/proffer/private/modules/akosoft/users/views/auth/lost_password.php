<div class="box primary">
	<h2><?php echo ___('users.lost_password.title') ?></h2>
	<div class="content">

		<?php echo View::factory('auth/partials/steps') ?>
		
		<div class="clearfix"></div>

		<?php echo $form->param('class', 'form-mini') ?>
	</div>
</div>