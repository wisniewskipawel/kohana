<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
return array(
	'groups' => array(
		'site_catalog' => array(
			'label' => ___('catalog.module'),
			'emails' => array(
				'send_to_company',
				'company_send',
				'catalog.new_review',
				'catalog_renew_promotion',
			),
		),
	),
);