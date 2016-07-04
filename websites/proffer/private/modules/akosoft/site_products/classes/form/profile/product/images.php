<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Form_Profile_Product_Images extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$count = count($params['images']);
		
		if (BAuth::instance()->is_logged())
		{
			$photos_count = Kohana::$config->load('modules.site_products.photos_count.registered');
		}
		else
		{
			$photos_count = Kohana::$config->load('modules.site_products.photos_count.guest');
		}

		if ($count == $photos_count) 
		{
			$this->add_html(___('products.forms.images.error.max', $photos_count, array(':nb' => (int)$photos_count)));
		} 
		else 
		{
			$this->add_file_uploaderjs('images', array(
				'amount' => $photos_count - $count,
				'type' => Bform_Core_Driver_File_UploaderJS::TYPE_IMAGES,
				'label' => ___('images.add'),
			));

			$this->add_input_submit(___('form.save'));
		}

		$this->template('site');
	}
	
}
