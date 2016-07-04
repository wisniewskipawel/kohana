<?php defined('SYSPATH') or die('No direct script access.'); ?>
<div id="notifier_nav_box" class="box">
	<div class="box-header"><?php echo ___('notifiers.boxes.nav.title') ?></div>
	<div class="content">
		<ul>
			<?php foreach($notifiers as $notifier): ?>
			<li><?php echo HTML::anchor(
				$notifier['route']->uri(), 
				$notifier['title'], 
				array(
					'class' => $route_name == Route::name($notifier['route']) ? 'active' : ''
				)) ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
