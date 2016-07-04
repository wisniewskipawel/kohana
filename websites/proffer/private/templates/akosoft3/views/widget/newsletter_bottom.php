<div id="newsletter_section">
	<div class="container">
		<h5><?php echo ___('template.newsletter.title') ?>:</h5>
		
		<form id="newsletter_form" action="<?php echo Route::url('site_newsletter/frontend/newsletter/submit') ?>" method="post" class="row">
			<?php echo $form->form_id->render() ?>
			
			<?php if($agreements = $form->get('agreements')): ?>
			
			<div class="col-md-6">
				<?php echo $agreements->accept_terms->html('id', 'accept_terms2')->render(TRUE) ?>
				<?php echo $agreements->accept_trading->html('id', 'accept_trading2')->render(TRUE) ?>
			</div>
			
			<div class="control-group input-chbox col-md-3">
				<div class="controls">
					<label><input type="radio" name="accept_ads" value="1" /> <?php echo ___('newsletter.boxes.sidebar.accept.yes') ?></label>
					<label><input type="radio" name="accept_ads" value="0" /> <?php echo ___('newsletter.boxes.sidebar.accept.no') ?></label>
				</div>
				<?php echo $agreements->accept_ads->html('label') ?>
			</div>
			
			<?php endif; ?>

			<div class="col-md-3">
				<div class="control-group field_email">
					<input type="text" name="email" id="newsletter-email" class="clear-on-focus" title="<?php echo ___('newsletter.boxes.sidebar.enter_email') ?>" value="<?php echo ___('newsletter.boxes.sidebar.enter_email') ?>" />
					<input type="submit" value="<?php echo ___('form.next') ?>" />
				</div>
			</div>
		</form>
	</div>
</div>
