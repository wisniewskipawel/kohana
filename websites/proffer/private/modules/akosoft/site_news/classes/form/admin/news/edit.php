<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_News_Edit extends Bform_Form {
	
	public function create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'news.forms');
		
		$params['news_date_added'] = Date::my($params['news_date_added']);
		$params['news_visible_from'] = Date::my($params['news_visible_from']);
		
		$this->form_data($params);
		
		$this->add_tab('general', ___('news.forms.contents'));
		
		$this->general->add_input_text('news_title');
		
		$this->general->add_editor('news_content');

		$this->general->add_fieldset('publish', ___('news.forms.publish'));
		
		$this->general->publish->add_bool('news_is_published', array('value' => TRUE));
		
		$this->general->publish->add_datetime('news_date_added', array(
			'label' => 'date_added', 
			'value' => date('Y-m-d H:i'), 
		));
		
		$this->general->publish->add_datetime('news_visible_from', array(
			'value' => date('Y-m-d H:i'), 
		));
			
		$this->add_tab('seo', 'SEO');
		$this->seo->add_input_text('news_meta_title', array('required' => FALSE));
		$this->seo->add_textarea('news_meta_description', array('required' => FALSE));
		$this->seo->add_textarea('news_meta_keywords', array('required' => FALSE));
		$this->seo->add_input_text('news_meta_robots', array('required' => FALSE));
		
		$this->add_input_submit(___('form.save'));
	}
	
}
