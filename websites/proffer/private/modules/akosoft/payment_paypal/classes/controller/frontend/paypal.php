<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_Paypal extends Controller_Frontend_Main {
	
	public function action_return()
	{
		$values = $this->request->query();

		FlashInfo::add(___('paypal.return.success'), 'success');

		if(isset($values['token']))
		{
			$payment_model = new Model_Payment();
			$payment_model->find_by_token($values['token']);

			if($payment_model->loaded())
			{
				$payment = payment::load_payment_module(NULL, $payment_model);
				$this->redirect($payment->redirect_url(Payment_Module::SUCCESS));
			}
		}

		$this->redirect();
	}

	public function action_cancel_return()
	{
		$values = $this->request->query();

		Kohana::$log->add(
			Log::ERROR, 
			'PAYPAL: transaction cancel return (token=:token)',
			array(
				':token' => Arr::get($values, 'token'),
			)
		)->write();

		FlashInfo::add(___('paypal.cancel_return.error'), 'error');

		if(isset($values['token']))
		{
			$payment_model = new Model_Payment();
			$payment_model->find_by_token($values['token']);

			if($payment_model->loaded())
			{
				$payment_model->set_status(Model_Payment::STATUS_ERROR);

				$payment = payment::load_payment_module(NULL, $payment_model);
				$this->redirect($payment->redirect_url(Payment_Module::ERROR));
			}
		}

		$this->redirect();
	}

}
