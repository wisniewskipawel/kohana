<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
return array(
	'groups' => array(
		'site_newsletter' => array(
			'label' => ___('newsletter.module'),
			'emails' => array(
				'newsletter_confirmation',
			),
		),
	),
);