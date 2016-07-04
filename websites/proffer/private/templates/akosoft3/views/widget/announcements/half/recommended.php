<?php
$limit = Kohana::$config->load('modules.site_announcements.index_half_boxes.limit');
$popular = ORM::factory('Announcement')->get_recommended($limit ? $limit : 3);
?>
<div id="recommended_box" class="box primary col-md-6">
	<div class="box-header"><?php echo ___('announcements.boxes.recommended.title') ?></div>
	<div class="content">
		<?php if(count($popular)): ?>
		<?php echo View::factory('frontend/announcements/partials/list_half_box')
			->set('announcements', $popular); ?>
		<?php else: ?>
		<div class="no_results"><?php echo ___('announcements.list.no_results') ?></div>
		<?php endif; ?>
	</div>
</div>
