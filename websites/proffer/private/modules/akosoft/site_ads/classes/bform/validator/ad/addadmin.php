<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Validator_Ad_AddAdmin extends Bform_Validator_Dependency {
    
	public function validate() 
	{
		$values = $this->get_dependencies_values_from_drivers();

		if ($this->_value == Model_Ad::TEXT_C OR $this->_value == Model_Ad::TEXT_C1) 
		{
			if (empty($values['ad_description']) OR empty($values['ad_link']) ) 
			{
				$this->_error = "ads.forms.validator.add_admin.text_required";
				$this->exception();
			}
		}
		else 
		{
			if (empty($values['ad_banner_link']) AND empty($values['ad_code'])) 
			{
				$this->_error = "ads.forms.validator.add_admin.banner_required";
				$this->exception();
			}
		}
	}
	
}
