<ul class="steps">
	<li id="stepsLogin" <?php if($current_route_name == 'bauth/frontend/auth/login') echo 'class="active"' ?>>
		<span class="number">1</span>
		<span class="text">
			<?php echo HTML::anchor(Route::get('bauth/frontend/auth/login')->uri(), ___('users.steps.login')) ?>
		</span>
	</li>
	<li id="stepsRegister" <?php if($current_route_name == 'bauth/frontend/auth/register') echo 'class="active"' ?>>
		<span class="number">2</span>
		<span class="text">
			<?php echo HTML::anchor(Route::get('bauth/frontend/auth/register')->uri(), ___('users.steps.register')) ?>
		</span>
	</li>
	<li id="stepsLostPassword" <?php if($current_route_name == 'bauth/frontend/auth/lost_password') echo 'class="active"' ?>>
		<span class="number">3</span>
		<span class="text">
			<?php echo HTML::anchor(Route::get('bauth/frontend/auth/lost_password')->uri(), ___('users.steps.lost_password')) ?>
		</span>
	</li>
</ul>