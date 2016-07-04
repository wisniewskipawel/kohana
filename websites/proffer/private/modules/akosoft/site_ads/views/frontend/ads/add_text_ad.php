<script>
	
	function get_ad_payment_text($payment_info)
	{
		var availability = $("#bform-ad-availability").val();
		var payment_method = $("input.payment-method:checked").val();

		if(!availability || !payment_method)
			return false;
		
		main.payment.get_info(
			$payment_info, 
			'<?php echo $payment_module->get_module_name() ?>', 
			'<?php echo $payment_module->place() ?>', 
			availability, 
			payment_method
		);
	}
	
	$(document).ready(function() {
		
		var $payment_info = $("#payment-info").hide();
		
		$("input.payment-method").click(function() {
			get_ad_payment_text($payment_info);
		});
		
		$("#bform-ad-availability").change(function() {
			get_ad_payment_text($payment_info);
		});
		
		get_ad_payment_text($payment_info);
		
	});
</script>

<div class="box primary">
	<h2><?php echo $document->document_title ?></h2>
	<div class="content">
		<?php echo $document->document_content ?>
	</div>
</div>

<div class="box primary">
	<h2><?php echo ___('ads.add_text.title') ?></h2>
	<div class="content">
		<?php echo $form ?>
	</div>
</div>