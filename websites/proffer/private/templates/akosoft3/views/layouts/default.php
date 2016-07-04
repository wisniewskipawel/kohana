<?php if (Modules::enabled('site_ads')): ?>
<?php echo ads::show(ads::PLACE_D) ?>
<?php echo ads::show(ads::PLACE_D2) ?>
<?php endif ?>

<?php $sidebar_size = isset($sidebar_size) ? $sidebar_size : 3; ?>
<div class="row">
	
	<div id="sidebar" class="col-md-<?php echo $sidebar_size ?>">
		<?php 
		echo isset($sidebar) ? $sidebar : Events::fire('frontend/sidebar_left');
		?>
	</div>
	
	<div class="col-md-<?php echo 12-$sidebar_size ?>">
		
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
