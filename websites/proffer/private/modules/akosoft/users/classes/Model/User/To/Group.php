<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Model_User_To_Group extends ORM {
    
	protected $_table_name = 'users_to_groups';
	protected $_primary_key = 'user_to_user_group_id';

	protected $_belongs_to = array(
		'group'   => array('model' => 'User_Group', 'foreign_key' => 'group_id')
	);
	
	public function delete_by_group($group)
	{
		DB::delete($this->table_name())
			->where('group_id', '=', $group instanceof Model_User_Group ? $group->pk() : (int)$group)
			->execute($this->_db);
	}
	
	public function delete_by_user($user)
	{
		DB::delete($this->table_name())
			->where('user_id', '=', $user instanceof Model_User ? $user->pk() : (int)$user)
			->execute($this->_db);
	}

}
