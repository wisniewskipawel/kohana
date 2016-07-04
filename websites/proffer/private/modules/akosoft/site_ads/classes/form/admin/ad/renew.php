<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Ad_Renew extends Bform_Form {

	public function create(array $params = array()) 
	{
		$date = strtotime($params['ad_availability']) + (60 * 60 * 24 * 31);

		$this->add_datetime('ad_availability', array('label' => 'ads.forms.ad_renew.ad_availability', 'value' => date('Y-m-d', $date)));
		
		$this->add_input_submit(___('ads.forms.ad_renew.submit'));
	}

}
