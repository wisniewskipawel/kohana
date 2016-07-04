<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Frontend_Transferuj extends Controller_Frontend_Main {
	
	public function action_success()
	{
		$values = $this->request->query();
		
		FlashInfo::add('Płatność została zrealizowana pomyślnie!', 'success');
		
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
	
	public function action_error()
	{
		$values = $this->request->query();
		
		Kohana::$log->add(
			Log::ERROR, 
			'transferuj.pl: transaction error (token=:token)',
			array(
				':token' => Arr::get($values, 'token'),
			)
		)->write();
		
		FlashInfo::add('Wystąpił błąd przy przetwarzaniu płatności!', 'error');
		
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