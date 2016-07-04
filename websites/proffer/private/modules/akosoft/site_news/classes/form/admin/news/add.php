<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_News_Add extends Bform_Form {
	
	public function create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'news.forms');
		
		$content_tab = $this->add_tab('news-content', ___('news.forms.contents'));
		
		$content_tab->add_input_text('news_title');
		
		$content_tab->add_editor('news_content');

		$publish_fieldset = $content_tab->add_fieldset('publish', ___('news.forms.publish'));
		
		$publish_fieldset->add_bool('news_is_published', array('value' => TRUE));
		
		$publish_fieldset->add_datetime('news_date_added', array(
			'label' => 'date_added', 
			'value' => date('Y-m-d H:i'), 
		));
		
		$publish_fieldset->add_datetime('news_visible_from', array(
			'value' => date('Y-m-d H:i'), 
		));
			
		$seo_tab = $this->add_tab('news-seo', 'SEO');
		$seo_tab->add_input_text('news_meta_title', array('required' => FALSE));
		$seo_tab->add_textarea('news_meta_description', array('required' => FALSE));
		$seo_tab->add_textarea('news_meta_keywords', array('required' => FALSE));
		$seo_tab->add_input_text('news_meta_robots', array('required' => FALSE));
		
		$this->add_input_submit(___('form.save'));
	}
	
}
