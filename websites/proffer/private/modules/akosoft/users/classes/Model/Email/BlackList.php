<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Model_Email_BlackList extends ORM {
	
	protected $_table_name = 'email_blacklist';
	
	public function save_email($email)
	{
		$this->email = $email;
		$this->save();
		
		return $this->saved();
	}
	
	public function set_pagination(Pagination $pagination)
	{
		return $this->offset($pagination->offset)
			->limit($pagination->items_per_page);
	}
	
	public function filter_by_email($email)
	{
		return $this->where('email', '=', $email);
	}
	
	public static function check_email($email)
	{
		$self = new self();
		$self->filter_by_email($email);
		
		return (bool)$self->count_all();
	}
	
}