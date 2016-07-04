<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
abstract class Contact {
	
	const TYPE_PERSON = 'person';
	const TYPE_COMPANY = 'company';
	
	public $name;

	public $address;
	
	public $phone;
	
	public $email;
	
	public $www;
	
	public static function factory($type)
	{
		switch($type)
		{
			case self::TYPE_PERSON:
				return new Contact_Person;
				
			case self::TYPE_COMPANY:
				return new Contact_Company;
		}
		
		throw new Kohana_Exception('Invalid contact type: :type', array(
			':type' => $type,
		));
	}

	public function display_name()
	{
		return $this->name;
	}
	
	public function render($view = 'default', $view_options = array())
	{
		return View::factory('contact_data/'.$view, $view_options)
			->set('contact', $this);
	}
	
}