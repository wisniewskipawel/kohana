<div id="facebook_register_box" class="box primary">
	<h2><?php echo ___('users.facebook.register.title') ?></h2>
	
	<div class="content">
		<?php echo $form ?>
	</div>
</div>
<script>
$(document).ready(function() {
	
	$('#Form_Auth_Facebook_Register #bform-user-name').on('change', function() {
		var $field = $(this);
		var $field_row = $field.parents('#bform-user-name-row');
		
		$field_row.find('.controls span.error').remove();
		
		$.ajax({
			url: '<?php echo URL::site('ajax/auth/user_name_unique', 'http') ?>',
			data: { 'user_name': $field.val() },
			dataType: 'json',
			success: function(data) {
				if(!data) return;
				
				if(!data.result) {
					$field.addClass('error')
						.after('<span class="error"><?php echo ___('users.forms.validator.auth.username.error') ?></span>');
				} else {
					$field_row.find('.error').removeClass('error');
				}
			}
		});
	});
	
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
				'default', 
				'default',
				0
			);
		}
	}
});
</script>