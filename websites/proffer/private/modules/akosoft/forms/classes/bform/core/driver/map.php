<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Bform_Core_Driver_Map extends Bform_Driver_Common {
	
	public $_custom_data = array(
		'_data' => array(
			'field_lat' => 'lat',
			'field_lng' => 'lng',
			'start_point' => array(
				'lat' => NULL,
				'lng' => NULL,
			),
			'geocode' => FALSE,
		),
	);
	
	public static function factory($form, $name, $options = array())
	{
		$self = new self($form, $name, $options);
		
		return $self;
	}
	
	public function get_value()
	{
		$form = $this->data('form');
		$start_point = $this->data('start_point');
		
		$values = $form->method() == 'post' ? Request::current()->post() : Request::current()->query();
		
		return array(
			'lat' => Arr::path($values, str_replace(']', '', str_replace('[', '.', $this->data('field_lat'))), $start_point['lat']), 
			'lng' => Arr::path($values, str_replace(']', '', str_replace('[', '.', $this->data('field_lng'))), $start_point['lng']),
		);
	}
	
	public function _render_driver()
	{
		return View::factory('bform/shared/drivers/map')
			->set('driver', $this);
	}
	
}
