<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Admin_Jobs_Payments_Add extends Form_Admin_Payment_Settings {
	
	public function  create(array $params = array())
	{
		$this->_module = new Payment_Job_Add;
		
		parent::create(array(
			'module' => $this->_module->get_module_name(), 
			'place' => $this->_module->get_payment_module_name(),
			'title' => $this->_module->get_title(),
			'values' => $params,
		));
	}
	
}