<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2015, AkoSoft
*/

class Bform_Core_Validator_File_Image extends Bform_Validator_Base {

	public function validate()
	{
		if(!Valid::not_empty($this->_value) OR !Upload::not_empty($this->_value))
			return TRUE;

		if(!Upload::type($this->_value, array('png', 'gif', 'jpg', 'jpeg')) OR !Upload::image($this->_value))
		{
			$this->_error = 'bform.validator.file_image';
			$this->exception();
		}

		if(Kohana::$config->load('site.low_memory'))
		{
			$max_image_side_length = Kohana::$config->load('site.max_image_side_length');

			if($max_image_side_length AND !Upload::image($this->_value, $max_image_side_length, $max_image_side_length))
			{
				$this->_error = ___('bform.validator.max_image_side_length', array(':max_size' => $max_image_side_length));
				$this->exception();
			}
		}

		return TRUE;
	}

}
