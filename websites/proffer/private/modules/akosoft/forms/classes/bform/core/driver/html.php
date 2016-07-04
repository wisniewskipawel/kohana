<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Html extends Bform_Driver_Common {
    
	public $_custom_data = array(
		'_html'     => array(
			'html'      => '',
			'no_decorate'	=> TRUE,
		),
		'_data'     => array(
			'required' => FALSE,
		)
	);

	public function __construct(Bform_Form $form, $html, $info = array())
	{
		$info['html'] = (string) $html;
		
		parent::__construct($form, 'html' . Text::random('alpha') . sha1($html), $info);
	}
	
	public function on_get_values($values, $not_empty = FALSE)
	{
		return $values;
	}
	
}
