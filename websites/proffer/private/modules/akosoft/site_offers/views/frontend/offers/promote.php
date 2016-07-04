<div id="promote_offer_box" class="box primary">
	<h2><?php echo ___('offers.promote.title') ?></h2>
	<div class="content">
		
		<?php if(isset($form_promote)): ?>
		<div class="promotion_type">
			
			<img src="<?php echo URL::site('/media/offers/img/promotion/top_offer.png') ?>" alt="<?php echo HTML::chars(___('offers.promote.promotions.'.Model_Offer::DISTINCTION_PREMIUM_PLUS.'.title')) ?>" class="show" />
			
			<section>
				<div class="info">
					<h3><?php echo ___('offers.promote.promotions.'.Model_Offer::DISTINCTION_PREMIUM_PLUS.'.title') ?></h3>

					<p><?php echo ___('offers.promote.promotions.'.Model_Offer::DISTINCTION_PREMIUM_PLUS.'.description') ?></p>
				</div>

				<form action="" id="offer_promote_payment" method="post" class="bform">
				
					<div class="payment-method-row">
						<label><?php echo ___('payments.forms.payment_method.info') ?>:</label>

						<div class="controls">
							<?php echo $form_promote->payment_method->render() ?>
						</div>
					</div>

					<div class="payment-text"></div>
					
					<?php echo $form_promote->form_id->render() ?>
					<input type="submit" value="<?php echo ___('form.next') ?>" />
				</form>
			</section>
		</div>
		
		<script>
		$(document).ready(function() {

			$('form.promote-offer input[type="radio"]').bind('change', function() {
				var $input = $(this);
				var $form = $input.parents("form");
				var $payment_text = $form.find('.payment-text').empty();

				main.payment.get_info(
					function(data) { 
						$payment_text.show().html(data);
					}, 
					$input.val(),
					'<?php echo $payment_promote->get_payment_module_name() ?>', 
					'<?php echo $payment_promote->place() ?>', 
					$form.find('input[name="type"]').val(), 
					'default'
				);

			});
		});
		</script>
		<?php endif; ?>
		
		<?php if(isset($form_add)): ?>
		
		<div class="promotion_type no_promotion">
			
			<section>
				<div class="info">
					<h3><?php echo ___('offers.promote.no_promotion') ?></h3>
				</div>

				<form enctype="multipart/form-data" action="" id="offer_add_payment" method="post" class="bform">
				
					<div class="payment-method-row">
						<label><?php echo ___('payments.forms.payment_method.info') ?>:</label>

						<div class="controls">
							<?php echo $form_add->payment_method->render() ?>
						</div>
					</div>

					<div class="payment-text"></div>

					<?php echo $form_add->form_id->render() ?>
					<input type="submit" value="<?php echo ___('form.next') ?>" />
				</form>
				
			</section>
		</div>
		
		<script>
			$(document).ready(function() {
				$('#offer_add_payment input[type="radio"]').bind('change', function() {
					var $input = $(this);
					var $form = $input.parents("form");
					var $payment_text = $form.find('.payment-text').empty();

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

				});
			});
		</script>
		
		<?php else: ?>
		
		<div class="no-promotion">
			<a href="<?php echo Route::url('site_offers/frontend/offers/show', array(
				'offer_id' => $offer->pk(), 
				'title' => URL::title($offer->offer_title)
				), 'http') . '?preview=true' ?>" class="btn"><?php echo ___('offers.promote.no_promotion') ?></a>
		</div>
		
		<?php endif; ?>
		
	</div>
</div>
