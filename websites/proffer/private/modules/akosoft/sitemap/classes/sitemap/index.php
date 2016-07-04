<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Sitemap_Index {
	
	/**
	 * @var DOMDocument
	 */
	protected $_xml;

	/**
	 * @var DOMElement
	 */
	protected $_root;

	public function __construct()
	{
		$this->_xml = new DOMDocument('1.0', Kohana::$charset);
		$this->_xml->formatOutput = TRUE;

		$this->_root = $this->_xml->createElement('sitemapindex');
		$this->_root->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

		$this->_xml->appendChild($this->_root);
	}
	
	public function add_sitemap($url, $lastmod = NULL)
	{
		$sitemap_node = $this->_xml->createElement('sitemap');
		$sitemap_node->appendChild(new DOMElement('loc', $url));
		
		if($lastmod)
		{
			$sitemap_node->appendChild(new DOMElement('lastmod', Sitemap::date_format($lastmod)));
		}
		
		$this->_root->appendChild($sitemap_node);
	}
	
	public function render()
	{
		return $this->_xml->saveXML();
	}
	
}
