<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Profile_Offer_Images extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$count = count($params['images']);
		
		$photos_count=1;

		if ($count >= $photos_count)
		{
			$this->add_html(___('offers.images.error.max', $photos_count, array(':nb' => $photos_count)));
		} 
		else 
		{
			for ($i = 1; $i <= $photos_count - $count; $i++) 
			{
				$name = 'file' . $i;

				$this->add_input_file($name, array('label' => ___('image.nb', array(':nb' => $i)), 'required' => FALSE))
					->add_validator($name, 'Bform_Validator_File_Image')
					->add_validator($name, 'Bform_Validator_File_Filesize', array('filesize' => '1M'));
			}

			$this->add_input_submit(___('form.save'));
		}

		$this->template('site');
	}
	
}
