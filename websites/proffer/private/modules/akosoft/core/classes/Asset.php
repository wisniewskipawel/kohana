<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Asset {
	
	protected $_file_path = NULL;
	
	protected $_disk_path = NULL;
	
	protected $_last_modified = NULL;
	
	protected $_options = NULL;
	
	public function __construct($file_path, $options = NULL)
	{
		$this->_file_path = ltrim($file_path, '/');
		$this->_disk_path = Media::find_file(dirname($this->_file_path), basename($this->_file_path));
		$this->_options = $options;
		
		if(!$this->_disk_path)
		{
			throw new Kohana_Exception('Cannot find asset: :file_path', array(
				':file_path' => $this->_file_path,
			));
		}
	}
	
	public function get_contents()
	{
		return file_get_contents($this->_disk_path);
	}
	
	public function get_last_modified()
	{
		if ($this->_last_modified === NULL)
		{
			$this->_last_modified = filemtime($this->_disk_path);
		}

		return $this->_last_modified;
	}
	
	public function need_recompile($dest_file_path)
	{
		return !file_exists($dest_file_path) OR filemtime($dest_file_path) < $this->get_last_modified();
	}
	
	public function compile()
	{
		if($this->is_user_modified())
			return FALSE;
		
		$dest_file_path = DOCROOT.'media/compiled/'.$this->_file_path;
		
		if($this->need_recompile($dest_file_path))
		{
			if(!is_dir(dirname($dest_file_path)))
				mkdir(dirname($dest_file_path), 0777, TRUE);
			
			$contents = $this->_recompile($dest_file_path);
			file_put_contents($dest_file_path, $contents);
			
			return TRUE;
		}
		
		return FALSE;
	}
	
	protected function _recompile($dest_file_path)
	{
		return $this->get_contents();
	}
	
	public function get_file_path()
	{
		return $this->_file_path;
	}
	
	public function get_web_path()
	{
		return Route::get(($this->is_user_modified() OR Kohana::$config->load('media.compile_disable') ) ? 'media/file' : 'media/compiled/file')->uri(array(
			'filename' => $this->_file_path,
			'subdomain' => TRUE,
		));
	}
	
	public function is_user_modified()
	{
		return strpos($this->_disk_path, DOCROOT.'media/') !== FALSE;
	}
	
}