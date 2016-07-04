<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
abstract class Controller_Profile_Main extends Controller_Frontend_Main {
	
	public function before() 
	{
		parent::before();
		
		$this->logged_only();
	}
	
}
