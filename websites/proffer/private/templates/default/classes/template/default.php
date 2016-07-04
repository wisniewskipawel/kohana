<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Template_Default extends View_Template {
	
	public function initialize()
	{
		parent::initialize();
		
		$this->set_default_layout('layouts/default');
		
		Media::css('reset.css', NULL, array('minify' => TRUE));
		Media::css('common.css', NULL, array('minify' => TRUE, 'combine' => TRUE));
		Media::css('main.css', NULL, array('minify' => TRUE, 'combine' => TRUE));
		
		Media::js('jquery.min.js', 'js/libs/');
		Media::js('jquery.custom-select.js');
		
		if($this->config('map_enabled'))
		{
			Media::css('cssmap-poland.css', 'js/libs/cssmap/cssmap-poland/', array('minify' => TRUE, 'combine' => FALSE));
			Media::js('jquery.cssmap.js', 'js/libs/cssmap/');
		}
	}
	
	protected function _get_config()
	{
		$config = (array)parent::_get_config();
		$config = Arr::merge(
			(array)Kohana::$config->load('template.default'), 
			(array)$config
		);
		
		return $config;
	}
	
}