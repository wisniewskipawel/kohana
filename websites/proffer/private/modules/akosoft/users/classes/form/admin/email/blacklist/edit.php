<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Form_Admin_Email_Blacklist_Edit extends Form_Admin_Email_Blacklist_Add {
	
	public function create(array $params = array())
	{
		$this->form_data($params['email_blacklist']->as_array());
		
		$params['is_edit'] = TRUE;
		parent::create($params);
	}
	
}
