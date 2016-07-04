<div class="overlay" style="display: none;">
	<div id="newsletter_overlay">
		<div class="overlay_header"><?php echo ___('newsletter.overlay.title') ?></div>
		<div class="overlay_body">
			<p><?php echo ___('newsletter.overlay.info') ?></p>

			<?php
			$form = Bform::factory('Frontend_Newsletter_Subscribe');
			echo $form->render('overlays/form/newsletter');
			?>

			<p><?php echo ___('newsletter.overlay.privacy_info', array(
				':privacy_link' => HTML::anchor(Pages::uri('privacy'), ___('newsletter.overlay.privacy_link_title')),
			)) ?></p>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function() {
	$.fancybox(
		$('.overlay').clone().show().html(),
		{
			'autoDimensions'	: false,
			'width'         		: 'auto',
			'height'        		: 'auto',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none'
		}
	);
});
</script>