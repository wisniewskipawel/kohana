<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
return array(
	'groups' => array(
		'site_ads' => array(
			'label' => ___('ads.module'),
			'emails' => array(
				'ad_expiring',
				'adsystem_create_user',
				'adsystem_info',
			),
		),
	),
);