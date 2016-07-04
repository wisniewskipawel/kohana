<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Ajax_Regions extends Controller_Ajax_Main {
	
	public function action_counties()
	{
		$province_id = (int)$this->request->query('province_id');
		
		if(empty($province_id))
			throw new HTTP_Exception_404;
		
		$counties = Regions::counties($province_id);
		$array = array();
		
		foreach($counties as $id => $name)
		{
			$array[] = array(
				'id' => $id,
				'name' => $name,
			);
		}
		
		$this->response->body(json_encode($array));
	}
}