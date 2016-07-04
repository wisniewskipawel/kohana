<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Cron_Ads extends Controller_Cron_Main {
	
	public function action_expiring()
	{
		$model_ads = new Model_Ad;
		$ads = $model_ads->cron_expiring_ads();
		
		$counter = 0;
		
		foreach($ads as $ad)
		{
			$email = ORM::factory('Email')
					->where('email_alias', '=', 'ad_expiring')
					->find();
			
			$email->set_tags(array('%ad_title%' => $ad->ad_title));
			$email->send($ad->user->user_email);
			
			$counter++;
		}
	}
	
}