<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Newsletter_Subscriber extends ORM {
	
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;

	protected $_table_name = 'newsletter_subscribers';
	protected $_primary_key = 'email_id';
	protected $_primary_val = 'email';

	public function add_email($email, $accept_ads = FALSE) 
	{
		if (Validation::factory(array('email' => $email))->rule('email', 'email')->check())
		{
			if ( ! ORM::factory($this->_object_name)->where('email', '=', $email)->count_all())
			{
				$this->accept_ads = !!$accept_ads;
				$this->email = $email;
				$this->email_token = $this->_generate_token();
				$this->status = $accept_ads ? self::STATUS_INACTIVE : self::STATUS_ACTIVE;
				$this->save();
				
				if($this->saved() AND $accept_ads)
				{
					$this->send_confirmation();
				}
				
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	protected function _generate_token()
	{
		do {
			$token = strtolower(Text::random('alnum', 16));
		} while(!$this->unique('email_token', $token));
		
		return $token;
	}
	
	public function confirm()
	{
		$this->status = self::STATUS_ACTIVE;
		$this->save();
	}

	public function count_all_admin(array $filters) 
	{
		$this->_apply_filters($filters);
		return $this->count_all();
	}

	public function get_list_admin(array $filters, $limit, $offset)
	{
		$this->_apply_filters($filters);

		$this->order_by('email_id', 'DESC');
		$this->limit($limit)->offset($offset);

		return $this->find_all();
	}

	protected function _apply_filters(array $filters) 
	{
		if ( ! empty($filters['email'])) 
		{
			$this->where('email', 'LIKE', "%$filters[email]%");
		}
		
		if ( ! empty($filters['accept_ads'])) 
		{
			$this->filter_by_accept_ads($filters['accept_ads']);
		}
	}
	
	public function filter_by_accept_ads($accept = TRUE)
	{
		return $this->where('accept_ads', '=', !!$accept);
	}
	
	public function filter_by_token($token)
	{
		return $this->where('email_token', '=', $token);
	}
	
	public function filter_by_status($status)
	{
		return $this->where('status', '=', (int)$status);
	}
	
	public function increase_sended($nb = 1)
	{
		return DB::update($this->table_name())->set(array(
				'email_sent_count' => DB::expr('email_sent_count+'.$nb),
			))->where($this->primary_key(), '=', $this->pk())
			->execute($this->_db);
	}

	public function delete()
	{
		DB::delete('newsletter_queue')->where('email_id', '=', $this->email_id)->execute();

		return parent::delete();
	}
	
	public function send_confirmation()
	{
		$email = Model_Email::email_by_alias('newsletter_confirmation');
		$email->set_tags(array(
			'%confirmation_link%' => HTML::anchor(Route::url('site_newsletter/frontend/confirmation', array(
				'id' => $this->pk(),
				'token' => $this->email_token,
			), 'http')),
		));
		
		return $email->send($this->email);
	}

}
