<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Sitemap extends Controller {
	
	public function action_index()
	{
		$sitemaps = Events::fire('sitemap/index', NULL, TRUE);
		
		if(empty($sitemaps))
			throw new HTTP_Exception_404;
		
		$sitemap_index = new Sitemap_Index();
		
		foreach($sitemaps as $sitemap_uris)
		{
			foreach($sitemap_uris as $sitemap_info)
			{
				$sitemap_index->add_sitemap(URL::site($sitemap_info['uri'], 'http'), $sitemap_info['lastmod']);
			}
		}
		
		$this->response->body($sitemap_index->render());
		$this->response->headers('content-type', 'application/xml');
	}
	
	public function action_generate()
	{
		$sitemap = Events::fire_once($this->request->param('module'), 'sitemap/generate', array(
			'offset' => $this->request->param('offset'),
		));
		
		if(empty($sitemap))
			throw new HTTP_Exception_404;
		
		$this->response->body($sitemap);
		$this->response->headers('content-type', 'application/xml');
	}
	
}
