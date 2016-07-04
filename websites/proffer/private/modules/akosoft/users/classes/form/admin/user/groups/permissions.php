<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Form_Admin_User_Groups_Permissions extends Bform_Form {
	
	public function create(array $params = array())
	{
		$permissions = $params['permissions'];
		$group = $params['group'];
		
		$this->form_data($group->permissions->find_all()->as_array('permission', 'permission'));
		
		foreach($permissions as $permission_group_name => $permission_group)
		{
			$collection = $this->add_fieldset($permission_group_name, $permission_group['name']);
			
			foreach($permission_group['secure_actions'] as $permission_path => $permission_label)
			{
				$collection->add_input_checkbox($permission_path, $permission_path, array(
					'label' => $permission_label,
					'required' => FALSE,
				));
			}
		}
		
		$this->add_input_submit(___('form.save'));
	}
	
}