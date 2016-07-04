<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_Payment_Paypal extends Controller {
    
	public function action_ipn()
	{
		try 
		{
			$values = $this->request->post();
			$paypal_id = Arr::get($values, 'txn_id');
			$payment_token = Arr::get($values, 'custom');

			Kohana::$log->add(
				Log::DEBUG, 
				'PAYPAL: IPN data :data', 
				array(
					':data' => URL::query($values, FALSE),
				)
			);

			Kohana::$log->add(
				Log::INFO, 
				'PAYPAL: IPN postback start (txn_id=:txn_id, token=:token)', 
				array(
					':txn_id' => $paypal_id,
					':token'  => $payment_token
				)
			);

			$model_payment = new Model_Payment();
			$model_payment
				->filter_by_status(Model_Payment::STATUS_NEW)
				->find_by_token($payment_token);

			if(!$model_payment->loaded())
			{
				throw new Kohana_Exception('PAYPAL: cannot load model payment!');
			}

			$payment_module = payment::module_from_payment($model_payment);

			if(!$payment_module)
			{
				throw new Kohana_Exception('Cannot load payment module!');
			}

			$payment_paypal = new Payment_Provider_PayPal_Online();
			$payment_paypal->set_module($payment_module);
			if(!$payment_paypal->check($values))
			{
				throw new Kohana_Exception('PAYPAL: IPN postback is invalid!');
			}

			$result = $payment_paypal->finish($values);

			Kohana::$log->add(
				Log::INFO, 
				'PAYPAL: IPN postback stop (txn_id=:txn_id, result=:result)', 
				array(
					':txn_id' => $paypal_id,
					':result' => $result
				)
			)->write();
		}
		catch(Exception $e)
		{
			Kohana::$log->add(
				Log::ERROR, 
				'PAYPAL: IPN error: :error', 
				array(
					':error' => $e->getMessage(),
				)
			);

			Kohana_Exception::log($e, Log::ERROR);
		}
	}
	
}
