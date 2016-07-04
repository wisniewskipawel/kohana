<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

return array(
	'site_jobs' => array(
		'name' => ___('jobs.module.name'),
		'secure_actions' => array(
			'admin/jobs/index' => ___('jobs.permissions.admin.index'),
			'admin/jobs/add' => ___('jobs.permissions.admin.add'),
			'admin/jobs/edit' => ___('jobs.permissions.admin.edit'),
			'admin/jobs/delete' => ___('jobs.permissions.admin.delete'),
			'admin/jobs/approve' => ___('jobs.permissions.admin.approve'),
		),
	),
);
