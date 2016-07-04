<div id="profile_user_data_box" class="box primary">
	<div class="box-header"><?php echo ___('profile.settings.title') ?></div>
	<div class="content">
		<?php if(isset($form_dealers)): ?>
		<?php echo $form_dealers ?>
		<?php else: ?>
		<?php echo $form_user_data->template('site')->param('class', 'bform form-vertical') ?>
		<?php endif; ?>
	</div>
</div>

<?php if($form_avatar): ?>
<div id="profile_avatar_box" class="box primary">
	<div class="box-header"><?php echo ___('profile.avatar.title') ?></div>
	<div class="content">
		<?php echo $form_avatar ?>
	</div>
</div>
<?php endif; ?>

<div id="profile_change_password_box" class="box primary">
	<div class="box-header"><?php echo ___('profile.change_password.title') ?></div>
	<div class="content">
		<?php echo $form ?>
	</div>
</div>
