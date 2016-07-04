<?php

if (class_exists('WPLessPlugin')){
	$less = WPLessPlugin::getInstance();

	$less->setVariables(array(
		'theme-color1'                 => '#a6ce39',
		'theme-color3'                 => '#009bd6',
	));

	// get options and set custom variables
	global $petsitter_data;

	// Colors
	if ($petsitter_data['theme-color1']) {
		$less->addVariable('theme-color1',$petsitter_data['theme-color1']);
	}
	if ($petsitter_data['theme-color3']) {
		$less->addVariable('theme-color3',$petsitter_data['theme-color3']);
	}
}
?>