<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Test_Notifier extends Controller {
	
	public function action_announcements()
	{
		$id = $this->request->query('id');
		
		$notifier = new Model_Notifier($id);
		echo count($notifier->get_announcements());
	}
	
}