<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Catalog_Company_AddImages extends Bform_Form {

	public function  create(array $params = array())
	{
		$count = 7 - count($params['images']);
		
		$this->add_file_uploader('photos', array(
			'amount' => $count, 
			'type' => 'images', 
			'label' => 'images.add',
			'no_decorate' => TRUE,
		));

		$this->add_input_submit(___('form.save'));
	}
}
