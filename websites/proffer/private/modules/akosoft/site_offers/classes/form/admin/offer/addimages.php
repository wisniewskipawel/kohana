<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Offer_AddImages extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$count = count($params['images']);
		$count = 1 - $count;
		
		if($count)
		{
			$this->add_input_file('image1', array('label' => 'offers.forms.image', 'required' => FALSE))
				->add_validator('image1', 'Bform_Validator_File_Filesize', array('filesize' => '1M'))
				->add_validator('image1', 'Bform_Validator_File_Image');

			$this->add_input_submit(___('form.save'));
		}
	}
	
}
