<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Form_Admin_User_Groups_Edit extends Form_Admin_User_Groups_Add {
	
	public function create(array $params = array())
	{
		$this->form_data($params['group']->as_array());
		
		parent::create($params);
	}
	
}