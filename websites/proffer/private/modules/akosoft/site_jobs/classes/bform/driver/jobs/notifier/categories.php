<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class BForm_Driver_Jobs_Notifier_Categories extends Bform_Driver_Common {

	public $_custom_data = array(
		'_data' => array(
			'categories' => NULL,
			'value' => array(),
		),
		'_html'     => array(
			'value' => array(),
		)
	);

	public function __construct(Bform_Core_Form $form, $name, $categories, array $info = array())
	{
		$info['categories'] = $categories;

		parent::__construct($form, $name, $info);
	}

	public function get_value()
	{
		return Request::current()->post($this->data('name'));
	}

	protected function _render_driver()
	{
		return View::factory('jobs/bform/driver/categories')
			->set('driver', $this);
	}

}
