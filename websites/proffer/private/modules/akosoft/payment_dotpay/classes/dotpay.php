<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2012, AkoSoft
*/
class dotpay {
	
	protected static $_config = array();
   
	public static function check_code($service, $code, $client_id, $delete_codes, $account_type = 'c1,sms')
	{
		if(Kohana::$environment == Kohana::DEVELOPMENT)
		{
			if($code == '666')
				return TRUE;
		}
		
		$url = "http://dotpay.pl/check_code.php?id=".$client_id."&code=".$service."&check=".$code."&type=".$account_type."&del=".$delete_codes;
		
		$request = Request::factory($url);
		$response = $request->execute()->body();
		
		if(empty($response))
		{
			Kohana::$log
				->add(Log::ERROR, 'DOTPAY: No reponse from :url', array(':url' => $url))
				->write();
			
			return FALSE;
		}
		
		$lines = explode("\n", $response);
		
		if (Arr::get($lines, 0) == 0) 
		{
			Kohana::$log
				->add(Log::ERROR, 'DOTPAY: Wrong code (code=:code, check=:check)', array(
					':code' => $service,
					':check' => $code
				))
				->write();
			
			return FALSE;
		}
		
		return TRUE;
	}
	
	public static function get_account($module_name, $payment_method, $place, $type = 'default')
	{
		$payment_method = str_replace('_', '.', $payment_method);
		$config_path = "modules.$module_name.payment.$payment_method.accounts.$place.$type";
		
		$account = Kohana::$config->load($config_path);
		if (empty($account))
		{
			throw new Exception('Check Config:  ' . $config_path);
		}
		return $account;
	}
}
