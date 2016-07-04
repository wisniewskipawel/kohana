<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Bform_Driver_Agreements extends Bform_Driver_Collection_Flat {
	
	public function on_add_driver()
	{
		$replacements = array(
			':link' => HTML::anchor(Pages::uri('rules'), ___('accept_terms.link.title')),
			':rules_url' => URL::site(Pages::uri('rules'), 'http'),
			':privacy_url' => URL::site(Pages::uri('privacy'), 'http'),
		);
		
		$this->add_bool('accept_terms', array(
			'label' => strtr(Site::config('agreements.terms'), $replacements),
			'required' => TRUE, 
		));
		
		$this->add_bool('accept_trading', array(
			'label' => strtr(Site::config('agreements.trading'), $replacements),
			'required' => FALSE,
		));

		$this->add_bool('accept_ads', array(
			'label' => strtr(Site::config('agreements.ads'), $replacements),
			'required' => FALSE,
		));
	}
	
}