<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Queue_Processor {
	
	protected $_config = NULL;
	
	public function __construct()
	{
		$this->_config = Kohana::$config->load('queue');
	}
	
	protected function get_class_for_job(Model_Queue $job)
	{
		if(class_exists($job->name))
		{
			return new $job->name(unserialize($job->params), $job->priority);
		}
		
		return FLASE;
	}
	
	public function execute()
	{
		$model = new Model_Queue();
		$jobs = $model->find_active_jobs($this->_config['limit']);
		
		if(count($jobs))
		{
			foreach($jobs as $job)
			{
				try {
					if($class_job = $this->get_class_for_job($job))
					{
						if($class_job->validate())
						{
							$class_job->execute();
						}

						$job->set_success();
					}
					else
					{
						throw new Kohana_Exception('Cannot find class for job #:id (:name)', array(
							':id' => $job->pk(),
							':name' => $job->name,
						));
					}
				}
				catch(Exception $ex)
				{
					Kohana::$log->add(Log::ERROR, 'Error while executing job #:id (:name): :error', array(
						':id' => $job->pk(),
						':name' => $job->name,
						':error' => Kohana_Exception::text($ex),
					));
					
					Kohana_Exception::log($ex, Log::ERROR);

					$job->set_error();
				}
			}
		}
		
		$model->garbage_collector();
	}
	
}