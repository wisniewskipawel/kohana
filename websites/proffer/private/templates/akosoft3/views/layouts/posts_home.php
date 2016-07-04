<?php if (Modules::enabled('site_ads')): ?>
<?php echo ads::show(ads::PLACE_D) ?>
<?php echo ads::show(ads::PLACE_D2) ?>
<?php endif ?>
<div id="posts_home_template">
	
	<?php echo FlashInfo::render() ?>
	
	<div class="row">
		<div class="col-md-8">
			<?php echo Widget_Box::factory('posts/slider')->render() ?>
			
			<?php if(Modules::enabled('site_ads')) echo ads::show(ads::PLACE_AB) ?>
			
			<?php echo Widget_Box::factory('posts/category')->render() ?>

			<?php if(Modules::enabled('site_forum'))
				echo Widget_Box::factory('forum/threads/active')->render() ?>
		</div>
		
		<div id="sidebar" class="col-md-4">
			<?php
			echo View::factory('layouts/posts/sidebar')
				->set('is_home', TRUE)
				->render();
			?>
		</div>
		
	</div>
	
	<div class="clear"></div>
</div>