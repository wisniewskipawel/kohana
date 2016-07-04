<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Model_User_Group extends ORM {
	
	const GROUP_ADMIN = 1;
	const GROUP_ADSYSTEM = 3;
	const GROUP_SUPERADMIN = 4;
    
	protected $_table_name = 'users_groups';
	protected $_primary_key = 'group_id';

	protected $_has_many = array(
		'permissions' => array('model' => 'User_Group_Permission', 'foreign_key' => 'group_id'),
	);
	
	public function add_group($values)
	{
		$this->values($values);
		$this->save();
		
		return $this->saved();
	}
	
	public function edit_group($values)
	{
		$this->values($values);
		$this->save();
		
		return $this->saved();
	}
	
	public function filter_no_default_groups()
	{
		return $this->where($this->object_name().'.'.$this->primary_key(), 'NOT IN', array(
			self::GROUP_ADMIN, self::GROUP_ADSYSTEM, self::GROUP_SUPERADMIN,
		));
	}
	
	public function is_default_group()
	{
		return in_array($this->pk(), array(
			self::GROUP_ADMIN, self::GROUP_ADSYSTEM, self::GROUP_SUPERADMIN,
		));
	}
	
	public function delete()
	{
		Model_User_To_Group::factory()->delete_by_group($this);
		Model_User_Group_Permission::factory()->delete_by_group($this);
		
		return parent::delete();
	}
	
}
