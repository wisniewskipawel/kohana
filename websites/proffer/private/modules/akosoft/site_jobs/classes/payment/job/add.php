<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Payment_Job_Add extends Payment_Module {
	
	protected $_place = 'job_add';
	
	public function load_object($object = NULL)
	{
		if($object)
		{
			return parent::load_object($object);
		}
		else
		{
			$this->_object = Model_Job::factory()->find_by_pk($this->object_id());
		}
	}
	
	public function is_valid()
	{
		if(!parent::is_valid())
			return FALSE;
		
		if(!$this->_object->loaded())
			return FALSE;
		
		//TODO check method, availability, owner check
		
		return TRUE;
	}
	
	public function get_payment_data()
	{
		$data = array(
			'id' => $this->_object->pk(),
			'title' => $this->get_title(),
			'description' => ___($this->get_module_name().'.payments.'.$this->get_payment_module_name().'.description', array(
				':title' => HTML::chars($this->_object->title),
			)),
			'quantity' => 1,
			'uid' => $this->get_payment_module_name().'|'.$this->_object->pk(),
		);
		
		return $data;
	}
	
	public function redirect_url($type)
	{
		if($type == self::SUCCESS)
		{
			return Jobs::uri($this->_object).URL::query(array('preview' => '1'), FALSE);
		}
		else
		{
			return parent::redirect_url($type);
		}
	}
	
	public function success($user_context = TRUE)
	{
		if($result = parent::success($user_context))
		{
			$this->_object->set_paid();
			
			if($user_context)
			{
				FlashInfo::add(___('jobs.approve.success'));
			}
			
			return $result;
		}
		
		return self::ERROR;
	}
	
	public function get_module_name()
	{
		return 'site_jobs';
	}
	
	public function get_payment_module_name()
	{
		return 'job_add';
	}
	
	public function set_job(Model_Job $job)
	{
		$this->load_object($job);
		$this->object_id($job->pk());
		$this->_params['id'] = $job->pk();
		
		return $this;
	}
	
}
