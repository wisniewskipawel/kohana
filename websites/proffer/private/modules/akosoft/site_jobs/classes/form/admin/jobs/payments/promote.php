<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Admin_Jobs_Payments_Promote  extends Form_Admin_Payment_Settings {
    
	public function  create(array $params = array())
	{
		$this->_module = new Payment_Job_Promote();
		
		parent::create(array(
			'module' => $this->_module->get_module_name(), 
			'place' => $this->_module->get_payment_module_name(),
			'title' => $this->_module->get_title(),
			'types' => array_keys($params['types']),
			'title' => $params['types'],
			'values' => $params['values'],
			'per_type_enabled' => TRUE,
		));
	}
    
}