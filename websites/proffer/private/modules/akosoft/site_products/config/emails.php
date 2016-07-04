<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
return array(
	'groups' => array(
		'site_products' => array(
			'label' => ___('products.module'),
			'emails' => array(
				'product_approve',
				'product_approved',
				'send_to_product',
				'product_send_to_friend',
				'product_order_buyer',
				'product_order_seller',
				'products_expiring_registered',
				'products_expiring_not_registered',
			),
		),
	),
);