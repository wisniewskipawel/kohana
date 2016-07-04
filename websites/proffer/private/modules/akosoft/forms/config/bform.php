<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'css' => array(
		'errors' => array(
			// klasa listy z bledami na gorze formularza
			'ul_class' => 'errors',
			// klasa dodawana do drivera i labela z bledem jesli jest blad walidacji tego drivera
			'driver_class' => 'error',
			// klasa dodawana do labela pod driverem jesli ma blad
			'label_class' => 'error',
		),
		'tabs' => array(
			// klasa diva w ktorym jest lista z tabami (jquery ui tabs)
			'class' => 'tabs',
		),
		'drivers' => array(
			// klasa dodawana do drivera i labela jesli driver jest polem wymaganym do wypelnienia
			'required_class' => 'required',
			// klasa dodawana do labela przy driverze
			'label_class' => 'label',
			// klasa dodawana do spana przy html_before drivera
			'html_before_class' => 'html-before',
			// klasa dodawana do spana przy html_after drivera
			'html_after_class' => 'html-after',
		),
	),
	'drivers' => array(

		'bform_driver_file_uploader' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/file/uploader',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/file/uploader'
				)
			)
		),

		'bform_driver_captcha' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/captcha',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/captcha'
				)
			)
		),

		'bform_driver_editor' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/editor',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/editor',
				)
			)
		),

		'bform_driver_rating' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/rating',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/rating'
				)
			)
		),

		'bform_driver_html' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/html',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/html'
				)
			)
		),

		'bform_driver_input_hidden' => array(
			'observers' => array(
				//'test'
			),
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/input/hidden',
					'layout' => 'bform/shared/drivers_layouts/blank'
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/input/hidden',
					'layout' => 'bform/shared/drivers_layouts/blank'
				),
			)
		),
		
		'bform_driver_input_checkbox' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/input/checkbox',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/input/checkbox',
				),            )
		),
		
		'bform_driver_input_radio' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/input/radio',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/input/radio',
				),            
			),
		),
		
		'bform_driver_input_file' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/input/file',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/input/file',
				),            )
		),
		'bform_driver_input_password' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/input/password',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/input/password',
				),
			)
		),
		'bform_driver_input_file' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/input/file',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/input/file',
				),
			)
		),
		'bform_driver_input_text' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/input/text',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/input/text',
				),
			)
		),
		'bform_driver_input_email' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/input/text',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/input/text',
				),
			)
		),
		'bform_driver_input_nip' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/input/nip',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/input/nip',
				),
			)
		),
		'bform_driver_group' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/group',
					'layout' => 'bform/main/drivers_layouts/group'
				),
				'site' => array(
					'driver' => 'bform/site/drivers/group',
					'layout' => 'bform/site/drivers_layouts/group'
				),
			)
		),
		'bform_driver_group_checkbox' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/group/checkbox',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/group/checkbox',
				),
			)
		),
		'bform_driver_button' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/button',
					'layout' => 'bform/main/drivers_layouts/buttons'
				),
				'site' => array(
					'driver' => 'bform/site/drivers/button',
					'layout' => 'bform/site/drivers_layouts/buttons'
				),
			)
		),
		'bform_driver_textarea' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/textarea',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/textarea',
				),
			)
		),
		'bform_driver_select' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/select',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/select',
				),
			)
		),
		'bform_driver_select_multiple' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/select/multiple',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/select/multiple',
				),
			)
		),
		'bform_driver_bool' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/bool',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/bool',
				),
			)
		),
		'bform_driver_hours' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/hours',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/hours',
				),
			)
		),
		'bform_driver_group_radio' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/shared/drivers/group/radio',
				),
				'site' => array(
					'driver' => 'bform/shared/drivers/group/radio',
				),
			)
		),
		'bform_core_driver_file_uploader' => array(
			'views' => array(
				'main' => array(
					'driver' => 'bform/drivers/file/uploader',
				),
				'site' => array(
					'driver' => 'bform/drivers/file/uploader',
				),
			)
		),
	),
	'views' => array(
		'defaults' => array(
			'drivers_layouts' => array(
				'site'  => 'bform/shared/drivers_layouts/default',
				'main' => 'bform/shared/drivers_layouts/default',
			),
			'form_layouts' => array(
				'site'  => 'bform/site/forms/default',
				'main' => 'bform/main/forms/default'
			),
			'css' => 'bform/shared/css'
		),
		'templates' => array(
				'main', 'site'
		),
	),
);
