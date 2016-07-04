<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Core_Driver_DateTime extends Bform_Driver_Input_Text {

	public $_custom_data = array(
		'_data' => array(
			'driver_template' => 'bform/shared/drivers/datetime',
			'date' => TRUE,
			'date_from' => NULL,
			'date_to' => NULL,
			'time' => TRUE,
			'format' => 'Y-m-d H:i',
			'format_date' => 'Y-m-d',
		),
	);
	
	public function __construct(Bform_Core_Form $form, $name, array $options = array())
	{
		parent::__construct($form, $name, $options);
		
		if($this->_get_data_option('date'))
		{
			$this->add_validator('Bform_Validator_Date', array(
				'from' => $this->data('date_from'),
				'to' => $this->data('date_to'),
			));
		}
	}
	
}
