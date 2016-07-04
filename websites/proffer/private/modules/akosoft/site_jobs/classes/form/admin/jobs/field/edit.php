<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Admin_Jobs_Field_Edit extends Form_Admin_Jobs_Field_Add {

	public function create(array $params = array())
	{
		$field = $params['field'];
		$this->form_data($field->as_array());

		parent::create($params);
	}

}