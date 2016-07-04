<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'types' => array(
		'products' => array(
			'product_show_big' => array(
				'flag' => 'psb',
				'resize' => TRUE,
				'crop' => FALSE,
				'width' => 355,
				'height' => 266,
				'watermark' => TRUE,
			),
			'product_big' => array(
				'flag' => 'pb',
				'resize' => TRUE,
				'crop' => FALSE,
				'width' => 1024,
				'height' => 768,
				'watermark' => TRUE,
			),
			'product_list' => array(
				'flag' => 'pl',
				'resize' => TRUE,
				'crop' => FALSE,
				'width' => 150,
				'height' => 113,
				'watermark' => TRUE,
			),
		),
	)
);
