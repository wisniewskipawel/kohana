<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2015, AkoSoft
*/

class Bform_File_Detached extends Bform_File_Base {
	
	protected $file = NULL;
	protected $name = NULL;
	
	public function __construct($file, $name = NULL)
	{
		if(!is_file($file))
		{
			throw new RuntimeException(sprintf('File at path: "%s", not exist!', Debug::path($file)));
		}
		
		$this->file = $file;
		$this->name = $name;
	}
	
	public function getFullPath()
	{
		return $this->file;
	}
	
	public function getSafePath()
	{
		return str_replace(rtrim(DOCROOT, '/'), '', realpath($this->file));
	}
	
    public function getClientFilename()
    {
		if($this->name)
		{
			return $this->name;
		}
		
        return basename($this->file);
    }
	
	public function getSafeFilename()
	{
		return $this->_sanitize_filename($this->getClientFilename());
	}
	
	public function getSize()
	{
		return filesize($this->getFullPath());
	}
	
	public function getType()
	{
		return 'detached';
	}
	
	public function asFileInfoArray()
	{
		$array = parent::asFileInfoArray();
		$array['path'] = $this->getSafePath();
		$array['file_name'] = $this->getClientFilename();
		
		return $array;
	}
	
	protected function _sanitize_filename($filename)
	{
		$filename_parts = pathinfo($filename);
		
		$sanitized = URL::title($filename_parts['filename']);
		
		if(!empty($filename_parts['extension']))
		{
			$sanitized .= '.'.URL::title($filename_parts['extension']);
		}
		
		return $sanitized;
	}
	
}