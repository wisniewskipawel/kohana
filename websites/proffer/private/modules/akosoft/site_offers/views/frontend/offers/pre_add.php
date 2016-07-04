<div id="offer_box_pre_add" class="box primary offers">
	<h2><?php echo $document->document_title ?></h2>
	<div class="content">
		<div class="pre_add_left">
			<?php echo $document->document_content ?>
			<a class="button center" href="<?php echo Route::url('site_offers/frontend/offers/add') ?>"><?php echo ___('offers.pre_add.add_btn') ?></a>
		</div>
		
		<div class="pre_add_right">
			<p class="login-label">Masz konto?</p>
			<a class="button center" href="<?php echo Route::url('bauth/frontend/auth/login') ?>"><?php echo ___('users.login') ?></a>
			<p class="register-label">Aby w pełni korzystać z możliwości serwisu</p>
			<a class="button center" href="<?php echo Route::url('bauth/frontend/auth/register') ?>"><?php echo ___('users.register.btn') ?></a>
			<p class="fb-label">lub zaloguj/zarejestruj się z FaceBook</p>
			<span class="button-fb"><?php if(Kohana::$config->load('modules.bauth.facebook.enabled')) 
				echo View::factory('auth/facebook/login_button') ?></span>
		</div>
	</div>
</div>