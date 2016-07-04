<div class="not_logged-box">
	<div class="info">
		<?php echo ___('jobs.replies.not_logged.info', array(
			':register_url' => Route::url('bauth/frontend/auth/register'),
		)) ?>
	</div>
				
	<?php if(Kohana::$config->load('modules.bauth.facebook.enabled')) 
		echo View::factory('auth/facebook/login_button') ?>

	<?php 
	$form = Bform::factory('Auth_Login');
	$form->action(BAuth::uri_login(TRUE));
	$form->param('class', 'bform form-inline');
	echo $form->render_form_open(); ?>

	<?php echo $form->form_id ?>

	<?php echo $form->user_name ?>
	<?php echo $form->user_password ?>

	<div class="control-group">
		<?php echo Form::image('submit', ___('users.login'), array(
			'src' => 'media/img/login-btn.png',
		)) ?>
	</div>

	<?php echo $form->render_form_close(); ?>
</div>