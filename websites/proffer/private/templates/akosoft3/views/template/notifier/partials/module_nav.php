<?php 
$notifiers = Events::fire('notifiers/menu', NULL, TRUE);

if($notifiers AND count($notifiers) > 1): ?>
<div id="notifier_nav_side">
	
	<nav id="notifier_nav">
		<ul class="nav navbar-nav">
			<?php foreach($notifiers as $notifier): ?>
			<li><?php echo HTML::anchor(
				$notifier['route']->uri(), 
				$notifier['title'], 
				array(
					'class' => ($current_route_name == Route::name($notifier['route']) ? 'active' : '')
				)) ?></li>
			<?php endforeach; ?>
		</ul>
	</nav>
	
</div>
<?php endif; ?>