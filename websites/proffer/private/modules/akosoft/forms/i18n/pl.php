<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'bform' => array(
		'driver' => array(
			'captcha' => array(
				'label' => 'Security Check',
				'riddle' => array(
					'text' => 'Answer to this question:',
				),
				'image' => array(
					'text' => 'Type the code shown',
				),
			),
			'orm_categories' => array(
				'subcategory' => array(
					'label' => 'Subcategory',
				),
			),
			'map' => array(
				'marker' => array(
					'title' => 'Drag the marker to your current location',
				),
			),
			
			'hours' => array(
				'select' => array(
					'choose_hour' => '--- choose an hour ---',
					'choose_min' => '--- choose a minute ---',
				),
			),
			
			'textarea' => array(
				'chars_counter' => array(
					'info' => 'Characters remaining',
				),
			),
			
			'file_uploader' => array(
				'choose_files' => 'Select files',
				'uploaded_files' => 'Uploaded files',
				'max_upload_size' => 'Maximum upload file size is :size',
			),
			
			'file_uploaderjs' => array(
				'upload_limit' => array(
					'one' => 'You can upload 1 file',
					'few' => 'You can upload up to :limit files',
					'other' => 'You can upload up to :limit files',
				),
				'limits' => array(
					'one' => 'You can upload 1 file. The maximum upload file size is :size',
					'few' => 'You can upload up to :limit files. The maximum upload file size is :size',
					'other' => 'You can upload up to :limit files. The maximum upload file size is :size',
				),
				'choose_files' => 'Select files...',
			),
			'password' => array(
				'strength' => array(
					'label' => 'Strength',
					'strength0' => 'Very weak',
					'strength1' => 'Weak',
					'strength2' => 'Medium',
					'strength3' => 'Strong',
					'strength4' => 'Very strong',
				),
			),
		),
		
		'validator' => array(
			'error' => 'Please correct the errors!',
			'file_filesize' => 'This file is too big! The maximum upload file size is :filesize!',
			'file_image' => 'Uploaded file is not an image!',
			'max_image_side_length' => 'This image is too big! The image should measure no more than :max_size px on the longest side.',
			'captcha' => 'Wrong captcha!',
			'email' => 'Please enter a valid email addres!',
			'float' => 'The value is not a floating point number!',
			'html' => 'HTML code is not allowed!',
			'integer' => 'Field does not contain an integer number!',
			'length' => array(
				'min' => array(
					'one' => 'Field can contain a minimum of :min character!',
					'few' => 'Field can contain a minimum of :min characters!',
					'other' => 'Field can contain a minimum of :min characters!',
				),
				'max' => array(
					'one' => 'Field can contain a maximum of :max character!',
					'few' => 'Field can contain a maximum of :max characters!',
					'other' => 'Field can contain a maximum of :max characters!',
				),
			),
			'numeric' => 'Field does not contain a number!',
			'range' => array(
				'min' => 'Field can contain a minimum of :min!',
				'max' => 'Field can contain a maximum of :max!',
			),
			'required' => 'This field is required!',
			'select' => 'Invalid value!',
			'url' => 'Please enter a valid url address!',
			'youtube' => 'Video ID not found!',
			'orm' => array(
				'unique' => 'The value of this field is not unique!',
				'categories' => array(
					'allow_only_parent' => 'Choose a category!',
				),
			),
			'date' => array(
				'invalid' => 'The date you entered is invalid!',
				'from' => 'The date you entered is no later than :from.',
				'to' => 'The date you entered is no earlier than :to.',
			),
		),
	),
);