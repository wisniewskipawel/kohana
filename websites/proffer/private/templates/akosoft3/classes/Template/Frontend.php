<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Template_Frontend extends View_Template {
	
	public function initialize()
	{
		parent::initialize();
		
		$this->set_default_layout('layouts/content');
		
		Media::css('common.css', NULL, array('minify' => TRUE, 'combine' => TRUE));
		Media::css('bootstrap.min.css', NULL, array('minify' => FALSE, 'combine' => FALSE));
		Media::css('bootstrap-theme.css', NULL, array('minify' => FALSE, 'combine' => FALSE));
		Media::css('main.css', NULL, array('minify' => FALSE, 'combine' => FALSE));
		
		Media::js('jquery-1.11.0.min.js', 'js/vendor/');
		Media::js('bootstrap.js', 'js/vendor/');
		Media::js('modernizr-2.6.2-respond-1.1.0.min.js', 'js/vendor/');
		Media::js('plugins.js');
		Media::js('main.js');
	}
	
	public function render_layout()
	{
		if(!empty($this->action_tab))
		{
			if($this->action_tab == 'site_announcements')
			{
				$this->set_layout('layouts/sidebar_left_rwd', array(
					'sidebar' => View::factory('layouts/announcements/sidebar'),
				));
			}
			
			if(!isset($this->layout) AND $this->action_tab == 'site_offers')
			{
				$this->set_layout('layouts/sidebar_left_rwd', array(
					'sidebar' => View::factory('layouts/offers/sidebar'),
				));
			}
			
			if($this->action_tab == 'site_products')
			{
				$this->set_layout('layouts/sidebar_left_rwd', array(
					'sidebar' => View::factory('layouts/products/sidebar'),
				));
			}
			
			if($this->action_tab == 'site_catalog')
			{
				if($this->current_route_name == 'site_catalog/home')
				{
					$sidebar = View::factory('layouts/catalog/sidebar_home')->render();
				}
				else
				{
					$sidebar = View::factory('layouts/catalog/sidebar')->render();
				}
				
				$this->set_layout('layouts/sidebar_left_rwd', array(
					'sidebar' => $sidebar,
				));
			}
			
			if($this->action_tab == 'site_jobs')
			{
				$this->set_layout('jobs/layouts/default');
			}
			
			if(!isset($this->layout) AND $this->action_tab == 'announcements_moto')
			{
				$this->set_layout('layouts/sidebar_left_rwd', array(
					'sidebar' => View::factory('announcements_moto/layouts/partials/sidebar'),
				));
			}
			
			if($this->action_tab == 'site_dealers')
			{
				$this->set_layout('layouts/content');
			}
		}
		
		return parent::render_layout();
	}
	
	public function render($file = NULL)
	{
		if(!empty($this->action_tab))
		{
			if($this->action_tab == 'site_posts')
			{
				$this->set('module_nav_side', View::factory('template/posts/partials/module_nav')->render());
			}
			
			if($this->action_tab == 'site_notifiers')
			{
				$this->set('module_nav_side', View::factory('template/notifier/partials/module_nav')->render());
			}
			
			if($this->action_tab == 'site_announcements')
			{
				if($this->current_route_name == 'site_announcements/home')
				{
					$this->set('section_pre_main', View::factory('layouts/announcements/partials/section_pre_main')->render());
				}
			}
			
			if($this->action_tab == 'site_catalog')
			{
				if($this->current_route_name == 'site_catalog/home')
				{
					$this->set('section_pre_main', Widget_Box::factory('catalog/companies/carousel')->render());
				}
			}
			
			if($this->action_tab == 'site_offers')
			{
				if($this->current_route_name == 'site_offers/home')
				{
					$this->set('section_pre_main', View::factory('layouts/offers/partials/section_pre_main')->render());
				}
			}
		}
		
		$current_module = Modules::instance()->current_module();
		
		if($current_module)
		{
			if($current_module->get_name() == 'site_notifier')
			{
				$this->set('module_nav_side', View::factory('template/notifier/partials/module_nav'));
			}
		}
		
		return parent::render($file);
	}
	
	protected function _get_config()
	{
		$config = (array)parent::_get_config();
		$config = Arr::merge(
			(array)Kohana::$config->load('template.default'), 
			(array)$config
		);
		
		return $config;
	}
	
}