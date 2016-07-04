<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Ajax_Auth extends Controller_Ajax_Main {
	
	public function action_user_name_unique()
	{
		$user_name = $this->request->query('user_name');
		
		if($user_name)
		{
			$this->response->headers('Content-Type', 'application/json');
			$this->response->body(json_encode(array(
				'result' => Model_User::factory()->unique('user_name', $user_name),
			)));
		}
	}
	
}