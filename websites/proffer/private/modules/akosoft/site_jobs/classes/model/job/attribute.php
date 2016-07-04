<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Model_Job_Attribute extends ORM {

	protected $_belongs_to = array(
		'field' => array('model' => 'Job_Category_Field', 'foreign_key' => 'category_field_id'),
	);

	public function filter_by_not_empty()
	{
		return $this->where('value', '!=', '');
	}

	public function save_attributes(Model_Job $job, $values)
	{
		if(empty($values))
		{
			return NULL;
		}

		$fields = $job->get_last_category()->get_fields();
		$attributes = $job->get_attributes()->as_array('category_field_id');

		$insert_query = DB::insert($this->table_name())
			->columns(array('job_id', 'category_field_id', 'value'));

		$counter = 0;
		foreach($values as $name => $value)
		{
			if(isset($fields[$name]))
			{
				if(isset($attributes[$fields[$name]->pk()]))
				{
					$attribute = $attributes[$fields[$name]->pk()];
					$attribute->value = self::prepare_value($fields[$name], $value);
					$attribute->save();
				}
				else
				{
					$insert_query->values(array(
						'job_id' => $job->pk(),
						'category_field_id' => $fields[$name]->pk(),
						'value' => self::prepare_value($fields[$name], $value),
					));

					$counter++;
				}
			}
		}

		if($counter)
		{
			$insert_query->execute($this->_db);
		}
	}
	
	public function filter_by_job(Model_Job $job)
	{
		return $this->where('job_id', '=', (int)$job->pk());
	}
	
	public function find_for_job(Model_Job $job)
	{
		$this->with('field');
		
		$this->filter_by_job($job);
		
		if($job->has_category())
		{
			$category = $job->get_last_category();
			
			$this->join('job_category_to_field')
				->on('job_category_to_field.category_field_id', '=', $this->object_name().'.category_field_id')
				->on('job_category_to_field.category_id', '=', DB::expr($category->pk()));
			
			$this->order_by('job_category_to_field.id', 'ASC');
		}
		
		return $this->find_all();
	}
	
	public function delete_by_job($job)
	{
		if(empty($job))
		{
			return;
		}
		
		DB::delete($this->table_name())
			->where('job_id', is_array($job) ? 'IN' : '=', $job)
			->execute($this->_db);
	}

	public static function prepare_value(Model_Job_Category_Field $field, $value)
	{
		switch($field->type)
		{
			case 'select':
				return empty($value) ? NULL : Arr::get($field->get_option('values'), $value);

			case 'checkbox':
				return $value ? $value : '';

			default:
				return $value;
		}
	}

}