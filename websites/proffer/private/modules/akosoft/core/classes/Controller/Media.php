<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Media extends Controller {
	
	public function after()
	{
		if(Kohana::$config->load('media.no_expires_headers'))
		{
			//prevent caching in dev
			$headers = (array)$this->response->headers();

			$this->response->headers(array_merge($headers, array(
				'expires' => 'Tue, 03 Jul 2001 06:00:00 GMT',
				'last-modified' => gmdate("D, d M Y H:i:s") . ' GMT',
				'cache-control' => 'no-store, no-cache, must-revalidate, max-age=0',
				'cache-control' => 'post-check=0, pre-check=0',
				'pragma' => 'no-cache',
			)));
		}
		
		parent::after();
	}

	public function action_file()
	{
		$file = $this->request->param('filename');
		
		try
		{
			$asset = new Asset($file);
		}
		catch(Exception $ex)
		{
			Kohana_Exception::log($ex, Log::ERROR);
			
			throw new HTTP_Exception_404;
		}
		
		HTTP::check_cache($this->request, $this->response, sha1($this->request->uri()).$asset->get_last_modified());

		$this->response->body($asset->get_contents());

		$ext = pathinfo($file, PATHINFO_EXTENSION);
		$this->response->headers('content-type',  File::mime_by_ext($ext));
		$this->response->headers('last-modified', date('r', $asset->get_last_modified()));
	}
	
}
