<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Widget_Newsletter extends Widget_Box {
	
	public function render($view_file = 'component/newsletter/sidebar_left')
	{
		$form = Bform::factory('Frontend_Newsletter_Subscribe');

		$this->set('form', $form);
		
		return parent::render($view_file);
	}
	
}