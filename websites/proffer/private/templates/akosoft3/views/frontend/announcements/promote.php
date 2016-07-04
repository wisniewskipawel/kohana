<div id="promote_announcement_box" class="box primary">
	<div class="box-header">
		<?php echo ___('announcements.promote.title') ?>
	</div>
	<div class="content">
		<?php if($payment_add && $payment_add->is_enabled()): ?>
		
		<div class="promotion_type no_promotion">
			
			<section>
				<div class="info">
					<h3><?php echo ___('announcements.promote.no_promotion') ?></h3>
				</div>

				<form enctype="multipart/form-data" action="" id="announcement_add_payment" method="post" class="bform">

					<fieldset class="group">
						
						<h4><?php echo ___('payments.forms.payment_method.info') ?>:</h4>

						<div class="payment_method_group">
							<div class="controls">
								<?php 
								$providers = $payment_add->get_providers(); 

								if($providers) foreach ($providers as $provider_name => $provider): ?>
								<label>
									<input class="payment-method promote-offer" type="radio" value="<?php echo $provider_name ?>" name="payment_method" /> 
									<?php echo ___($provider->get_label()).' - <span class="price">'.$payment_add->show_price($provider).'</span>' ?>
								</label>
								<?php endforeach ?>
							</div>
						</div>
						
						<div class="payment-text"></div>

						<input type="submit" value="<?php echo ___('form.next') ?>" />
						
					</fieldset>
				</form>
			</section>
		</div>
		
		<script>
			$(document).ready(function() {
				$('#announcement_add_payment input[type="radio"]').bind('change', function() {
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
			<span><?php echo ___('announcements.promote.no_promotion') ?></span>
			<?php echo HTML::anchor(announcements::uri($announcement).'?preview=1', ___('announcements.promote.no_promotion.btn'), array('class' => 'btn')) ?>
		</div>
		
		<?php endif; ?>
		
		<?php if(announcements::is_distinction_enabled(Model_Announcement::DISTINCTION_PREMIUM_PLUS)): ?>
		<div class="promotion_type">
			
			<img src="<?php echo URL::site('/media/announcements/img/promotion/premium_plus.png') ?>" class="show" />
			
			<section>
				<div class="info">
					<h3><?php echo ___('announcements.promote.premium_plus.title') ?></h3>
		
					<p>
						<?php echo ___('announcements.promote.premium_plus.description') ?>
					</p>
				</div>

				<form enctype="multipart/form-data" action="" method="post" class="bform promote-announcement">

					<fieldset class="group">

						<input type="hidden" name="announcement_distinction" value="<?php echo Model_Announcement::DISTINCTION_PREMIUM_PLUS ?>" />
						<input type="hidden" name="type" value="premium_plus" />
						
						<?php 
						$is_enabled = $payment_module->is_enabled('premium_plus');
						if (!$is_enabled AND $allow_free === TRUE): ?>

							<h4><?php echo ___('announcements.promote.promotion.free') ?></h4>

							<input type="submit" value="<?php echo ___('form.promote') ?>" />
							
						<?php elseif (!$is_enabled): ?>

							<h4><?php echo ___('announcements.promote.promotion.disabled') ?></h4>

						<?php else: ?>
							<h4><?php echo ___('payments.forms.payment_method.info') ?>:</h4>

							<div class="payment_method_group">
								<div class="controls">
									<?php 
									$providers = $payment_module->get_providers('premium_plus'); 

									if($providers) foreach ($providers as $provider_name => $provider): ?>
									<label>
										<input class="payment-method promote-offer" type="radio" value="<?php echo $provider_name ?>" name="payment_method" /> 
										<?php echo ___($provider->get_label()).' - <span class="price">'.$payment_module->show_price($provider, 'premium_plus').'</span>' ?>
									</label>
									<?php endforeach ?>

									<?php if ($user && intval($user->data->announcement_points) > 0): ?>
									<label><input class="payment-method promote-announcement" type="radio" value="packet" name="payment_method" /> <?php echo ___('announcements.promote.promo_points', array(':promo' => $user->data->announcement_points)) ?></label>
									<?php endif; ?>
								</div>
							</div>

							<div class="payment-text"></div>

							<input type="submit" value="<?php echo ___('form.promote') ?>" />
						<?php endif; ?>
						
					</fieldset>
				</form>
			</section>
		</div>
		<?php endif; ?>
		
		<?php if(announcements::is_distinction_enabled(Model_Announcement::DISTINCTION_PREMIUM)): ?>
		<div class="promotion_type">
			
			<img src="<?php echo URL::site('/media/announcements/img/promotion/premium.png') ?>" class="show" />
			
			<section>
				<div class="info">
					<h3><?php echo ___('announcements.promote.premium.title') ?></h3>
		
					<p><?php echo ___('announcements.promote.premium.description') ?></p>
				</div>

				<form enctype="multipart/form-data" action="" method="post" class="bform promote-announcement">

					<fieldset class="group">

						<input type="hidden" name="announcement_distinction" value="<?php echo Model_Announcement::DISTINCTION_PREMIUM ?>" />
						<input type="hidden" name="type" value="premium" />
						
						<?php 
						$is_enabled = $payment_module->is_enabled('premium');
						if (!$is_enabled AND $allow_free === TRUE): ?>

							<h4><?php echo ___('announcements.promote.promotion.free') ?></h4>

							<input type="submit" value="<?php echo ___('form.promote') ?>" />
							
						<?php elseif (!$is_enabled): ?>

							<h4><?php echo ___('announcements.promote.promotion.disabled') ?></h4>

						<?php else: ?>
							<h4><?php echo ___('payments.forms.payment_method.info') ?>:</h4>

							<div class="payment_method_group">
								<div class="controls">
									<?php 
									$providers = $payment_module->get_providers('premium'); 

									if($providers) foreach ($providers as $provider_name => $provider): ?>
									<label>
										<input class="payment-method promote-offer" type="radio" value="<?php echo $provider_name ?>" name="payment_method" /> 
										<?php echo ___($provider->get_label()).' - <span class="price">'.$payment_module->show_price($provider, 'premium').'</span>' ?>
									</label>
									<?php endforeach ?>
								</div>
							</div>

							<div class="payment-text"></div>
							
							<input type="submit" value="<?php echo ___('form.promote') ?>" />
						<?php endif; ?>

					</fieldset>
				</form>
			</section>
		</div>
		<?php endif; ?>
		
		<?php if(announcements::is_distinction_enabled(Model_Announcement::DISTINCTION_DISTINCTION)): ?>
		<div class="promotion_type">
			
			<img src="<?php echo URL::site('/media/announcements/img/promotion/distinct.png') ?>" class="show" />
			
			<section>
				<div class="info">
					<h3><?php echo ___('announcements.promote.distinction.title') ?></h3>
		
					<p><?php echo ___('announcements.promote.distinction.description') ?></p>
				</div>

				<form enctype="multipart/form-data" action="" method="post" class="bform promote-announcement">

					<fieldset class="group">

						<input type="hidden" name="announcement_distinction" value="<?php echo Model_Announcement::DISTINCTION_DISTINCTION ?>" />
						<input type="hidden" name="type" value="distinction" />
						
						<?php 
						$is_enabled = $payment_module->is_enabled('distinction');
						if (!$is_enabled AND $allow_free === TRUE): ?>

							<h4><?php echo ___('announcements.promote.promotion.free') ?></h4>

							<input type="submit" value="<?php echo ___('form.promote') ?>" />
							
						<?php elseif (!$is_enabled): ?>

							<h4><?php echo ___('announcements.promote.promotion.disabled') ?></h4>

						<?php else: ?>
							<h4><?php echo ___('payments.forms.payment_method.info') ?>:</h4>

							<div class="payment_method_group">
								<div class="controls">
									<?php 
									$providers = $payment_module->get_providers('distinction'); 

									if($providers) foreach ($providers as $provider_name => $provider): ?>
									<label>
										<input class="payment-method promote-offer" type="radio" value="<?php echo $provider_name ?>" name="payment_method" />  
										<?php echo ___($provider->get_label()).' - <span class="price">'.$payment_module->show_price($provider, 'distinction').'</span>' ?>
									</label>
									<?php endforeach ?>
								</div>
							</div>

							<div class="payment-text"></div>
							
							<input type="submit" value="<?php echo ___('form.promote') ?>" />
						<?php endif; ?>

					</fieldset>
				</form>
			</section>
		</div>
		<?php endif; ?>
		
	</div>
</div>

<script>

	$(document).ready(function() {

		$('form.promote-announcement input[type="radio"]').bind('change', function() {
			var $input = $(this);
			var $form = $input.parents("form");
			var $payment_text = $form.find('.payment-text').empty();

			main.payment.get_info(
				function(data) { 
					$payment_text.show().html(data);
				}, 
				$input.val(),
				'<?php echo $payment_module->get_payment_module_name() ?>', 
				'<?php echo $payment_module->place() ?>', 
				$form.find('input[name="type"]').val(), 
				'default'
			);

		});
	});

</script>