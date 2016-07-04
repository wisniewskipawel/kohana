<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Model_Job_Availability extends ORM {

	protected $_table_name = 'job_availabilities';
	protected $_primary_key = 'id';

	public function get_admin() 
	{
		$this->order_by('availability', 'ASC');
		return $this->find_all();
	}

}
