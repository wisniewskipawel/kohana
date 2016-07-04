<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Form_Admin_Product_AddImages extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$count = count($params['images']);
		$count = 10 - $count;

		$this->add_file_uploader('images', array(
			'amount' => $count,
			'type' => Bform_Core_Driver_File_Uploader::TYPE_IMAGES,
			'label' => ___('images.add'),
		));
		
		$this->add_input_submit('Zapisz');
	}   
}