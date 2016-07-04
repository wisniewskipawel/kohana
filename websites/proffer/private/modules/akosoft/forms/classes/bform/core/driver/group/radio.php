<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Group_Radio extends Bform_Driver_Base {

	/**
	 *  Additional fields in data containers
	 * 
	 * @access public
	 * @var array
	 */
	public $_custom_data = array(
		'_data'     => array(
			'values'  => FALSE,
		),
	);
	
	public function __construct(Bform_Core_Form $form = NULL, $name, $values, $options = array())
	{
		parent::__construct($form, $name, $options);
		
		if($values)
		{
			foreach($values as $name => $label)
			{
				$this->add_option($name, $label);
			}
		}
	}
	
	public function add_option($name, $label, $attributes = NULL)
	{
		$this->_data['values'][$name] = array(
			'name' => $name,
			'label' => $label,
			'attributes' => $attributes,
		);
	}
	
}
