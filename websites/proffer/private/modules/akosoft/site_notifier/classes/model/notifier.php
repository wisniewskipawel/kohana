<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Notifier extends ORM {
	
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;
	
	protected $_table_name = 'notifiers';
	protected $_primary_key = 'notify_id';
	protected $_primary_val = 'notify_email';
	
	public function is_active()
	{
		return $this->status == self::STATUS_ACTIVE;
	}
	
	public function get_categories()
	{
		return explode(',', $this->notify_categories);
	}
	
	public function send_confirmation_email()
	{
		$email = new Model_Email();
		$email->find_by_alias('notifier_confirmation');
		
		if(!$email->loaded())
			throw new Kohana_Exception('NOTIFIER: Cannot send confirmation e-mail - no e-mail content!');
		
		$email->set_tags(array(
			'%confirmation_link%' => HTML::anchor(Route::url('site_notifier/frontend/notifier/confirmation', array(
				'id' => $this->pk(),
				'token' => $this->token,
			), 'http'), $email->email_subject),
		));
		
		return $email->send($this->notify_email);
	}

	public function filter_by_active()
	{
		return $this->where($this->object_name().'.status', '=', self::STATUS_ACTIVE);
	}
	
	public function find_by_email($email)
	{
		return $this->where($this->object_name().'.notify_email', '=', $email)
			->find();
	}
	
	public function add_notify($module_name, $data)
	{
		$email = Arr::get($data, 'email');
		
		$this->filter_by_module($module_name);
		$this->find_by_email($email);
		
		if(!$this->loaded())
		{
			$this->notify_email = $email;
			$this->module = $module_name;
		}
		
		$this->notify_provinces = Arr::get($data, 'province', 'all');
		$this->notify_provinces = $this->notify_provinces == 'all' ? '' : (int)$this->notify_provinces;
		
		$categories = Arr::get($data, 'categories');
		
		if(!empty($categories))
		{
			$cats = array();
			foreach($categories as $id)
			{
				$id = intval($id);
				if ($id)
				{
					$cats[] = $id;
				}
				
				$this->notify_categories = implode(',', $cats);
			}
		}
		
		$send_confirmation = Kohana::$config->load('modules.site_notifier.settings.send_confirmation');
		
		$this->status = $send_confirmation ? self::STATUS_INACTIVE : self::STATUS_ACTIVE;
		
		do {
			$token = Text::random(NULL, 16);
		} while(!$this->unique('token', $token));
		
		$this->token = $token;
		
		$this->save();
		
		if($this->saved() && $send_confirmation)
		{
			$this->send_confirmation_email();
		}
		
		return $this->saved();
	}
	
	public function edit_notifier($values)
	{
		$this->values($values)->save();
		
		return $this->saved();
	}
	
	public function confirm_email()
	{
		$this->status = self::STATUS_ACTIVE;
		
		$this->save();
		
		return $this->saved();
	}
	
	public function filter_by_token($token)
	{
		return $this->where($this->object_name().'.token', '=', $token);
	}
	
	public function filter_by_module($module)
	{
		return $this->where('module', '=', $module);
	}
	
	public function find_by_pk($pk)
	{
		return $this->where($this->object_name().'.'.$this->primary_key(), '=', (int)$pk)
			->find();
	}
	
	public function find_subscribers()
	{
		return $this->find_all();
	}
	
	public function set_pagination(Pagination $pagination)
	{
		return $this->offset($pagination->offset)
				->limit($pagination->items_per_page);
	}
	
	public static function get_max_categories_level()
	{
		return DB::select(array(DB::expr('MAX(category_level)'), 'max_level'))
			->from('announcement_categories')
			->execute()
			->get('max_level');
	}
	
}
