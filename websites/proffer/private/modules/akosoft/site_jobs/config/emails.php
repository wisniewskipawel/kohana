<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
return array(
	'groups' => array(
		'site_jobs' => array(
			'label' => ___('jobs.module'),
			'emails' => array(
				'jobs.send_to_friend',
				'jobs.contact',
				'jobs.comment_add',
				'jobs.reply_add',
				'jobs.expired',
				'jobs.notifier',
			),
		),
	),
);