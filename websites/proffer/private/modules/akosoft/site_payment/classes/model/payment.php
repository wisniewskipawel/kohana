<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Payment extends ORM {
	
	const STATUS_NEW = 0;
	const STATUS_SUCCESS = 1;
	const STATUS_ERROR = -1;
	
	protected $_created_column = array(
		'column' => 'date_created',
		'format' => 'Y-m-d H:i:s'
	);
	
	protected $_updated_column = array(
		'column' => 'date_updated',
		'format' => 'Y-m-d H:i:s'
	);
	
	protected $_serialize_columns = array(
		'params'
	);
	
	public function init_payment(Payment_Module $payment)
	{
		/*
		$this
			->where('status', '=', self::STATUS_NEW)
			->find_by_object($payment->get_object_id(), $payment->get_payment_module_name());
			*/
		
		$this->method = $payment->get_method();
		$this->params = $payment->get_params();
		
		$this->status = self::STATUS_NEW;
		
		if(!$this->loaded())
		{
			$user = $payment->get_user();
			$this->user_id = $user ? $user->pk() : NULL;
			$this->object_id = $payment->get_object_id();
			$this->module = $payment->get_payment_module_name();
			
			$this->_generate_token();
		}

		$this->save();
		
		return $this->saved();
	}
	
	public function find_by_object($object_id, $module)
	{
		return $this->where('object_id', '=', (int)$object_id)
			->where('module', '=', $module)
			->find();
	}
	
	public function find_by_token($token)
	{
		$this
			->where('token', '=', $token)
			->find();
		
		return $this;
	}
	
	public function filter_by_status($status, $op = '=')
	{
		return $this->where('status', $op, $status);
	}
	
	public function filter_by_hidden($bool)
	{
		return $this->where('hidden', '=', (bool)$bool);
	}
	
	public function filter_by_transaction($transaction_id)
	{
		return $this->where('transaction_id', '=', $transaction_id);
	}
	
	public function set_transaction($transaction)
	{
		$this->transaction_id = (int)$transaction;
		
		$this->save();
		
		return $this->saved();
	}
	
	public function set_hidden($bool)
	{
		$this->hidden = (bool)$bool;
		
		$this->save();
		
		return $this->saved();
	}
	
	protected function _generate_token()
	{
		do {
			$this->token = strtolower(Text::random('alnum', 16));
		}
		while(!$this->unique('token', $this->token));
		
		return $this->token;
	}
	
	public function set_status($new_status)
	{
		$this->status = (int)$new_status;
		
		$this->save();
	}
	
	public function set_invoice($invoice)
	{
		$params = array();
		
		if(!empty($this->params))
		{
			$params = (array)$this->params;
		}
		
		$params['invoice'] = (bool)$invoice;
		
		$this->params = $params;
		
		$this->save();
		
		return $this;
	}
	
	public function has_invoice()
	{
		return (bool)Arr::get((array)$this->params, 'invoice', FALSE);
	}
	
	public static function status_to_text($status)
	{
		$statuses = array(
			self::STATUS_ERROR => ___('payments.status.'.self::STATUS_ERROR),
			self::STATUS_NEW => ___('payments.status.'.self::STATUS_NEW),
			self::STATUS_SUCCESS => ___('payments.status.'.self::STATUS_SUCCESS),
		);
		
		return Arr::get($statuses, $status);
	}
}
