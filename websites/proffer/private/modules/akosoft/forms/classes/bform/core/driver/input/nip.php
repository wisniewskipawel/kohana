<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Core_Driver_Input_NIP extends Bform_Driver_Input_Text {

	public function __construct(Bform_Core_Form $form, $name, array $options = array())
	{
		parent::__construct($form, $name, $options);
		
		$this->add_validator('Bform_Validator_HTML');
	}
	
}
