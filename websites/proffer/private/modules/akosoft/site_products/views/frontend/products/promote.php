<div id="promote_product_box" class="box primary">
	<div class="box-header"><?php echo ___('products.promote.title') ?></div>
	<div class="content">
		<?php if($payment_add && $payment_add->is_enabled()): ?>
		
		<div class="promotion_type no_promotion">
			
			<section>
				<div class="info">
					<h3><?php echo ___('products.promote.no_promotion.title') ?></h3>
				</div>

				<form enctype="multipart/form-data" action="" id="product_add_payment" method="post" class="bform">

					<fieldset class="group">
						
						<h4><?php echo ___('payments.forms.payment_method.info') ?>:</h4>
						
						<?php 
						$providers = $payment_add->get_providers(); 

						if($providers) foreach ($providers as $provider_name => $provider): ?>
							<div class="control-group">
								<label><input class="payment-method promote-product payment-provider" type="radio" value="<?php echo $provider_name ?>" name="payment_method" /> <?php echo ___($provider->get_label()).' - <span class="price">'.$payment_add->show_price($provider).'</span>' ?></label>
							</div>
						<?php endforeach ?>

						<div class="payment-text"></div>
						
						<input type="submit" value="<?php echo ___('form.next') ?>" />
						
					</fieldset>
				</form>
			</section>
		</div>
		
		<script>
			$(document).ready(function() {
				$('#product_add_payment input[type="radio"]').bind('change', function() {
					var $input = $(this);
					var $form = $input.parents("form");
					var $payment_text = $form.find('.payment-text').empty();
					
					if($input.hasClass('payment-provider')) {
						main.payment.get_info(
							function(data) { 
								$payment_text.show().html(data);
							}, 
							$input.val(),
							'<?php echo $payment_add->get_payment_module_name() ?>', 
							'<?php echo $payment_add->place() ?>', 
							'default', 
							'default'
						);
					}
				});
			});
		</script>
		
		<?php else: ?>
		
		<div class="no-promotion">
			<span><?php echo ___('products.promote.no_promotion.title') ?></span>
			<?php echo HTML::anchor(products::uri($product).'?preview=1', ___('products.promote.no_promotion.btn'), array('class' => 'btn')) ?>
		</div>
		
		<?php endif; ?>
		
		<div class="promotion_type">
			
			<img src="<?php echo URL::site('/media/products/img/promotion/'.Model_Product::DISTINCTION_PREMIUM.'.png') ?>" alt="<?php echo HTML::chars(___('products.promote.types.'.Model_Product::DISTINCTION_PREMIUM.'.title')) ?>" class="show" />
			
			<section>
				<div class="info">
					<h3><?php echo ___('products.promote.types.'.Model_Product::DISTINCTION_PREMIUM.'.title') ?></h3>
		
					<p>
						<?php echo ___('products.promote.types.'.Model_Product::DISTINCTION_PREMIUM.'.description') ?>
					</p>
				</div>

				<form enctype="multipart/form-data" action="" method="post" class="bform promote-product">

					<fieldset class="group">

						<input type="hidden" name="product_distinction" value="<?php echo Model_Product::DISTINCTION_PREMIUM ?>" />
						
						
						<?php if(Model_Product::check_promotion_limit($product)): ?>
						
						<div class="control-group">
							<label><input class="payment-method promote-product" type="radio" value="company" name="payment_method" /> <?php echo ___('products.promote.company_free.title') ?></label>
						</div>

						<input type="submit" value="<?php echo ___('form.promote') ?>" />
						
						<?php 
						else: 
						
						$is_enabled = $payment_module->is_enabled(Model_Product::DISTINCTION_PREMIUM);
						
						 if (!$is_enabled): ?>

							<h4><?php echo ___('products.promote.types.'.Model_Product::DISTINCTION_PREMIUM.'.disabled') ?></h4>

						<?php else: ?>
							<h4><?php echo ___('payments.forms.payment_method.info') ?>:</h4>

							<?php 
							$providers = $payment_module->get_providers(Model_Product::DISTINCTION_PREMIUM); 

							if($providers) foreach ($providers as $provider_name => $provider): ?>
							<div class="control-group">
								<label><input class="payment-method promote-product payment-provider" type="radio" value="<?php echo $provider_name ?>" name="payment_method" /> <?php echo ___($provider->get_label()).' - <span class="price">'.$payment_module->show_price($provider, Model_Product::DISTINCTION_PREMIUM).'</span>' ?></label>
							</div>
							<?php endforeach ?>

							<div class="payment-text"></div>

							<input type="submit" value="<?php echo ___('form.promote') ?>" />
						<?php endif; ?>
							
						<?php endif; ?>
						
					</fieldset>
				</form>
			</section>
		</div>
		
	</div>
</div>

<script>

	$(document).ready(function() {

		$('form.promote-product input[type="radio"]').bind('change', function() {
			var $input = $(this);
			var $form = $input.parents("form");
			var $payment_text = $form.find('.payment-text').empty();

			if($input.hasClass('payment-provider')) {
				main.payment.get_info(
					function(data) { 
						$payment_text.show().html(data);
					}, 
					$input.val(),
					'<?php echo $payment_module->get_payment_module_name() ?>', 
					'<?php echo $payment_module->place() ?>', 
					$form.find('input[name="product_distinction"]').val(), 
					'default'
				);
			}
		});
	});

</script>