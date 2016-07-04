<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Model_User_Group_Permission extends ORM {
	
	protected $_table_name = 'users_groups_permissions';

	public function save_permissions(Model_User_Group $group, $values)
	{
		$this->delete_by_group($group);
		
		if(count($values))
		{
			$insert = DB::insert($this->table_name(), array('group_id', 'permission'));

			foreach($values as $permission)
			{
				$insert->values(array($group->pk(), $permission));
			}

			$insert->execute($this->_db);
		}
	}
	
	public function delete_by_group(Model_User_Group $group)
	{
		DB::delete($this->table_name())
			->where('group_id', '=', (int)$group->pk())
			->execute($this->_db);
	}
	
}