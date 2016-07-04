<div id="ad_half_box" class="box gray ad half">
	<div class="box-header"><?php echo ___('ads.boxes.half_box.title') ?></div>
	<div class="content">
		<?php echo ads::show(ads::PLACE_E) ?>
		
		<div class="box-content-link">
			&raquo; <?php echo HTML::anchor(Pages::uri('ads'), ___('ads.boxes.half_box.add_btn')) ?>
		</div>
	</div>
</div>