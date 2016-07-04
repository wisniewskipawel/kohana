<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_User_Promotions extends Bform_Form {

	public function  create(array $params = array())
	{
		$this->form_data($params['user']->data->as_array());
		
		Events::fire('admin/form/user/promotions', array('form' => $this, 'user' => $params['user']));
		
		$this->add_input_submit(___('form.save'));
	}
}