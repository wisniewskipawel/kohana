<div class="box primary">
	<h2><?php echo ___('catalog.profile.promote.title') ?></h2>
	<div class="content">
		<?php echo $form ?>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$("#payment-info-row").hide();
	
	var $with_discount = $('#bform-with-discount-row').hide();
	$with_discount.find('input').bind('change', get_payment_info);
	
	$("input[name=payment_method]").click(function() {
		var $payment_method = $("input[name=payment_method]:checked");
		
		if($payment_method.hasClass('discount_allowed')) {
			$with_discount.show();
		} else {
			$with_discount.hide();
		}
		
		get_payment_info();
	});
	
	function get_payment_info() {
		var $payment_method = $("input[name=payment_method]:checked");
		
		var discount = 0;
		if($('#bform-with-discount').is(':checked')) {
			discount = $('#bform-discount').val();
		}
		
		main.payment.get_info(
			function(data) {
				$("#payment-info-row").show().find('#payment-info').html(data);
			}, 
			$payment_method.val(), 
			'<?php echo $payment_module->get_payment_module_name() ?>', 
			'<?php echo $payment_module->place() ?>', 
			'<?php echo $payment_module->type() ?>', 
			'default',
			discount
		);
	}

	<?php if ( ! empty($_POST['payment_method'])): ?>
		$("input[name=payment_method][value=<?php echo $_POST['payment_method'] ?>]").click();
	<?php endif ?>
});
</script>
