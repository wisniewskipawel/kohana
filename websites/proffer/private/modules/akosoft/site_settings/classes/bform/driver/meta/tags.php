<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Driver_Meta_Tags extends Bform_Driver_Collection {
	
	public function on_add_driver()
	{
		$this->add_input_text(
			$this->option('meta_title', 'meta_title'), 
			array(
				'label' => ___('meta_tags.meta_title'),
				'required' => FALSE,
			)
		);
		
		$this->add_textarea(
			$this->option('meta_description', 'meta_description'), 
			array(
				'label' => ___('meta_tags.meta_description'),
				'required' => FALSE,
			)
		);
		
		$this->add_textarea(
			$this->option('meta_keywords', 'meta_keywords'), 
			array(
				'label' => ___('meta_tags.meta_keywords'),
				'required' => FALSE,
			)
		);
	}
	
}