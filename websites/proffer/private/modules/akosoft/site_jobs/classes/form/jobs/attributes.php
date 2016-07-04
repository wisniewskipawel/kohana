<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
abstract class Form_Jobs_Attributes extends Bform_Form {

	protected function _add_attibutes($fields, $attributes = NULL, $extend_field_attributes = NULL)
	{
		$collection = $this->add_collection('attributes', array('label' => ___('jobs.attributes')));

		if($attributes)
		{
			$attributes = $attributes->as_array('category_field_id');
		}

		foreach($fields as $field)
		{
			$field_name =$field->name;
			$options = (array)$field->options;

			$field_attributes = array(
				'label' => $field->label,
				'required' => (bool)Arr::get($options, 'required', FALSE),
			);

			if(isset($attributes[$field->pk()]) AND !empty($attributes[$field->pk()]->value))
			{
				$field_attributes['value'] = $attributes[$field->pk()]->value;
			}

			if($extend_field_attributes)
			{
				$field_attributes = array_merge($field_attributes, $extend_field_attributes);
			}

			switch($field->type)
			{
				case 'select':
					$values = $field->get_option('values');

					if(isset($field_attributes['value']))
					{
						$field_attributes['value'] = array_search($field_attributes['value'], $values);
					}

					$collection->{$field_name} = new Bform_Driver_Select(
						$this,
						$field_name,
						Arr::unshift($values, NULL, ''),
						$field_attributes
					);
					break;

				case 'text':
					$collection->{$field_name} = new Bform_Driver_Input_Text(
						$this,
						$field_name,
						$field_attributes
					);
					break;

				case 'checkbox':
					$collection->{$field_name} = new Bform_Driver_Bool(
						$this,
						$field_name,
						$field_attributes
					);
					break;
			}

			$this->add_validator('attributes.'.$field->name, 'Bform_Validator_Html');

		}

		return $collection;
	}

}
