<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Coupon_Owner extends ORM {
	
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;
	
	protected $_table_name = 'coupon_owners';
	
	protected $_created_column = array(
		'column' => 'date_created',
		'format' => 'Y-m-d H:i:s',
	);
	
	public function filter_by_email($email)
	{
		return $this->where($this->object_name().'.email', '=', $email);
	}
	
	public function filter_by_offer(Model_Offer $offer)
	{
		return $this->where($this->object_name().'.offer_id', '=', (int)$offer->pk());
	}
	
	public function get_user_limit(Model_Offer $offer, $email)
	{
		$user_coupons_nb = $this->filter_by_offer($offer)
			->filter_by_email($email)
			->count_all();
		
		$user_limit = $offer->limit_per_user - $user_coupons_nb;
		
		return $user_limit < 0 ? 0 : $user_limit;
	}
	
	public function add_owner(Model_Offer $offer, $email)
	{
		$this->email = $email;
		$this->offer_id = $offer->pk();
		$this->token = $this->_generate_token();
		$this->status = self::STATUS_ACTIVE;
		
		$this->save();
		
		return $this->saved();
	}
	
	protected function _generate_token()
	{
		do
		{
			$token = strtolower(Text::random('alnum', 16));
		} 
		while(!$this->unique('token', $token));
		
		return $token;
	}
	
	public function set_pagination(Pagination $pagination)
	{
		return $this->limit($pagination->items_per_page)
				->offset($pagination->offset);
	}
	
	public function delete_by_offer($offer)
	{
		if(empty($offer))
		{
			return;
		}
		
		DB::delete($this->table_name())
			->where('offer_id', is_array($offer) ? 'IN' : '=', $offer)
			->execute($this->_db);
	}
	
}
