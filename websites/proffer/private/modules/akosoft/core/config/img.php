<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'types' => array(
		'global' => array(
			'original' => array(
				'flag' => 'o',
				'resize' => FALSE,
				'crop' => FALSE,
				'width' => NULL,
				'height' => NULL,
			),
		),
		'admin' => array(
			'admin_thumb' => array(
				'flag' => 'at',
				'resize' => TRUE,
				'crop' => TRUE,
				'width' => 200,
				'height' => 150,
			),
		),
	),
	'max_upload_size' => 3145728,
);
