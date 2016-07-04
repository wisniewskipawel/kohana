<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Cron_Notifier extends Controller_Cron_Main {
	
	public function action_send()
	{
		Events::fire('notifiers/send');
	}
}
