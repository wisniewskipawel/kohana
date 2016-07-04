<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Admin_Jobs_Promote extends Bform_Form {

	public function create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'jobs.form');
		
		$values = $params['job']->as_array();
		$values['date_promotion_availability'] = date('Y-m-d H:i:s', strtotime('now + 2 weeks'));
		
		$this->form_data($values);
		
		$distinctions = Jobs::distinctions(FALSE);
		$this->add_select('distinction', Arr::unshift($distinctions, NULL, ___('select.choose')));
		
		$this->add_datetime('date_promotion_availability');
		$this->add_datetime('date_availability');
		
		$this->add_input_submit(___('form.save'));
	}

}
