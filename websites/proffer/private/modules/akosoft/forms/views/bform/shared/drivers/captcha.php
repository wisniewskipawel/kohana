<div class="captcha_box">
	<?php if(Captcha::instance() instanceof Captcha_Riddle): ?>
	<div class="riddle">
		<div class="question"><?php echo Captcha::instance()->render() ?></div>
		<div class="captcha_text"><?php echo ___('bform.driver.captcha.riddle.text') ?></div>
	</div>
	<?php else: ?>
	<div class="captcha_image">
		<?php echo Captcha::instance()->render() ?>
		<div class="captcha_text"><?php echo ___('bform.driver.captcha.image.text') ?></div>
	</div>
	<?php endif; ?>
</div>
<?php echo Form::input(
	$driver->html('name'),
	NULL,
	array(
		'id' => $driver->html('id'),
		'class' => $driver->html('class'),
		'size' => $driver->html('size'),
	)
); ?>