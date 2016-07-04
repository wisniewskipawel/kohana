<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Frontend_Jobs_AdvancedSearch extends Form_Jobs_Attributes {

	public $_method = 'get';

	public function create(array $params = array())
	{
		$wheres = array(
			'title_and_description'	 => ___('jobs.forms.search.where.title_and_description'),
			'title'					 => ___('jobs.forms.search.where.title'),
			'description'			 => ___('jobs.forms.search.where.description'),
		);

		$this->add_input_text('phrase', array('required' => FALSE));
		$this->add_select('where', $wheres, array('required' => FALSE));

		$category = NULL;
		if($this->form_data('category_id'))
		{
			$category = new Model_Job_Category((int)$this->form_data('category_id'));
		}

		$this->add_partial_categories($category);
		
		if(Jobs::config('provinces_enabled'))
		{
			$provinces = Regions::provinces();
			$this->add_select('province', Arr::unshift($provinces, NULL, ___('select.choose')), array(
				'class' => 'provinces',
				'required' => FALSE,
			));
		}
		
		$this->add_input_text('city', array('required' => FALSE))
			->add_validator('city', 'Bform_Validator_Html');

		if($category)
		{
			$this->add_partial_attributes($category);
		}

		$this->add_input_submit(___('form.search'));
	}

	public function add_partial_attributes(Model_Job_Category $category)
	{
		$attributes = $category->get_fields();
		$this->_add_attibutes($attributes, NULL, array('required' => FALSE));

		return count($attributes);
	}

	public function add_partial_categories(Model_Job_Category $category = NULL)
	{
		$this->add_orm_categories('category_id', $category, array(
			'label' => ___('jobs.form.category_id'),
			'required' => FALSE, 
			'allow_only_parent' => TRUE,
			'orm' => 'Job_Category',
		));

		return TRUE;
	}

}
