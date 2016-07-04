<?php if ( ! empty($payment_text)): ?>

<div class="box primary">
	<div class="box-header"><?php echo ___('payments.pay.details') ?></div>
	<div class="content">
		<?php echo $payment_text ?>
	</div>
</div>

<?php endif ?>

<div class="box primary">
	<h2><?php echo ___('payments.pay.title') ?></h2>
	<div class="content">
		<?php if ( ! empty($form)): ?>
			<?php echo $form ?>
		<?php elseif ( ! empty($paypal)): ?>
			<?php echo $paypal ?>
		<?php elseif ( ! empty($payu)): ?>
			<?php echo $payu ?>
		<?php endif ?>
	</div>
</div>