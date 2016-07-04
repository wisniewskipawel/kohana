<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2015, AkoSoft
*/
class Controller_Frontend_PayU extends Controller_Frontend_Main {
	
	public function action_success()
	{
		$values = $this->request->query();

		FlashInfo::add(___('payu.success'), 'success');

		if(isset($values['token']))
		{
			$payment_model = new Model_Payment();
			$payment_model->find_by_token($values['token']);

			if($payment_model->loaded())
			{
				if(!empty($values['trans_id']))
				{
					$payment_model->set_transaction($values['trans_id']);
				}

				$payment = payment::load_payment_module(NULL, $payment_model);
				$this->redirect($payment->redirect_url(Payment_Module::SUCCESS));
			}
		}

		$this->redirect();
	}

	public function action_error()
	{
		$values = $this->request->query();

		Kohana::$log->add(
			Log::ERROR, 
			'PAYU: transaction error :error: :error_msg (token=:token, trans_id=:trans_id)',
			array(
				':error' => Arr::get($values, 'error'),
				':error_msg' => PayU::error_message(Arr::get($values, 'error')),
				':token' => Arr::get($values, 'token'),
				':trans_id' => Arr::get($values, 'trans_id'),
			)
		)->write();

		FlashInfo::add(___('payu.error'), 'error');

		if(isset($values['token']))
		{
			$payment_model = new Model_Payment();
			$payment_model->find_by_token($values['token']);

			if($payment_model->loaded())
			{
				$payment_model->set_status(Model_Payment::STATUS_ERROR);

				if(!empty($values['trans_id']))
				{
					$payment_model->set_transaction($values['trans_id']);
				}

				$payment = payment::load_payment_module(NULL, $payment_model);
				$this->redirect($payment->redirect_url(Payment_Module::ERROR));
			}
		}

		$this->redirect();
	}

}
