<?php
$state = Arr::get($filters_sorters, 'state');
?>
<ul class="tabs">
	<li><?php echo HTML::anchor(
		Request::current()->uri().URL::query(array('state' => NULL)), 
		___('products.list.tabs.all'),
		array(
			'class' => !$state ? 'active' : NULL,
	)); ?></li>
	<li><?php echo HTML::anchor(
		Request::current()->uri().URL::query(array('state' => 1)), 
		___('products.list.tabs.1'),
		array(
			'class' => $state == 1 ? 'active' : NULL,
	)); ?></li>
	<li><?php echo HTML::anchor(
		Request::current()->uri().URL::query(array('state' => 2)), 
		___('products.list.tabs.2'),
		array(
			'class' => $state == 2 ? 'active' : NULL,
	)); ?></li>
</ul>
