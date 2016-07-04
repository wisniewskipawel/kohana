<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Core_Driver_Price extends Bform_Driver_Input_Text {
	
	public $_custom_data = array(
		'_data' => array(
			'driver_template' => 'bform/shared/drivers/input/text',
		),
	);
	
	public function __construct(Bform_Core_Form $form, $name, array $options = array())
	{
		parent::__construct($form, $name, $options);
		
		$this->add_filter('Bform_Filter_Price')
			->add_validator('Bform_Validator_Range', array('min' => 0, 'max' => 999999999))
			->add_validator('Bform_Validator_Html');
	}

}
