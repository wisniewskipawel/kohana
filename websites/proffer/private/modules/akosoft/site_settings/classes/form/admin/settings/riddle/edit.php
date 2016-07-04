<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Settings_Riddle_Edit extends Form_Admin_Settings_Riddle_Add {
	
	public function create(array $params = array())
	{
		$this->form_data($params['riddle']);
		
		parent::create($params);
	}
	
}