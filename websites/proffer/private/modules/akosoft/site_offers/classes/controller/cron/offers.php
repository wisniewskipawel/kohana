<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Cron_Offers extends Controller_Cron_Main {
	
	public function action_expiring()
	{
		$offers = ORM::factory('Offer')
				->with('user')
				->where(DB::expr('DATEDIFF(offer.offer_availability, NOW())'), '=', 2)
				->find_all();
		
		$i = 0;
		
		foreach ($offers as $a)
		{
			if ($a->user_id && $a->user->loaded()) 
			{
				$email = Model_Email::email_by_alias('offers_expiring_registered');
				
				$email->set_tags(array(
					'%renew_link%'	=> HTML::anchor(
						Route::url('site_offers/profile/offers/renew', array('id' => $a->pk()), 'http'),
						___('offers.email.expiring.prolong')
					),
					'%offer_link%'		=> HTML::anchor(
						Route::url('site_offers/frontend/offers/show', array('offer_id' => $a->pk(), 'title' => URL::title($a->offer_title)), 'http'),
						$a->offer_title
					),
				));
				
				$email->send($a->user->user_email);
			}
			elseif ($a->get_email_address()) 
			{
				$email = Model_Email::email_by_alias('offers_expiring_not_registered');
				
				$email->set_tags(array(
					'%add_link%'	=> HTML::anchor(
						Route::url('site_offers/frontend/offers/add', array(), 'http'),
						___('offers.email.expiring.add_btn')
					),
					'%offer_link%'	=> HTML::anchor(
						Route::url('site_offers/frontend/offers/show', array('offer_id' => $a->pk(), 'title' => URL::title($a->offer_title)), 'http'),
						$a->offer_title
					),
				));
				
				$email->send($a->get_email_address());
			}
			$i++;
		}
		
	}
	
}
