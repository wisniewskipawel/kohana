<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Cron_Catalog extends Controller_Cron_Main {
	
	public function action_expiring()
	{
		$companies = ORM::factory('Catalog_Company')
				->select(array(DB::expr('
					IF(DATEDIFF(catalog_company.company_promotion_availability, NOW()) = 2, 1, 0)
				'), 'if_send'))
				->having('if_send', '=', 1)
				->find_all();
		
		$i = 0;
		
		foreach ($companies as $c)
		{
			$email = ORM::factory('Email')
					->where('email_alias', '=', 'catalog_renew_promotion')
					->find();
			
			$email->set_tags(array(
				'%company.name%'	=> $c->company_name,
				'%link%'			=> HTML::anchor(Route::url('site_catalog/profile/catalog/prolong_promote', array('id' => $c->company_id), 'http')),
			));
			
			if ($c->user->user_email)
			{
				$email->send($c->user->user_email);
			}
			else
			{
				$email->send($c->company_email);
			}
			$i++;
		}
		
	}
}
