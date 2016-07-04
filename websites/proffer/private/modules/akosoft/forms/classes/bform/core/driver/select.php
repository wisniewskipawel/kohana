<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Select extends Bform_Driver_Common {
	
	public $_custom_data = array(
		'_html'             => array(
			'options'   => array(),
			'size' => NULL,
		),
	);

	public function __construct(Bform_Core_Form $form, $name, $options, $info = array())
	{
		if (is_string($options))
		{
			$options = unserialize($options);
		}
		$info['options'] = $options;
		
		parent::__construct($form, $name, $info);
	}

}
