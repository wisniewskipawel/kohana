<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Model_Job_Reply extends ORM implements IEmailMessageReceiver {
	
	protected $_table_name = 'job_replies';
	
	protected $_belongs_to = array(
		'job' => array('model' => 'Job'),
		'user' => array('model' => 'User', 'foreign_key' => 'user_id'),
	);
	
	protected $_created_column = array(
		'format' => 'Y-m-d H:i:s',
		'column' => 'date_added',
	);
	
	protected $_updated_column = array(
		'format' => 'Y-m-d H:i:s',
		'column' => 'date_updated',
	);
	
	public function add_reply(Model_Job $job, $values)
	{
		$this->job_id = $job->pk();
		
		$this->values($values, array('content', 'price', 'price_unit', 'user_id'));
		$this->ip_address = Request::$client_ip;
		
		$this->save();
		
		return $this->saved();
	}
	
	public function edit_reply($values)
	{
		$this->values($values, array('content', 'price', 'price_unit'));
		$this->save();
		
		return $this->saved();
	}
	
	public function filter_by_job(Model_Job $job)
	{
		return $this->where($this->object_name().'.job_id', '=', (int)$job->pk());
	}

	public function count_by_job(Model_Job $job)
	{
		$this->filter_by_job($job);
		
		return $this->count_all();
	}
	
	public function find_by_job(Model_Job $job, $order_dir = 'ASC')
	{
		$this->filter_by_job($job);
		
		$order_dir = strtolower($order_dir) == 'asc' ? 'asc' : 'desc';
		
		$this->order_by('date_added', $order_dir);
		
		return $this->find_all();
	}
	
	public function delete_by_job($jobs)
	{
		if(empty($jobs))
		{
			return;
		}
		
		$replies = DB::select($this->primary_key())
			->from($this->table_name())
			->where('job_id', 'IN', (array)$jobs)
			->group_by($this->primary_key())
			->execute($this->_db)
			->as_array(NULL, $this->primary_key());
			
		$this->delete_replies($replies);
	}
	
	public function delete_replies($replies)
	{
		if(empty($replies))
		{
			return;
		}

		DB::delete($this->table_name())
			->where($this->primary_key(), 'IN', (array)$replies)
			->execute($this->_db);
	}
	
	public function delete()
	{
		$this->delete_replies($this->pk());
		
		$this->clear();
		
		return $this;
	}
	
	public function has_user()
	{
		return $this->user_id AND $this->user->loaded();
	}
	
	public function get_user()
	{
		return $this->has_user() ? $this->user : NULL;
	}

	public function get_email_address()
	{
		$user = $this->get_user();
		return $user ? $user->get_email_address() : NULL;
	}

	public function send_email_message($subject, $message = NULL, $params = NULL)
	{
		if($subject instanceof Model_Email)
		{
			return $subject->send($this->get_email_address(), $params);
		}

		return Email::send($this->get_email_address(), $subject, $message, $params);
	}
	
	public static function get_price_units()
	{
		return array(
			'all'	=> ___('jobs.replies.price_units.all'),
			'hour'	=> ___('jobs.replies.price_units.hour'),
			'item'	=> ___('jobs.replies.price_units.item'),
		);
	}

}