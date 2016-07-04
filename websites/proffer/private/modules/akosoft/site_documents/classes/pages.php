<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Pages {
	
	public static function uri($document)
	{
		$document = self::get($document);
		
		if($document->loaded())
		{
			return Route::get('site_documents/frontend/documents/show')
				->uri(array('url' => $document->document_url));
		}
	}
	
	public static function get($alias)
	{
		return ORM::factory('Document')
			->where('document_alias', '=', $alias)
			->find();
	}
	
}
