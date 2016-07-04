<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Model_Job_To_Category extends ORM {

	protected $_table_name = 'jobs_to_categories';
	protected $_primary_key = 'id';

	protected $_belongs_to = array(
		'job'	  => array('model' => 'Job', 'foreign_key' => 'job_id')
	);
	
	public function delete_by_job($job)
	{
		if(empty($job))
		{
			return;
		}
		
		DB::delete($this->table_name())
			->where('job_id', is_array($job) ? 'IN' : '=', $job)
			->execute($this->_db);
	}
	
	public function delete_by_category($category)
	{
		if(empty($category))
		{
			return;
		}
		
		DB::delete($this->table_name())
			->where('category_id', is_array($category) ? 'IN' : '=', $category)
			->execute($this->_db);
	}

}
