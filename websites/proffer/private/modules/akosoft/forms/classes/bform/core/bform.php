<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Bform_Core_Bform {

	// button types
	const BUTTON_TYPE_SUBMIT = 'submit';
	const BUTTON_TYPE_CANCEL = 'cancel';
	const BUTTON_TYPE_SUBMIT_AND_ADD = 'submit_and_add';

	/**
	 * Factory of forms.
	 *
	 * @param string $class_name Class name of the form. Newly create class which represent a sigle form should have a "Form_" prefix in the name.
	 * This prefix will be added automatically, so You don't have to pass it in this param.
	 * @param array $bind_values Saved data, for example from ORM::as_array(). If array key is the same as driver name driver will have an array value.
	 * @param array $params Other form html params.
	 * @static
	 * @access public
	 * @return Bform_Form
	 */
	public static function factory($class_name, array $bind_values = array(), array $params = array(), $allow_initialize = TRUE)
	{
		if($class_name instanceof Bform_Form)
		{
			$form = $class_name;
		}
		else
		{
			if(strpos($class_name, 'Form_') === FALSE)
			{
				$class_name = 'Form_' . $class_name;
			}

			if ( ! class_exists($class_name))
			{
				throw new Bform_Exception("Class :class_name doesn't exists!", array(':class_name' => $class_name));
			}

			$form = new $class_name($params);
		}

		if($allow_initialize)
		{
			$form->create($bind_values);
			$form->after();
		}

		return $form;
	}
	
}
