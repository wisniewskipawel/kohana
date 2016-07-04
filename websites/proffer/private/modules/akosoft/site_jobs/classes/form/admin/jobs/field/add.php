<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Admin_Jobs_Field_Add extends Bform_Form {

	public function __construct(array $options = array())
	{
		parent::__construct($options);
		
		$this->param('i18n_namespace', 'jobs.admin.fields.forms');
	}
	
	public function create(array $params = array())
	{
		$values = $this->form_data();

		$this->add_input_text('label')
			->add_validator('label', 'Bform_Validator_Length', array('max' => 16));
		
		$this->add_input_text('name')
			->add_validator('name', 'Bform_Validator_Regex', array(
				'regex' => '/^[a-z0-9\-_]+$/', 
				'error' => ___('jobs.admin.fields.forms.name.error', 'regex')
			))
			->add_validator('name', 'Bform_Validator_Length', array('max' => 32));

		$types = Model_Job_Category_Field::types();
		$this->add_select('type', Arr::pluck($types, 'name', TRUE));
		
		$this->on_type_change(Arr::get($values, 'type'));

		$this->add_input_submit(___('form.save'));
	}
	
	public function on_type_change($type)
	{
		$this->add_collection('options', array('decorate' => TRUE));
		
		$this->options->add_bool('required');
		
		if($type == 'select')
		{
			$this->options->add_textarea('values', array(
				'html_before' => ___('jobs.admin.fields.forms.options.values.info'),
			));
		}
	}

}