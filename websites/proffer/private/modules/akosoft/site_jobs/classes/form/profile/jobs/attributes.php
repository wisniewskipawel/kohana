<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Profile_Jobs_Attributes extends Form_Jobs_Attributes {

	public function create(array $params = array())
	{
		$job = $params['job'];
		$category = $params['category'];

		$values = $job->get_attributes();

		$attributes = $category->get_fields();
		$this->_add_attibutes($attributes, $values);

		$this->add_input_submit(___('form.save'));

		$this->template('site');
	}

}
