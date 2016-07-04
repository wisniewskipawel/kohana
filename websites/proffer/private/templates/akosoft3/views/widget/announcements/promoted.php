<?php
$announcements_promoted = ORM::factory('Announcement')->get_promoted(20);

if(count($announcements_promoted)):
?>
<div id="announcements_main_top_box" class="box primary">
	<div class="box-header">
		<?php echo ___('announcements.boxes.promoted.title') ?>
		
		<a href="<?php echo Route::url('site_announcements/frontend/announcements/promoted') ?>" class="more_btn"><?php echo ___('announcements.boxes.more') ?></a>
	</div>

	<div class="content">

		<div class="tabs-wrapper slider" id="promoted-announcements">
			<div class="slider-track">
			<?php echo View::factory('frontend/announcements/_announcements_box_list')->set('announcements', $announcements_promoted) ?>
			</div>
			<a href="#" class="slider_nav  slider_nav_prev"><?php echo ___('carousel.prev') ?></a>
			<a href="#" class="slider_nav  slider_nav_next"><?php echo ___('carousel.next') ?></a>
		</div>

	</div>
</div>
<?php endif; ?>