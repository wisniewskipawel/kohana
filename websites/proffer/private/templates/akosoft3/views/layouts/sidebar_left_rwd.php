<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

if (Modules::enabled('site_ads')): ?>
<?php echo ads::show(ads::PLACE_D) ?>
<?php echo ads::show(ads::PLACE_D2) ?>
<?php endif ?>

<div class="row">
	
	<div id="sidebar" class="col-lg-3 col-md-4">
		<?php if(isset($sidebar)) echo $sidebar ?>
	</div>
	
	<div class="col-lg-9 col-md-8">
		
		<div id="content" class="row">
			<div class="col-md-12">
				<div id="flashinfo">
					<?php echo FlashInfo::render() ?>
				</div>

				<?php echo @$content ?>
			</div>
		</div>

		<div class="main_bottom row">
			<?php echo Events::fire('frontend/main/bottom') ?>
		</div>
		
	</div>
	
</div>