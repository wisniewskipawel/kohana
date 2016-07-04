<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Button extends Bform_Driver_Common {

	/**
	 * Additional fields in data containers
	 * 
	 * @var array
	 * @access public
	 */
	public $_custom_data = array(
		'_data' => array(
			'required' => FALSE,
			'type' => ''
		)
	);

	/**
	 * Creates a driver
	 * 
	 * @param Bform_Form $form
	 * @param string $type
	 * @param string $value
	 * @param type $info
	 * @return self
	 */
	public function __construct(Bform_Core_Form $form, $type, $value, $info = array())
	{
		$info['value'] = ___($value);
		$info['type'] = $type;

		if ($type == Bform::BUTTON_TYPE_SUBMIT)
		{
			$name = 'submit';
		} 
		elseif ($type == Bform::BUTTON_TYPE_CANCEL) 
		{
			$name = 'cancel';
		} 
		elseif ($type == Bform::BUTTON_TYPE_SUBMIT_AND_ADD) 
		{
			$name = 'submit_and_add';
		} 
		else 
		{
			$name = Text::random();
		}
		
		parent::__construct($form, $name, $info);
	}
	
}
