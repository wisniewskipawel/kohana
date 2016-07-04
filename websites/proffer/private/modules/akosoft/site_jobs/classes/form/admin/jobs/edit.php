<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Admin_Jobs_Edit extends Form_Admin_Jobs_Add {

	public function create(array $params = array()) 
	{
		$job = $params['job'];
		$this->form_data($job->as_array());
		
		parent::create($params);
	}

}
