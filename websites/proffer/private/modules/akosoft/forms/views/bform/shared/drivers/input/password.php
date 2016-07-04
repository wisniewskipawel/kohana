<div class="input_password_wrapper">
	<?php
	echo Form::password(
		$driver->html('name'), 
		$driver->html('keep_password') ? $driver->get_value() : NULL, 
		array(
			'id' => $driver->html('id'), 
			'class' => $driver->html('class'), 
			'size' => $driver->html('size'),
		)
	);
	if($driver->data('strength')): ?>
	<div class="password_strength">
		<?php echo ___('bform.driver.password.strength.label') ?>:
		<span></span>
	</div>
	<script>
	$(document).ready(function() {

		$('#<?php echo $driver->html('id') ?>').on('keyup', pass_strength);
		pass_strength();

		function pass_strength() {
			var password = $('#<?php echo $driver->html('id') ?>').val();
			
			$('.password_strength').hide();
			
			if(!password) return;
			
			var desc = [
				"<?php echo ___('bform.driver.password.strength.strength0') ?>", 
				"<?php echo ___('bform.driver.password.strength.strength1') ?>", 
				"<?php echo ___('bform.driver.password.strength.strength2') ?>", 
				"<?php echo ___('bform.driver.password.strength.strength3') ?>", 
				"<?php echo ___('bform.driver.password.strength.strength4') ?>", 
			];
			var score = 0;

			if (password.length > 6) score++;
			if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;
			if (password.match(/\d+/)) score++;
			if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) score++;

			$('.password_strength').show().find('span').text(desc[score]).attr('class', 'strength'+score);
		}
	});
	</script>
	<?php endif; ?>
</div>