<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Widget_Ads_Text extends Widget_Box {
	
	public function render($view_file = 'component/ads/sidebar_left')
	{
		$ads = Model_Ad::factory()->get_by_type_many(Model_Ad::TEXT_C, 3);
		$this->set('ads', $ads);
		
		return parent::render($view_file);
	}
	
}