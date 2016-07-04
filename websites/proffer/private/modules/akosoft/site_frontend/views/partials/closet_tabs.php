<ul class="tabs">
	<?php foreach(Events::fire('profile/nav', array('action' => 'closet', 'closet_counter' => TRUE), TRUE) as $html): ?>
	<li><?php echo $html ?></li>
	<?php endforeach; ?>
</ul>
