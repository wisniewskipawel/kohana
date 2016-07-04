<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Template_Catalog_Company extends Template_Catalog_Company_Base {
	
	public function initialize()
	{
		parent::initialize();
		
		Media::css('bootstrap.min.css', 'catalog_company_rwd/css/', array('minify' => FALSE, 'combine' => FALSE));
		Media::css('bootstrap-theme.css', 'catalog_company_rwd/css/', array('minify' => FALSE, 'combine' => FALSE));
		Media::css('main.css', 'catalog_company_rwd/css/', array('minify' => FALSE, 'combine' => FALSE));
		
		Media::js('jquery-1.11.0.min.js', 'catalog_company_rwd/js/vendor/');
		Media::js('bootstrap.js', 'catalog_company_rwd/js/vendor/');
		Media::js('modernizr-2.6.2-respond-1.1.0.min.js', 'catalog_company_rwd/js/vendor/');
	}

	public function get_main_menu()
	{
		$main_menu = array(
			'about' => array(
				'url' => catalog::url($this->current_company, 'show'),
				'title' => ___('catalog.subdomain.about.title'),
				'active' => $this->get_current_tab() == 'about',
			),
			'gallery' => array(
				'url' => catalog::url($this->current_company, 'gallery'),
				'title' => ___('catalog.subdomain.gallery.title'),
				'active' => $this->get_current_tab() == 'gallery',
			),
		);

		if(Kohana::$config->load('modules.site_catalog.settings.reviews.enabled'))
		{
			$main_menu['reviews'] = array(
				'url' => catalog::url($this->current_company, 'reviews'),
				'title' => ___('catalog.subdomain.reviews.title'),
				'active' => $this->get_current_tab() == 'reviews',
			);
		}

		foreach($this->get_pages() as $tab)
		{
			if(!empty($tab['count_entries']))
			{
				$main_menu[$tab['page']] = array(
					'url' => catalog::url($this->current_company, $tab['page']),
					'title' => $tab['title'],
					'active' => $this->get_current_tab() == $tab['page'],
				);
			}
		}

		$main_menu['contact'] = array(
			'url' => catalog::url($this->current_company, 'contact'),
			'title' => ___('catalog.subdomain.contact.title'),
			'active' => $this->get_current_tab() == 'contact',
		);

		return $main_menu;
	}
	
}