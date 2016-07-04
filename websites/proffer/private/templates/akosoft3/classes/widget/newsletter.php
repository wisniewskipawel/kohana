<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Widget_Newsletter extends Widget_Box {
	
	public function render($view_file = NULL)
	{
		$form = Bform::factory('Frontend_Newsletter_Subscribe');
		$this->set('form', $form);
		
		return parent::render($view_file);
	}
	
}
