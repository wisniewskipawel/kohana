<div class="box gray newsletter">
	<div class="box-header"><?php echo ___('newsletter.boxes.sidebar.title') ?></div>
	<div class="content">
		<label><?php echo ___('newsletter.boxes.sidebar.info') ?></label>

		<form id="newsletter_form" action="<?php echo Route::url('site_newsletter/frontend/newsletter/submit') ?>" method="post">
			<?php echo $form->form_id->render() ?>
			
			<?php if($agreements = $form->get('agreements')): ?>
			<?php echo $agreements->accept_terms->html('id', 'accept_terms2')->render(TRUE) ?>
			<?php echo $agreements->accept_trading->html('id', 'accept_trading2')->render(TRUE) ?>
			
			<div class="control-group input-chbox">
				<?php echo $agreements->accept_ads->html('label') ?>
				<div class="controls">
					<label><input type="radio" name="accept_ads" value="1" /> <?php echo ___('newsletter.boxes.sidebar.accept.yes') ?></label>
					<label><input type="radio" name="accept_ads" value="0" /> <?php echo ___('newsletter.boxes.sidebar.accept.no') ?></label>
				</div>
			</div>
			<?php endif; ?>
			
			<div class="field_email">
				<input type="text" name="email" id="newsletter-email" class="clear-on-focus" title="<?php echo ___('newsletter.boxes.sidebar.enter_email') ?>" value="<?php echo ___('newsletter.boxes.sidebar.enter_email') ?>" />
				<input type="submit" value="<?php echo ___('form.next') ?>" />
			</div>
		</form>

		<div class="box-content-link">
			&raquo; <?php echo HTML::anchor(Pages::uri('privacy'), ___('documents.route.privacy')) ?>
		</div>

		<div class="clearfix"></div>
	</div>
</div>