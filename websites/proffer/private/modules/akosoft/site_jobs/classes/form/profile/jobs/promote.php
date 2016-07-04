<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Profile_Jobs_Promote extends Bform_Form {
    
	public function  create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'jobs.form');
		
		$distinctions = array();
		
		foreach(Jobs::distinctions() as $distinction => $distinction_label)
		{
			$distinctions[$distinction] = Jobs::config('promotion_text_'.$distinction, $distinction_label);
		}
		
		$this->add_group_radio('promotion', $distinctions, array(
			'required' => FALSE,
		));
		
		$this->add_input_submit(___('form.next'));

		$this->template('site');
	}

}
