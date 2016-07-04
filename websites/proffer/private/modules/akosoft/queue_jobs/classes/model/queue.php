<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Model_Queue extends ORM {
	
	const STATUS_DELETE = -2;
	const STATUS_ERROR = -1;
	const STATUS_ACTIVE = 0;
	const STATUS_SUCCCESS = 1;
	
	protected $_table_name = 'queue';
	
	protected $_created_column = array(
		'column' => 'date_added',
		'format' => 'Y:m:d H:i:s',
	);
	
	public function add_job(Queue_Job $job)
	{
		$this->name = $job->get_name();
		$this->params = serialize($job->get_params());
		$this->priority = $job->get_priority();
		$this->status = self::STATUS_ACTIVE;
		$this->save();
	}
	
	public function set_error()
	{
		$this->status = ($this->status == self::STATUS_ERROR) ? self::STATUS_DELETE : self::STATUS_ERROR;
		$this->timestamp = date('Y-m-d H:i:s');
		$this->save();
		
		return $this->saved();
	}
	
	public function set_success()
	{
		$this->status = self::STATUS_SUCCCESS;
		$this->timestamp = date('Y-m-d H:i:s');
		$this->save();
		
		return $this->saved();
	}
	
	public function filter_by_active()
	{
		return $this->where($this->object_name().'.status', 'IN', array(self::STATUS_ACTIVE, self::STATUS_ERROR));
	}
	
	public function find_active_jobs($limit = NULL)
	{
		$this->filter_by_active();
		
		if($limit)
		{
			$this->limit($limit);
		}
		
		$this->order_by('status', 'DESC');
		$this->order_by('priority', 'DESC');
		$this->order_by('date_added', 'ASC');
		
		return $this->find_all();
	}
	
	public function garbage_collector()
	{
		DB::delete($this->table_name())
			->where('status', 'IN', array(self::STATUS_SUCCCESS, self::STATUS_DELETE))
			->where('timestamp', '<', date('Y-m-d H:i:s', time()-(2*Date::WEEK)))
			->execute($this->_db);
	}
	
}
