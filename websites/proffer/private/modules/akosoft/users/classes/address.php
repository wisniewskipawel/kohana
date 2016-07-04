<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Address {
	
	public $country;
	
	public $province_id;
	public $province;
	
	public $county_id;
	public $county;
	
	public $city;
	
	public $postal_code;
	
	public $street;
	
	public function render($view = 'default', $view_options = array())
	{
		return View::factory('contact_data/address/'.$view, $view_options)
			->set('address', $this);
	}
	
}