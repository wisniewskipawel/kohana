<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Cron_Queue extends Controller_Cron_Main {
	
	public function action_execute()
	{
		$processor = new Queue_Processor;
		$processor->execute();
	}
	
}
