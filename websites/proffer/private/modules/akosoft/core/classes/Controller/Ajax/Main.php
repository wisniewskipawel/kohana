<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

abstract class Controller_Ajax_Main extends Controller {
	
	protected $_auth = NULL;
	protected $_session = NULL;
	
	public function after()
	{
		parent::after();
	}

	/**
	 * @param $data
	 * @return null
	 */
	public function response_json($data)
	{
		$this->response->headers('Content-Type', 'application/json');
		$this->response->body(json_encode($data));
		return NULL;
	}

}
