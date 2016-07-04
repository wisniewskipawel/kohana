<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Widget_Jobs_Categories extends Widget_Box {
	
	public function render($view_file = 'widget/jobs/categories/sidebar')
	{
		$query = Request::current()->query();
		
		$province_id = Arr::get($query, 'province');
		$city = Arr::get($query, 'city');
		
		$model = new Model_Job_Category;
		
		$this->set('categories', $model->get_categories_list(array(
				'province' => $province_id,
				'city' => $city,
			)));
		
		return parent::render($view_file);
	}
	
}