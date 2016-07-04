<div class="box primary">
	<div class="box-header"><?php echo ___('payments.forms.payment_method.label') ?></div>
	<div class="content">
		<?php echo $form ?>
	</div>
</div>
<script>
$(document).ready(function() {
	$("#payment-info-row").hide();
	$('input[name="payment_method"]').change(get_payment_info);
	get_payment_info();
	
	function get_payment_info() {
		var $payment_method =$('input[name="payment_method"]:checked');
		
		if($payment_method.length) {
			main.payment.get_info(
				function(data) {
					$("#payment-info-row").show().find('#payment-info').html(data);
				}, 
				$payment_method.val(), 
				'<?php echo $payment_module->get_payment_module_name() ?>', 
				'<?php echo $payment_module->place() ?>', 
				'<?php echo $payment_module->get_type() ?>', 
				'default',
				0
			);
		}
	}
});
</script>