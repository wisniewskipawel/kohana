<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Transferuj extends Controller {
	
	public function action_bridge()
	{
		Log::$write_on_add = TRUE;
		
		Kohana::$log->add(Log::INFO, 'Transferuj.pl: bridge START');
		
		$data = $this->request->post();
		
		if((Request::$client_ip == '195.149.229.109' OR Kohana::$environment !== Kohana::PRODUCTION) AND !empty($data))
		{
			Kohana::$log->add(Log::DEBUG, 'Transferuj.pl: data: '.http_build_query($data));
			
			try 
			{
				$payment_provider = payment::load_provider('transferuj');

				if(!$payment_provider)
				{
					throw new Kohana_Exception('Cannot load payment provider!');
				}
				
				$payment_token = $data['tr_crc'];
				
				Kohana::$log->add(Log::INFO, 'Transferuj.pl payment_token=:token', array(
					':token' => $payment_token,
				));
				
				$sum_check = md5(
					$data['id'].
					$data['tr_id'].
					$data['tr_amount'].
					$payment_token.
					$payment_provider->config('security_code')
				);

				if($sum_check === $data['md5sum'])
				{
					$model_payment = new Model_Payment();
					$model_payment->filter_by_status(Model_Payment::STATUS_NEW)
						->find_by_token($payment_token);

					if(!$model_payment->loaded())
					{
						throw new Kohana_Exception('Cannot load model payment!');
					}

					$payment_module = payment::module_from_payment($model_payment);

					if(!$payment_module)
					{
						throw new Kohana_Exception('Cannot load payment module!');
					}
					
					if($data['tr_status'] == 'TRUE' && $data['tr_error'] == 'none')
					{
						if($model_payment->transaction_id != $data['tr_id'])
						{
							//save transaction to db
							$model_payment->set_transaction($data['tr_id']);
						}
						else
						{
							throw new Kohana_Exception('Transaction duplicated! (:tr_id)', array(
								':tr_id' => $data['tr_id'],
							));
						}
						
						$paid = $data['tr_paid'];
						$price = $payment_module->get_price($payment_provider);
						
						if($paid == $price)
						{
							$payment_module->success(FALSE);
							
							Kohana::$log->add(Log::INFO, 'Transferuj.pl: bridge SUCCESS');
						}
						else
						{
							$model_payment->set_status(Model_Payment::STATUS_ERROR);
							
							throw new Kohana_Exception('Wrong price! (:paid != :price)', array(
								':paid' => $paid,
								':price' => $price,
							));
						}
					}
					else
					{
						$model_payment->set_status(Model_Payment::STATUS_ERROR);
						
						throw new Kohana_Exception('Transaction error! (status=:status, error=:error)', array(
							':status' => $data['tr_status'],
							':error' => $data['tr_error'],
						));
					}
				}
				else
				{
					throw new Kohana_Exception('Wrong md5sum! (:check_sum != :valid_sum)', array(
						':check_sum' => $sum_check,
						':valid_sum' => $data['md5sum'],
					));
				}
			}
			catch(Exception $e)
			{
				Kohana_Exception::log($e, Log::ERROR);
			}
		}
		
		$this->response->body('TRUE'); 
	}
	
}