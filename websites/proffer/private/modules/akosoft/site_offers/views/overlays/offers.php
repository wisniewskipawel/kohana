<div class="overlay" style="display: none;">
	<div id="notifier_overlay">
		<div class="overlay_header"><?php echo ___('offers.overlay.notifier.title') ?></div>
		<div class="overlay_body">
			<p><?php
			$document = Pages::get('notifier');
			echo $document->document_content;
			?></p>
			
			<?php
			$form = Bform::factory('Frontend_Offer_Notifier');
			echo $form->render('overlays/form/offers');
			?>
			
		</div>
	</div>
</div>
<script type="text/javascript">
$(function() {
	$.fancybox(
		$('.overlay').clone().show().html(),
		{
			'autoDimensions'	: true,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none'
		}
	);
});
</script>