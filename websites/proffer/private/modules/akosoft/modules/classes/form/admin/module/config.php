<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Module_Config extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->form_data($params);
		
		$module_name = $params['module_name'];
		
		if (isset($params['meta']))
		{
			$seo_tab = $this->add_tab('seo', ___('modules.forms.config.seo_tab'));
			
			foreach ($params['meta'] as $tag_name => $value)
			{
				if ($tag_name == 'keywords')
				{
					$seo_tab->add_textarea($module_name . '[meta][' . $tag_name . ']', array(
						'label' => 'modules.forms.config.meta_keywords', 
						'required' => FALSE, 
						'value' => $params['meta'][$tag_name],
					));
				} 
				elseif ($tag_name == 'description')
				{
					$seo_tab->add_textarea($module_name . '[meta][' . $tag_name . ']', array(
						'label' => 'modules.forms.config.meta_description', 
						'required' => FALSE, 
						'value' => $params['meta'][$tag_name],
					));
				} 
				elseif ($tag_name == 'robots')
				{
					$seo_tab->add_input_text($module_name . '[meta][' . $tag_name . ']', array(
						'label' => 'modules.forms.config.meta_robots', 
						'required' => FALSE, 
						'value' => $params['meta'][$tag_name],
					));
				} 
				elseif ($tag_name == 'title')
				{
					$seo_tab->add_input_text($module_name . '[meta][' . $tag_name . ']', array(
						'label' => 'modules.forms.config.meta_title', 
						'required' => FALSE, 
						'value' => $params['meta'][$tag_name],
					));
				}
			}
		}
		
		$this->add_input_submit(___('form.save'));
	}
	
}
