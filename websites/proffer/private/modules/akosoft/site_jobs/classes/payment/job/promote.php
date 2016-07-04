<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Payment_Job_Promote extends Payment_Module {
	
	protected $_invoice_enabled = TRUE;
	
	protected $_place = 'job_promote';
	
	protected $_providers_enabled_group = FALSE;
	
	protected $_distinction;
	
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
			
		$this->set_distinction(Arr::get($this->_params, 'distinction'));
	}
	
	public function is_valid()
	{
		if(!parent::is_valid())
			return FALSE;
		
		if(!$this->_object->loaded())
			return FALSE;
		
		if(empty($this->_params['distinction']))
			return FALSE;
		
		if(!Arr::get($this->get_distinctions(), $this->_params['distinction'], FALSE))
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
				':distinction'		=> Arr::get($this->get_distinctions(), $this->_params['distinction']),
			)),
			'quantity' => 1,
			'uid' => $this->get_payment_module_name().'|'.$this->_params['distinction'].'|'.$this->_object->pk(),
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
			$this->_object->promote($this->_params['distinction']);
			
			if($user_context)
			{
				FlashInfo::add(___('jobs.promote.success'));
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
		return 'job_promote';
	}
	
	public function get_type()
	{
		if(!$this->_params['distinction'])
		{
			throw new InvalidArgumentException('You must first set distinction!');
		}
		
		return $this->_params['distinction'];
	}
	
	public function set_distinction($distinction)
	{
		$this->_params['distinction'] = $distinction;
		
		return $this;
	}
	
	public function get_distinctions()
	{
		return Jobs::distinctions();
	}
	
	public function set_job(Model_Job $job)
	{
		$this->load_object($job);
		$this->object_id($job->pk());
		$this->_params['id'] = $job->pk();
		
		return $this;
	}
	
}
