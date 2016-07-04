<div id="auth_login_box" class="box primary">
	<h2><?php echo ___('users.login.title') ?></h2>
	<div class="content">
		
		<div class="not_logged-box">
			
			<div class="info">
				<?php echo ___('users.login.info', array(
					':register_url' => Route::url('bauth/frontend/auth/register'),
				)) ?>
			</div>
				
			<?php if(Kohana::$config->load('modules.bauth.facebook.enabled')) 
				echo View::factory('auth/facebook/login_button') ?>
			
			<?php 
			$form->action(BAuth::uri_login().URL::query());
			$form->param('class', 'bform form-inline');
			echo $form->render_form_open(); ?>

			<?php echo $form->form_id ?>

			<?php echo $form->user_name ?>
			
			<div class="control-group">
				<?php echo $form->user_password ?>
				<?php echo $form->remember ?>
			</div>

			<div class="control-group">
				<?php echo Form::image('submit', ___('users.login'), array(
					'src' => 'media/img/login-btn.png',
				)) ?>
			</div>

			<?php echo $form->render_form_close(); ?>
			
			<ul class="action_links">
				<li><a href="<?php echo Route::url('bauth/frontend/auth/lost_password') ?>"><?php echo ___('users.lost_password.link') ?></a></li>
				<li><?php echo HTML::anchor(Route::get('bauth/frontend/auth/send_activation_link')->uri(), ___('users.send_activation_link.link')) ?></li>
			</ul>
			
		</div>

	</div>
</div>