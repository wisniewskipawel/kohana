<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Driver_Company_Hours extends Bform_Driver_Base {
	
	public $_custom_data = array(
		'_data' => array(
			'driver_template' => 'bform/drivers/company/hours',
		),
		'_html' => array(
			'row_class' => 'full',
		),
	);
	
	public function __construct(Bform_Core_Form $form, $name, array $options = array())
	{
		parent::__construct($form, $name, $options);
		
		$this->add_validator('Bform_Validator_Company_Hours');
	}
	
	public function set_value($value)
	{
		$return = array();
		$have_value = FALSE;
		
		foreach($this->get_days() as $day => $name)
		{
			if(isset($value[$day]))
			{
				$day_val = $value[$day];
				
				$return[$day] = array(
					'open' => (int)Arr::get($day_val, 'open', Model_Catalog_Company::COMPANY_HOURS_NONE),
					'from' => NULL,
					'to' => NULL,
				);
				
				if($return[$day]['open'] == Model_Catalog_Company::COMPANY_HOURS_OPEN)
				{
					$return[$day]['from'] = trim(Arr::get($day_val, 'from'));
					$return[$day]['to'] = trim(Arr::get($day_val, 'to'));
					
					if(!$return[$day]['from'] AND !$return[$day]['to'])
					{
						$return[$day]['open'] = Model_Catalog_Company::COMPANY_HOURS_NONE;
					}
				}
					
				if($return[$day]['open'] == Model_Catalog_Company::COMPANY_HOURS_OPEN)
				{
					$have_value = TRUE;
				}
			}
		}
		
		if($have_value)
		{
			return parent::set_value($return);
		}
	}
	
	public function get_days()
	{
		return array(
			1 => ___('date.days.other.1'),
			2 => ___('date.days.other.2'),
			3 => ___('date.days.other.3'),
			4 => ___('date.days.other.4'),
			5 => ___('date.days.other.5'),
			6 => ___('date.days.other.6'),
			0 => ___('date.days.other.0'),
		);
	}
	
}
