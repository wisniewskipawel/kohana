<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

return array(
	'site_products' => array(
		'name' => ___('products.title'),
		'secure_actions' => array(
			'admin/products/index' => ___('products.permissions.admin.index'),
			'admin/products/add' => ___('products.permissions.admin.add'),
			'admin/products/edit' => ___('products.permissions.admin.edit'),
			'admin/products/delete' => ___('products.permissions.admin.delete'),
			'admin/products/approve' => ___('products.permissions.admin.approve'),
		),
	),
);
