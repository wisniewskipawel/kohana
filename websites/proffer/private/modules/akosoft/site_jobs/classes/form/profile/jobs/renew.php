<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Profile_Jobs_Renew extends Bform_Form {
    
	public function  create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'jobs.form');
		
		$this->add_select('availability_span', Jobs::availabilites());
		
		$this->add_input_submit(___('form.next'));

		$this->template('site');
	}

}
