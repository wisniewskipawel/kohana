<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'finalize' => TRUE,
	'preload'  => FALSE,
	/** 
	 * global settings 
	 */
	'settings' => array(
		/**
		 * Use the application cache for HTML Purifier
		 */
		'Cache.SerializerPath' => APPPATH.'cache',
		'CSS.AllowedProperties' => array('text-decoration', 'font-weight', 'font-style'),
		//'CSS.ForbiddenProperties' => array('background-image', 'background', 'font-size')
	),

	'forms' => array(
		'announcement' => array(
			'HTML.Allowed' => 'b,em,ul,li,ol,p,span[style],br,div,br,strong',
		),
		'catalog_company' => array(
			'HTML.Allowed' => 'b,em,ul,li,ol,p,span[style],br,div,br,strong',
		),
	)
);

