<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Newsletter_Filter_Subscriber extends Bform_Form {

	public function create(array $params = array()) 
	{
		$this->form_data($params);
		
		$this->add_input_text('email', array('label' => 'email', 'required' => FALSE));
		
		$this->add_bool('accept_ads', array('label' => 'newsletter.accept_ads', 'required' => FALSE));

		if (count($params))
		{
			$this->add_html(HTML::anchor('/admin/newsletter/clear_filters', ___('filters.clear')));
		}

		$this->add_input_submit(___('form.filter'));
	}

}
