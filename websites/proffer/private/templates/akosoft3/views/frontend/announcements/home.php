<div class="box announcements list_box">
	<div class="box-header">
		<span class="box-header-title"><?php echo ___('template.announcements.boxes.home.title') ?></span>
		<a class="box-header-right" href="<?php echo Route::url('site_announcements/frontend/announcements/index') ?>"><?php echo ___('template.announcements.boxes.home.more') ?></a>
		<span class="box-tabs">
			<a <?php if ($from == 'recent'): ?>class="active"<?php endif ?> href="<?php echo URL::query(array('from' => 'recent')) ?>"><?php echo ___('template.announcements.boxes.home.recent') ?></a>
			<a <?php if ($from == 'popular'): ?>class="active"<?php endif ?> href="<?php echo URL::query(array('from' => 'popular')) ?>"><?php echo ___('template.announcements.boxes.home.popular') ?></a>
			<a <?php if ($from == 'promoted'): ?>class="active"<?php endif ?> href="<?php echo URL::query(array('from' => 'promoted')) ?>"><?php echo ___('template.announcements.boxes.home.promoted') ?></a>
		</span>
	</div>
	<div class="content">
		
		<?php echo View::factory('frontend/announcements/_announcements_list')
			->set('announcements', $announcements)
			->bind('ad', $ad) 
		?>

	</div>
</div>