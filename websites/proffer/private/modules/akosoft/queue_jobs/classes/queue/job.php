<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
abstract class Queue_Job {
	
	protected $_params = NULL;
	
	protected $_priority = NULL;
	
	public function __construct($params = NULL, $priority = 5)
	{
		$this->_params = $params;
		$this->_priority = $priority;
	}
	
	public function get_name()
	{
		return get_class($this);
	}
	
	public function get_params()
	{
		return $this->_params;
	}

	public function get_priority()
	{
		return $this->_priority;
	}

	public function set_params($_params)
	{
		$this->_params = $_params;
		return $this;
	}

	public function set_priority($_priority)
	{
		$this->_priority = $_priority;
		return $this;
	}
	
	public function validate()
	{
		return TRUE;
	}
	
	public function execute()
	{
		throw new Kohana_Exception('You must define execute method for job: :job', array(
			':job' => $this->get_name(),
		));
	}
	
	public function save()
	{
		$model = new Model_Queue();
		return $model->add_job($this);
	}

}
