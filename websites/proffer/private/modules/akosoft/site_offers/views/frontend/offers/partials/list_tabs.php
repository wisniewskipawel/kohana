<?php
$from = Arr::get($filters_sorters, 'from');
?>

<ul class="tabs">
	<li><?php echo HTML::anchor(
		Request::current()->uri().URL::query(array('from' => NULL)), 
		___('offers.index.all'),
		array(
			'class' => !$from ? 'active' : NULL,
	)); ?></li>
	<li><?php echo HTML::anchor(
		Request::current()->uri().URL::query(array('from' => 'today_ending')), 
		___('offers.index.today_ending'),
		array(
			'class' => ($from == 'today_ending') ? 'active' : NULL,
	)); ?></li>
</ul>
