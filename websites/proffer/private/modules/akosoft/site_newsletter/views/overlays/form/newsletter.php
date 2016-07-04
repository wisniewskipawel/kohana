<form id="newsletter_overlay_form" action="<?php echo Route::url('site_newsletter/frontend/newsletter/submit') ?>" method="post">
	<?php echo $form->form_id->render() ?>

	<?php if($agreements = $form->get('agreements')): ?>
	<?php echo $agreements->accept_terms->html('id', 'accept_terms_overlay')->render(TRUE) ?>
	<?php echo $agreements->accept_trading->html('id', 'accept_trading_overlay')->render(TRUE) ?>

	<div id="<?php echo $agreements->accept_ads->html('row_id') ?>" class="control-group input-chbox">
		<?php echo $agreements->accept_ads->html('label') ?>
		<div class="controls">
			<label><input type="radio" name="accept_ads" value="1" /> <?php echo ___('newsletter.boxes.sidebar.accept.yes') ?></label>
			<label><input type="radio" name="accept_ads" value="0" /> <?php echo ___('newsletter.boxes.sidebar.accept.no') ?></label>
		</div>
	</div>
	<?php endif; ?>

	<div class="field_email">
		<input type="text" name="email" id="newsletter-email" placeholder="<?php echo ___('newsletter.boxes.sidebar.enter_email') ?>" value="" />
		<input type="submit" value="<?php echo ___('form.next') ?>" />
	</div>
</form>