<form action="<?php echo $payu->get_url('new') ?>" method="post" name="payform" class="bform">
	<?php foreach($payu->get_fields() as $field_name => $field_value): ?>
	<?php if(!empty($field_value)) echo Form::hidden($field_name, $field_value); ?>
	<?php endforeach; ?>

	<div class="control-group">
		<label>&nbsp;</label>
		<div class="controls">
			<input type="submit" value="<?php echo ___('payu.forms.submit') ?>">
		</div>
	</div>
</form>