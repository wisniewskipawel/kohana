<form method="post" action="<?php echo $config['url'] ?>">

	<?php echo Form::hidden('business', $config['business']); ?>

	<?php echo Form::hidden('return', $config['return'].URL::query(array('token' => Arr::get($form, 'custom')), FALSE)); ?>
	<?php echo Form::hidden('cancel_return', $config['cancel_return'].URL::query(array('token' => Arr::get($form, 'custom')), FALSE)); ?>

	<?php echo Form::hidden('notify_url', $config['notify_url']) ?>

	<?php echo Form::hidden('cmd', '_xclick') ?>
	<?php echo Form::hidden('no_note', 1) ?>
	<?php echo Form::hidden('no_shipping', 1) ?>
	<?php echo Form::hidden('currency_code', $config['currency_code']) ?>
	<?php echo Form::hidden('charset', Kohana::$charset) ?>
	<?php echo Form::hidden('amount', number_format($amount, 2, '.', '')) ?>

	<?php foreach ($form as $key => $value): ?>
		<?php echo Form::hidden($key, $value) ?>
	<?php endforeach ?>
    
	<input type="submit" value="<?php echo ___('paypal.buy_btn') ?>" />
    
</form>