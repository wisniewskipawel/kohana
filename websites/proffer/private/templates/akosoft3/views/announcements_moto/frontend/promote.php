<div id="promote_announcement_box" class="box primary">
	<div class="box-header"><?php echo $current_module->trans('promote.title') ?></div>
	<div class="content">
		<?php if($payment_add && $payment_add->is_enabled()): ?>
		
		<div class="promotion_type no_promotion">
			
			<section>
				<div class="info">
					<h3><?php echo $current_module->trans('promote.no_promotion') ?></h3>
				</div>

				<form enctype="multipart/form-data" action="" id="announcement_add_payment" method="post" class="bform">

					<fieldset class="group">
						
						<h4><?php echo ___('payments.forms.payment_method.info') ?>:</h4>

						<?php 
						$providers = $payment_add->get_providers(); 

						if($providers) foreach ($providers as $provider_name => $provider): ?>
						<div class="control-group">
							<label><input class="payment-method promote-offer" type="radio" value="<?php echo $provider_name ?>" name="payment_method" /> <?php echo ___($provider->get_label()).' - <span class="price">'.payment::price_format($payment_add->get_price($provider)).'</span>' ?></label>
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
			<span><?php echo $current_module->trans('promote.no_promotion') ?></span>
			<?php echo HTML::anchor($announcement->get_uri().'?preview=1', $current_module->trans('promote.no_promotion.btn'), array('class' => 'btn')) ?>
		</div>
		
		<?php endif; ?>
		
		<?php 
		$distinctions = array_reverse(AkoSoft\Modules\AnnouncementsMoto\Announcements::distinctions(), TRUE);
		
		foreach($distinctions as $distinction => $distinction_label): 
			$distinction_slug = AkoSoft\Modules\AnnouncementsMoto\Announcements::payment_place($distinction);
		?>
		<div class="promotion_type">
			
			<img src="<?php echo URL::site('/media/announcements_moto/img/promotion/'.$distinction_slug.'.png') ?>" class="show" />
			
			<section>
				<div class="info">
					<h3><?php echo $current_module->trans('promote.'.$distinction_slug.'.title') ?></h3>
		
					<p>
						<?php echo $current_module->trans('promote.'.$distinction_slug.'.description') ?>
					</p>
				</div>

				<form enctype="multipart/form-data" action="" method="post" class="bform promote-announcement">

					<fieldset class="group">

						<input type="hidden" name="announcement_distinction" value="<?php echo $distinction ?>" />
						<input type="hidden" name="type" value="<?php echo $distinction ?>" />
						
						<?php 
						$is_enabled = $payment_module->is_enabled($distinction);
						if(!$is_enabled AND $allow_free === TRUE): ?>

						<h4><?php echo $current_module->trans('promote.promotion.free') ?></h4>

						<input type="submit" value="<?php echo ___('form.promote') ?>" />
							
						<?php elseif (!$is_enabled): ?>

						<h4><?php echo $current_module->trans('promote.promotion.disabled') ?></h4>

						<?php else: ?>
						<h4><?php echo ___('payments.forms.payment_method.info') ?>:</h4>

						<?php 
						$providers = $payment_module->get_providers($distinction); 

						if($providers) foreach ($providers as $provider_name => $provider): ?>
						<div class="control-group">
							<label><input class="payment-method promote-offer" type="radio" value="<?php echo $provider_name ?>" name="payment_method" /> <?php echo ___($provider->get_label()).' - <span class="price">'.payment::price_format($payment_module->get_price($provider, $distinction)).'</span>' ?></label>
						</div>
						<?php endforeach ?>

						<?php if ($distinction == AkoSoft\Modules\AnnouncementsMoto\Models\Announcement::DISTINCTION_PREMIUM_PLUS AND $user_points > 0): ?>
						<div class="control-group">
							<label><input class="payment-method promote-announcement" type="radio" value="packet" name="payment_method" /> <?php echo $current_module->trans('promote.promo_points', array(':promo' => $user_points)) ?></label>
						</div>
						<?php endif; ?>

						<div class="payment-text"></div>

						<input type="submit" value="<?php echo ___('form.promote') ?>" />
						<?php endif; ?>
						
					</fieldset>
				</form>
			</section>
		</div>
		<?php endforeach; ?>
		
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