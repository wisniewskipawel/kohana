<div id="<?php echo $driver->html('row_id') ?>" class="control-group input offer_price_discount_field <?php echo $driver->html('row_class') ?>">
	
	<div class="label">
		<?php echo Form::select(
			$driver->html('name').'[type]', 
			$driver->get_types(), 
			$driver->get_submitted('type'),
			array(
				'class' => 'offer_price_discount_select'
			)
		); ?>
		
		<?php echo $driver->data('required') ? '<span class="required">*</span>' : ''; ?>
	</div>
	
	<div class="controls">
		<?php if ($driver->html('html_before')): ?>
			<div class="<?php echo Kohana::$config->load('bform.css.drivers.html_before_class') ?>"><?php echo $driver->html('html_before') ?></div>
		<?php endif ?>
		
		<?php echo Form::input(
			$driver->html('name').'[value]', 
			$driver->get_submitted('value'),
			array(
				'id' => $driver->html('id'), 
				'class' => $driver->html('class'), 
				'size' => $driver->html('size'), 
				'title' => $driver->html('title'),
				'placeholder' => $driver->html('placeholder'), 
			)
		); ?>

		<?php if ($driver->html('html_after')): ?>
			<div class="<?php echo Kohana::$config->load('bform.css.drivers.html_after_class') ?>"><?php echo $driver->html('html_after') ?></div>
		<?php endif ?>
	</div>
</div>

<script>
$(function() {
	calculate_discount();
	
	$('#<?php echo $driver->html('row_id') ?>, #bform-offer-price-old-row').on('change', 'input', calculate_discount);
	$('#<?php echo $driver->html('row_id') ?>').on('change', '.offer_price_discount_select', function() {
		$('#<?php echo $driver->html('id') ?>').val('');
		$('#<?php echo $driver->html('row_id') ?>').find('.discount_text').remove();
	});
	
	function calculate_discount() {
		var $discount_row = $('#<?php echo $driver->html('row_id') ?>');
		var $form = $discount_row.parents('form');
		var discount_type = $discount_row.find('.offer_price_discount_select').val();
		var $discount_value = $discount_row.find('#<?php echo $driver->html('id') ?>');
		var discount_value = $discount_value.val();
		var price_old = parse_price($form.find('#bform-offer-price-old').val());
		
		$discount_row.find('.discount_text').remove();
		
		if(price_old && discount_value) {
			var discount, discount_proc, price_new;
			
			if(discount_type == 'proc') {
				discount_proc = parseInt(discount_value);
				discount = parseFloat(price_old * (discount_proc / 100));
				price_new = parseFloat(price_old - discount);
			} else if(discount_type == 'disc') {
				discount = parse_price(discount_value);
				price_new = parseFloat(price_old - discount);
				discount_proc = parseInt((discount / price_old) * 100);
			} else {
				price_new = parse_price(discount_value);
				discount = parseFloat(price_old - price_new);
				discount_proc = parseInt((discount / price_old) * 100);
			}
			
			if(price_old > price_new && price_new > 0)
			{
				$discount_value.after(
					'<div class="discount_text"><?php echo ___('offers.forms.discount_text', array(':currency' => payment::currency('short'))) ?></div>'
						.replace(':price_new', price_new.toFixed(2))
						.replace(':discount_proc', discount_proc)
						.replace(':discount', discount.toFixed(2))
				);
			}
		}
		
		function parse_price(price) {
			price = price.replace(',', '.').replace('/[^0-9\.]/', '');
			
			if(price) return parseFloat(price);

			return 0;
		}
	}
});
</script>