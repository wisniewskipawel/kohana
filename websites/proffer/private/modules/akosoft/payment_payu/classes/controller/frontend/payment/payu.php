<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2015, AkoSoft
*/
class Controller_Frontend_Payment_Payu extends Controller {
    
	public function action_ipn()
	{
		try {
			$values = $this->request->post();
			
			$payment_token = Arr::get($values, 'session_id');
			$provider_name = $this->request->param('provider_name');

			Kohana::$log
				->add(Log::DEBUG, 'PAYU: values :values', array(':values' => URL::query($values, FALSE)))
				->add(
					Log::INFO, 
					'PAYU: IPN postback start (provider=:provider_name, session_id=:session_id)', 
					array(
						':provider_name' => $provider_name,
						':session_id'  => $payment_token
					)
				);

			$payment_payu = Payment::load_provider($provider_name);
			if(!$payment_payu->check($values))
			{
				throw new Kohana_Exception('PAYU: IPN postback is invalid!');
			}

			$model_payment = new Model_Payment();
			$model_payment
				->filter_by_status(Model_Payment::STATUS_NEW)
				->find_by_token($payment_token);

			if(!$model_payment->loaded())
			{
				throw new Kohana_Exception('PAYU: cannot load model payment!');
			}

			$payment_module = payment::module_from_payment($model_payment);
			
			$payment_payu->set_module($payment_module);
			
			$result = $payment_payu->finish($values);

			Kohana::$log->add(
				Log::INFO, 
				'PAYU: IPN postback stop (result=:result)', 
				array(
					':result' => $result
				)
			);
		}
		catch(Exception $ex)
		{
			Kohana::$log->add(
				Log::ERROR, 
				'PAYU: error (:error)', 
				array(
					':error' => $ex->getMessage()
				)
			);
			
			Kohana_Exception::log($ex, Log::ERROR);
		}
		
		Kohana::$log->write();
		
		echo 'OK';
	}

}
