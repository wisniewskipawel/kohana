<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Select_Multiple extends Bform_Driver_Select {

	public static function factory(Bform_Form $form, $name, $options, $info = array())
	{
		if(!isset($info['size']))
		{
			$info['size'] = 5;
		}
	
		parent::__construct($form, $name, $options, $info);
	}
	
}
