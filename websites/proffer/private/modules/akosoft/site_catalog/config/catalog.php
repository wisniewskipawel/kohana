<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

return array(
	'header_tab_title' => ___('catalog.title'),
	'promotion_types' => array(
		'basic' => array(
			'id' => Model_Catalog_Company::PROMOTION_TYPE_BASIC,
			'enabled' => TRUE,
			'slug' => 'basic',
			'limits' => array(
				'categories' => 1,
				'images' => 0,
				'products' => FALSE,
				'keywords' => FALSE,
				'hours' => FALSE,
			),
		),
		'premium' => array(
			'id' => Model_Catalog_Company::PROMOTION_TYPE_PREMIUM,
			'enabled' => TRUE,
			'slug' => 'premium',
			'limits' => array(
				'categories' => 3,
				'images' => 5,
				'products' => FALSE,
				'keywords' => TRUE,
				'hours' => TRUE,
				'date_span' => Kohana::$config->load('modules.site_catalog.promotion_months.'.Model_Catalog_Company::PROMOTION_TYPE_PREMIUM) * Date::MONTH,
			),
		),
		'premium_plus' => array(
			'id' => Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS,
			'enabled' => TRUE,
			'slug' => 'premium_plus',
			'limits' => array(
				'categories' => 5,
				'images' => 10,
				'products' => TRUE,
				'keywords' => TRUE,
				'hours' => TRUE,
				'date_span' => Kohana::$config->load('modules.site_catalog.promotion_months.'.Model_Catalog_Company::PROMOTION_TYPE_PREMIUM_PLUS) * Date::MONTH,
			),
		),
	),
);