<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Paypal {

	protected $_config = array();

	protected $_posted_data = array();

	protected $_params = array(
		'form' => array()
	);

	protected $_amount = NULL;

	public function posted_data($name = NULL)
	{
		if ($name === NULL)
		{
			return $this->_posted_data;
		}
		return $this->_posted_data[$name];
	}

	public function __construct()
	{
		$this->_config = Arr::merge(
			Kohana::$config->load('global.payment.paypal.online'), 
			Kohana::$config->load('paypal')->as_array()
		);
		
		if(empty($this->_config['business']))
		{
			throw new Kohana_Exception('Configure PayPal payments before this action!');
		}
	}

	public function __toString()
	{
		try
		{
			return View::factory('payment/paypal/form')
					->set('config', $this->_config)
					->set('form', $this->_params['form'])
					->set('amount', $this->_amount)
					->render();
		}
		catch (Exception $e)
		{
			Kohana_Exception::handler($e);
		}
	}

	public function form($name = NULL, $value = NULL)
	{
		if ($name === NULL)
		{
			return $this->_params['form'];
		}
		if ($name AND $value === NULL)
		{
			return $this->_params['form'][$name];
		}
		$this->_params['form'][$name] = $value;
	}

	public function payment_success()
	{
		$result = $this->_params['payment_success'];
		if ($result)
		{
			if ($this->_payment_exists())
			{
				return FALSE;
			}
			return TRUE;
		}
		return FALSE;
	}

	protected function _payment_exists()
	{
		$hash = md5($this->_posted_data['txn_id']);

		$result = ORM::factory('Transaction')
				->select(array(DB::expr('
					IF (
						(
							transaction_date_added + INTERVAL 10 MINUTE < NOW()
						)
					, 1, 0)
				'), 'expired'))
				->where('transaction_hash', '=', $hash)
				->having('expired', '=', 0)
				->find_all()
				->as_array();

		$result = (bool) count($result);

		if ($result)
		{
			Kohana::$log->add(Log::INFO, 'paypal: platnosc istnieje...');
			return TRUE;
		}
		else
		{
			Kohana::$log->add(Log::INFO, 'paypal: dodaje platnosc...');
			ORM::factory('Transaction')->add_transaction($hash);
			return FALSE;
		}
	}

	public function price($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->_amount;
		}
		$this->_amount = $value;
	}

	public function validate($values)
	{
		if ( !empty($values))
		{
			if(empty($values['txn_id'])
				|| empty($values['custom'])
				|| empty($values['business'])
			)
			{
				return FALSE;
			}

			if($values['business'] != strtolower($this->_config['business']))
			{
				return FALSE;
			}

			$values['cmd'] = '_notify-validate';

			$request = Request::factory($this->_config['url']);
			$request->method('post');
			$request->post($values);

			$result = $request->execute()->body();

			if (preg_match('#verified#i', $result))
			{
				if (preg_match('#subscr#', $values['txn_type']))
				{
					if (in_array($values['txn_type'], $this->_config['ignored_types']))
					{
						return FALSE;
					}

					if ($values['txn_type'] == 'subscr_payment')
					{
						if ($values['payment_status'] == 'Completed')
						{
							$this->price($values['mc_amount3']);
							$this->_params['payment_success'] = TRUE;
						}
					}
				}
				else
				{
					if ($values['payment_status'] == 'Completed')
					{
						$this->price($values['mc_gross']);
						$this->_params['payment_success'] = TRUE;
					}
				}
				$this->_posted_data = $values;
				return TRUE;
			}
			return FALSE;
		}
	}

	public static function payment_status($values)
	{
		switch($values['payment_status'])
		{
			case 'Completed':
				return Payment_Module::SUCCESS;

			case 'Pending':
				return Payment_Module::PENDING;

			case 'Failed':
				return Payment_Module::ERROR;

			default:
				Kohana::$log(Log::ERROR, 'PayPal: unrecognized payment status :status', array(
					':status' => $values['payment_status']
				))->write();

				return NULL;
		}
	}
    
}
