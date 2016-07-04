<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Model_Job_Closet extends ORM {

	protected $_table_name = 'jobs_closet';
	protected $_primary_key = 'id';

	protected $_belongs_to = array(
		'job'	  => array('model' => 'Job', 'foreign_key' => 'job_id'),
		'user'	  => array('model' => 'User', 'foreign_key' => 'user_id'),
	);
	
	public function add_to_closet(Model_Job $job, Model_User $user)
	{
		if($this->check_duplicates($job, $user))
		{
			return TRUE;
		}
		
		$this->job_id = $job->pk();
		$this->user_id = $user->pk();
		$this->save();
		
		return $this->saved();
	}
	
	public function find_closet_job($job, Model_User $user)
	{
		$this->filter_by_user($user);
		$this->filter_by_job($job);
		return $this->find();
	}
	
	public function check_duplicates(Model_Job $job, Model_User $user)
	{
		$this->filter_by_user($user);
		$this->filter_by_job($job);
		return $this->count_all() > 0;
	}
	
	public function build_query_user_closet($query_builder, Model_User $user)
	{
		return $query_builder
			->distinct('job_id')
			->join(array($this->table_name(), 'job_closet'), 'RIGHT')
			->on('job.id', '=', 'job_closet.job_id')
			->where('job_closet.user_id', '=', (int)$user->pk());
	}

	public function filter_by_user($user)
	{
		if($user instanceof Model_User)
		{
			$user = $user->pk();
		}
		
		return $this->where($this->object_name() . '.user_id', '=', (int)$user);
	}

	public function filter_by_job($job)
	{
		if($job instanceof Model_Job)
		{
			$job = $job->pk();
		}
		
		return $this->where($this->object_name() . '.job_id', '=', (int)$job);
	}
	
	public function delete_by_job($job)
	{
		if(empty($job))
		{
			return;
		}
		
		return DB::delete($this->table_name())
			->where('job_id', is_array($job) ? 'IN' : '=', $job)
			->execute($this->_db);
	}
	
	public static function count_by_user(Model_User $user)
	{
		$model = new Model_Job;
		return $model->apply_filters(array(
			'closet_user' => $user,
		))->count_all();
	}

}
