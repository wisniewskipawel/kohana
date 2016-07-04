<?php if($collection->option('decorate')): ?>
<div class="collection collection_<?php echo $collection->option('name') ?>">
<?php endif; ?>
		
<?php 
foreach ($collection->get_all() as $e)
	echo $e->render(TRUE);
?>
	
<?php if($collection->option('decorate')): ?>
</div>
<?php endif; ?>

<script>
$(document).ready(function() {
	$('.collection_<?php echo $collection->option('name') ?>').on('change', 'input', get_payment_info);
	get_payment_info();
	
	function get_payment_info() {
		var $context = $('.collection_<?php echo $collection->option('name') ?>');
		var $payment_info_row = $context.find("#payment-info-row").hide();
		var $with_discount_row = $context.find('#bform-with-discount-row');
		var $payment_method = $context.find("input[name=payment_method]:checked");
		
		if($payment_method.hasClass('discount_allowed')) {
			$with_discount_row.show();
		} else {
			$with_discount_row.hide();
		}
		
		var discount = 0;
		if($with_discount_row.find('#bform-with-discount').is(':checked')) {
			discount = $context.find('#bform-discount').val();
		}
		
		main.payment.get_info(
			function(data) {
				$payment_info_row.show().find('#payment-info').html(data);
			}, 
			$payment_method.val(), 
			'<?php echo $payment_module->get_payment_module_name() ?>', 
			'<?php echo $payment_module->place() ?>', 
			'<?php echo $payment_module->type() ?>', 
			'default',
			discount
		);
	}
});
</script>