<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Captcha extends Bform_Driver_Input {

	public $_custom_data = array(
		'_data' => array(
		),
		'_html'		=> array(
			'size'		=> 10,
		),
	);

	public function __construct(Bform_Form $form, $name, array $info = array())
	{
		//init captcha instance
		Captcha::instance('form');
		
		if(!isset($info['label']))
		{
			$info['label'] = 'bform.driver.captcha.label';
		}
		
		parent::__construct($form, $name, $info);

		$this->add_validator('Bform_Validator_Captcha');
	}
	
}
