<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Tab extends Bform_Driver_Collection {
	
	public function __construct(Bform_Core_Form $form = NULL, $name, $options = array())
	{
		$this->_options['set_values_path'] = '';
		$this->_options['get_values_path'] = '';
		
		parent::__construct($form, $name, $options);
	}
	
	public function render($decorate = NULL)
	{
		return View::factory('bform/shared/drivers/collection/tab')
			->set('collection', $this)
			->set('form', $this->form());
	}
	
}
