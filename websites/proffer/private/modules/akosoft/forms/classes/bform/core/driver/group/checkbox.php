<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Group_Checkbox extends Bform_Driver_Input_Checkbox {

	public $_custom_data = array(
		'_html' => array(
			'checked' => FALSE,
		),
		'_data' => array(
			'parent' => NULL
		)
	);

	public $_observers = array(
		'Bform_Observer_Var_Get_Group_Checkbox_Checked',
	);

	public static function factory(Bform_Form $form, $name, array $info = array())
	{
		return new Bform_Driver_Group_Checkbox($form, $name, $info);
	}

}
