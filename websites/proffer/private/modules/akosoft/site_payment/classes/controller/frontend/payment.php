<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_Payment extends Controller_Frontend_Main {
	
	public function action_new_payment()
	{
		$place = $this->request->param('place');
		$payment_method = $this->request->param('payment_method');
		$id = (int)$this->request->query('id');
		
		if(payment::is_registered_module($place))
		{
			$payment_class = payment::load_payment_module($place);
			
			if($payment_class->logged_only())
			{
				$this->logged_only();
			}
			
			$payment_class->set_params($this->request->query());
			$payment_class->object_id($id);
			
			if(!$payment_method)
			{
				$payment_class->load_object();
				
				$form = Bform::factory('Frontend_Payment_Method', array('payment_module' => $payment_class));
				
				if($form->validate())
				{
					$payment_method = $form->payment_method->get_value();
				}
				else
				{
					$this->template->content = View::factory('frontend/payment/method')
						->set('form', $form)
						->set('payment_module', $payment_class);
					return;
				}
			}

			if(!payment::is_registered_provider($payment_method))
			{
				Kohana::$log->add(
					Log::ERROR, 
					'PAYMENT: wrong payment method! (method: :method, id: :id, module: :module)',
					array(
						':module' => $place, 
						':method' => $payment_method, 
						':id' => $id
					)
				)->write();

				throw new HTTP_Exception_400;
			}
			
			//get payment provider ex. dotpay, payu...
			$provider = payment::load_provider($payment_method);
			
			//create new payment
			if($payment_class->new_payment($provider, $id))
			{
				$this->redirect(Route::get('site_payment/frontend/payment/pay')->uri(array(
					'token' => $payment_class->get_payment_token(),
				)));
			}
			else
			{
				Kohana::$log->add(
					Log::ERROR, 
					'PAYMENT: Cannot register new payment! (method: :method, id: :id, module: :module)',
					array(
						':module' => $place, 
						':method' => $payment_method, 
						':id' => $id
					))->write();
			}
		}
		else
		{
			Kohana::$log->add(
				Log::ERROR, 
				'PAYMENT: Module is not registered! (method: :method, id: :id, module: :module)',
				array(
					':module' => $place, 
					':method' => $payment_method, 
					':id' => $id
				))->write();
		}
		
		FlashInfo::add(___('payments.new_payment.error'), FlashInfo::ERROR);
		//TODO: redirect to error page
		$this->redirect();
	}
	
	public function action_pay()
	{
		$token = $this->request->param('token');
		
		$payment_model = new Model_Payment();
		$payment_model->find_by_token($token);

		if($payment_model->loaded())
		{
			$payment_module = payment::load_payment_module(NULL, $payment_model);
			
			if($payment_module->logged_only())
			{
				$this->logged_only();
			}
			
			if($payment_module->is_valid() AND $payment_module->get_payment_model()->status == Model_Payment::STATUS_NEW)
			{
				if(Kohana::$environment === Kohana::DEMO)
				{
					$payment_module->pay(NULL, TRUE);
					$this->redirect();
				}
				
				//start payment; return view or redirect to provider page
				$output = $payment_module->start_payment();

				breadcrumbs::add(array(
					'homepage' => URL::site(),
					$this->template->set_title(___('payments.pay.title')) => '',
				));

				$this->template->content = View::factory('frontend/payment/pay')
					->set('form', $output)
					->set('payment_text', $payment_module->provider()->get_text('details'));
			}
			else
			{
				Kohana::$log->add(
					Log::ERROR, 
					'PAYMENT: Module is not valid or is finished!: :token!',
					array(
						':token' => $token,
					))->write();
				
				FlashInfo::add(___('payments.pay.error.default'), FlashInfo::ERROR);
				$this->redirect();
			}
		}
		else
		{
			Kohana::$log->add(
				Log::ERROR, 
				'PAYMENT: Cannot find payment by token: :token!',
				array(
					':token' => $token,
				))->write();
			
			FlashInfo::add(___('payments.pay.error.not_found'), FlashInfo::ERROR);
			$this->redirect();
		}
	}
	
}
