<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

return array(
	'site_catalog' => array(
		'name' => ___('catalog.title'),
		'secure_actions' => array(
			'admin/catalog/companies/index' => ___('catalog.permissions.admin.companies.index'),
			'admin/catalog/companies/add' => ___('catalog.permissions.admin.companies.add'),
			'admin/catalog/companies/edit' => ___('catalog.permissions.admin.companies.edit'),
			'admin/catalog/companies/delete' => ___('catalog.permissions.admin.companies.delete'),
			'admin/catalog/companies/approve' => ___('catalog.permissions.admin.companies.approve'),
		),
	),
);
