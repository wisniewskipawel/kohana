<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'types' => array(
		'catalog_companies' => array(
			'catalog_company_big' => array(
				'flag' => 'ccb',
				'resize' => TRUE,
				'crop' => FALSE,
				'width' => 800,
				'height' => 600,
			),
			'catalog_company_thumb_big' => array(
				'flag'  => 'cctb',
				'resize' => TRUE,
				'crop' => FALSE,
				'width' => 375,
				'height' => 280,
			),
			'catalog_company_list' => array(
				'extension' => 'png',
				'allow_transparent' => TRUE,
				'flag'  => 'cctl',
				'resize' => TRUE,
				'crop' => FALSE,
				'width' => 152,
				'height' => 114,
			),
		),
	)
);
