<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Input_Password extends Bform_Driver_Input {
    
	public $_custom_data = array(
		'_data' => array(
			'strength' => FALSE,
		),
		'_html'         => array(
			'size'	=> 60,
			'keep_password' => FALSE,
		),
	);
	
	public function __construct(\Bform_Core_Form $form, $name, array $options = array())
	{
		parent::__construct($form, $name, $options);
		
		if($this->data('strength'))
		{
			$this->_set_html_option('row_class', 'full');
		}
	}
	
}
