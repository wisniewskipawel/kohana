<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/

$hours = array();
$hours[NULL] = ___('bform.driver.hours.select.choose_hour');

for ($i = 0; $i <= 23; $i++) {
	if ($i < 10) {
		$i = sprintf('%02d', $i);
	}
	$hours[$i] = $i;
}

$minutes = array();
$minutes[NULL] = ___('bform.driver.hours.select.choose_min');

for ($i = 0; $i <= 59; $i++) {
	if ($i < 10) {
		$i = sprintf('%02d', $i);
	}
	$minutes[$i] = $i;
}

$value = $driver->html('value');
$value = explode(':', $value);

if (count($value) == 2) {
	$h = $value[0];
	$i = $value[1];
} else {
	$h = NULL;
	$i = NULL;
}


$driver_tag = '';
$driver_tag .= Form::select($driver->html('name') . '[H]', $hours, $h, array('class' => $driver->html('class')));
$driver_tag .= ' : ';
$driver_tag .= Form::select($driver->html('name') . '[i]', $minutes, $i, array('class' => $driver->html('class')));

echo $driver_tag;

