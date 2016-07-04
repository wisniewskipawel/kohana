<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class BForm_Core_Driver_ORM_Categories extends Bform_Core_Driver_Base {

	public $_custom_data = array(
		'_data' => array(
			'category' => NULL,
			'value' => NULL,
			'allow_only_parent' => FALSE,
			'orm' => NULL,
			'template' => 'compact',
		),
		'_html'     => array(
			'category' => NULL,
			'value' => NULL,
			'row_class' => 'ajax_orm_categories',
		)
	);

	public function __construct(Bform_Core_Form $form, $name, $category, $info = array())
	{
		if($category)
		{
			$info['category'] = $category;
			$info['value'] = $category->pk();
		}

		parent::__construct($form, $name, $info);
		
		$this->add_validator('Bform_Validator_ORM_Categories');
	}
	
	public function validate_allow_only_parent()
	{
		$this->_load_category();
		
		if($this->data('category'))
		{
			return !$this->data('category')->has_children();
		}
		
		return FALSE;
	}
	
	protected function _get_model()
	{
		if($orm_model = $this->data('model'))
		{
			return clone $orm_model;
		}
		
		return ORM::factory($this->data('orm'));
	}
	
	protected function _load_category()
	{
		if(!$this->data('category') AND $this->data('value'))
		{
			$this->data('category', $this->_get_model()->find_by_pk($this->data('value')));
		}
	}
	
	protected function _render_driver()
	{
		$selected_categories = NULL;
		
		$this->_load_category();

		if($this->data('category'))
		{
			$model = $this->_get_model();
			$categories = $model->get_full_levels($this->data('category'), TRUE, FALSE);

			$selected_categories = $model->get_path($this->data('category'))
				->as_array('category_level', 'category_id');
		}
		else
		{
			$categories = array(
				1 => $this->_get_model()
					->find_by_pk(1)
					->get_children()
					->as_array('category_id', 'category_name'),
			);
		}

		return View::factory('bform/shared/drivers/orm/categories/'.$this->data('template'))
				->set('driver', $this)
				->set('level_categories', $categories)
				->set('selected_categories', $selected_categories)
				->render();
	}
}
