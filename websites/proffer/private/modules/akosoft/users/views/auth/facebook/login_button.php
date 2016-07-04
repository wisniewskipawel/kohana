<?php echo HTML::anchor(
	Route::get('bauth/frontend/facebook/login')->uri(), 
	___('users.facebook.login.btn'), 
	array('class' => 'btn-auth btn-facebook')
) ?>