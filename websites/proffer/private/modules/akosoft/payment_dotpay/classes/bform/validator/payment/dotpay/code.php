<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Validator_Payment_Dotpay_Code extends Bform_Validator_Base {
	
	protected $_error = "dotpay.forms.validator.code";
	
	public function validate()
	{
		$account = $this->_options['account'];
		
		if (empty($account))
		{
			throw new Exception('Check API!');
		}
		
		$provider = $this->_options['provider'];
		
		if ( ! $provider->check_code($account, $this->_value))
		{
			$this->exception();
		}
	}
}
