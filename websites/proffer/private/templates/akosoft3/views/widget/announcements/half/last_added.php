<?php
$limit = Kohana::$config->load('modules.site_announcements.index_half_boxes.limit');
$last_added = ORM::factory('Announcement')->get_last($limit ? $limit : 3);
?>
<div id="last-added_box" class="box primary col-md-6">
	<div class="box-header"><?php echo ___('announcements.boxes.last.title') ?></div>
	<div class="content">
		<?php if(count($last_added)): ?>
		<?php echo View::factory('frontend/announcements/partials/list_half_box')
			->set('announcements', $last_added); ?>
		<?php else: ?>
		<div class="no_results"><?php echo ___('announcements.list.no_results') ?></div>
		<?php endif; ?>
	</div>
</div>