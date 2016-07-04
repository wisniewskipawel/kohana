<?php
/**
 * @author	AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */
class Model_Job_Category_Field extends ORM {

	protected $_table_name = 'job_category_fields';
	protected $_serialize_columns = array('options');

	public function add_field($values)
	{
		$this->values($values);
		$this->save();

		return $this->saved();
	}

	public function edit_field($values)
	{
		$this->values($values);
		$this->save();

		return $this->saved();
	}

	public function get_option($name)
	{
		$options = (array)$this->options;

		switch($name)
		{
			case 'required':
				return (bool)Arr::get($options, $name, FALSE);

			case 'values':
				$values = explode("\n", Arr::get($options, $name, ''));
				return array_combine($values, $values);

			default:
				return Arr::get($options, $name);
		}
	}

	public function delete_by_category($category)
	{
		if(empty($category))
		{
			return;
		}

		DB::delete('job_category_to_field')
			->where('category_id', is_array($category) ? 'IN' : '=', $category)
			->execute($this->_db);
	}

	protected function _unserialize_value($value)
	{
		return json_decode($value, TRUE);
	}

	public static function types()
	{
		return array(
			'text' => array(
				'name' => ___('jobs.admin.fields.types.text'),
			),
			'select' => array(
				'name' => ___('jobs.admin.fields.types.select'),
			),
			'checkbox' => array(
				'name' => ___('jobs.admin.fields.types.checkbox'),
			),
		);
	}

}
