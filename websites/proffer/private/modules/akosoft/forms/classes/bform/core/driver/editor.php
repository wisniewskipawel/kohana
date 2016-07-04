<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Editor extends Bform_Driver_Common {
	
	const TYPE_FULL = 'full';
	const TYPE_SIMPLE = 'simple';
	const TYPE_ADMIN_FULL = 'full_admin';
	const TYPE_ADMIN_SIMPLE = 'simple_admin';
	
	public $_custom_data = array(
		'_html' => array(
			'rows' => 10,
			'cols' => 50,
		),
		'_data' => array(
			'editor_type' => self::TYPE_FULL,
			'placeholders' => NULL,
		),
	);
	
	public function __construct(Bform_Form $form, $name, array $info = array())
	{
		Media::js('ckeditor.js', 'js/libs/ckeditor/');
		
		parent::__construct($form, $name, $info);
		
		$this->html('class', 'editor ckeditor');
	}
	
}
