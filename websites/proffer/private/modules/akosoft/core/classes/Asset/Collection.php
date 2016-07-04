<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Asset_Collection {
	
	protected $_name = NULL;
	
	protected $_files = array();
	
	protected $_destination_file_path = NULL;
	
	public function __construct($name)
	{
		$this->_name = $name;
	}
	
	public function add(Asset $file)
	{
		$this->_files[] = $file;
	}
	
	public function get_contents()
	{
		$contents = '';
		
		foreach($this->_files as $asset)
		{
			$contents .= $asset->get_contents();
		}
		
		return $contents;
	}
	
	protected function _get_hash()
	{
		$files = '';
		foreach($this->_files as $asset)
		{
			$files .= '|'.$asset->get_file_path();
		}
		
		return md5($files);
	}
	
	protected function need_recompile()
	{
		$dest_file_path = DOCROOT.'media/compiled/'.$this->get_destination_file_path();
		
		if(!file_exists($dest_file_path))
			return TRUE;
		
		$dest_modified_time = filemtime($dest_file_path);
		
		foreach($this->_files as $asset)
		{
			if($dest_modified_time < $asset->get_last_modified())
				return TRUE;
		}
		
		return FALSE;
	}
	
	public function compile()
	{
		$dest_file_path = DOCROOT.'media/compiled/'.$this->get_destination_file_path();
		
		if($this->need_recompile())
		{
			if(!is_dir(dirname($dest_file_path)))
				mkdir(dirname($dest_file_path), 0777, TRUE);
			
			$contents = $this->_recompile();
			file_put_contents($dest_file_path, $contents);
			
			return TRUE;
		}
		
		return FALSE;
	}
	
	protected function _recompile()
	{
		$contents = $this->get_contents();
		
		if(Kohana::$config->load('media.css.minify'))
		{
			require_once Kohana::find_file('vendor', 'minify/Minify/Loader');
			Minify_Loader::register();
			
			$contents = Minify_CSS::minify($contents);
		}
		
		return $contents;
	}
	
	public function get_destination_file_path()
	{
		if(!$this->_destination_file_path)
		{
			$this->_destination_file_path = $this->_name.'.'.$this->_get_hash().'.css';
		}
		
		return $this->_destination_file_path;
	}
	
	public function get_web_path()
	{
		return Route::get('media/compiled/file')->uri(array(
			'filename' => $this->get_destination_file_path(),
		));
	}
	
}