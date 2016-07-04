<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
return array(
	//setup env for CRON job (if we execute php script from cmd line there is empty $_SERVER['SERVER_NAME'])
	//we need this to generate url
	'server_name' => 'proffer.ie',
	'cookies' => array(
		'salt' => 'jorux1hca%i%wsta',
	),
	'language' => array(
		'default' => 'pl',
	),
	'image_driver' => 'Imagick',
);

