<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2015, AkoSoft
*/

abstract class Bform_File_Base {
	
	protected $error = NULL;
	protected $downloadUrl = NULL;
	protected $removeUrl = NULL;
	
	public static function createFromFileInfoArray($fileInfo)
	{
		if(!isset($fileInfo['type']))
		{
			throw new InvalidArgumentException('No required fileInfo parameter: type!');
		}
		
		$file = NULL;
		
		if($fileInfo['type'] == 'attached')
		{
			$file = new Bform_File_Attached();
		}
		elseif($fileInfo['type'] == 'attached_image')
		{
			if(!isset($fileInfo['image_id']) OR !isset($fileInfo['image']))
			{
				throw new InvalidArgumentException('No required fileInfo parameters: image_id and image!');
			}
			
			$file = new Bform_File_Attached_Image($fileInfo['image_id'], $fileInfo['image']);
		}
		elseif($fileInfo['type'] == 'detached')
		{
			if(!isset($fileInfo['path']))
			{
				throw new InvalidArgumentException('No required fileInfo parameter: path!');
			}
			
			$file = new Bform_File_Detached(
				$fileInfo['path'],
				isset($fileInfo['file_name']) ? $fileInfo['file_name'] : NULL
			);
		}
		else
		{
			throw new UnexpectedValueException(sprintf('Not supported file type: %s', $fileInfo['type']));
		}
		
		if(isset($fileInfo['download_url']))
		{
			$file->setDownloadUrl($fileInfo['download_url']);
		}
		
		if(isset($fileInfo['remove_url']))
		{
			$file->setRemoveUrl($fileInfo['remove_url']);
		}
		
		return $file;
	}
	
    public function getClientFilename()
    {
		throw new Exception('Method getClientFilename is not implemented!');
    }
	
	public function getExtension()
	{
		return strtolower(pathinfo($this->getClientFilename(), PATHINFO_EXTENSION));
	}
	
	public function setError($error)
	{
		$this->error = $error;
		return $this;
	}
	
	public function getError()
	{
		return $this->error;
	}
	
	public function setDownloadUrl($url)
	{
		$this->downloadUrl = $url;
		return $this;
	}
	
	public function getDownloadUrl()
	{
		return $this->downloadUrl;
	}
	
	public function setRemoveUrl($url)
	{
		$this->removeUrl = $url;
		return $this;
	}
	
	public function getRemoveUrl()
	{
		return $this->removeUrl;
	}
	
	public function getType()
	{
		return '';
	}
	
	public function asFileInfoArray()
	{
		$array = array(
			'type' => $this->getType(),
			'download_url' => $this->getDownloadUrl(),
			'remove_url' => $this->getRemoveUrl(),
			'error' => $this->getError(),
		);
		
		return $array;
	}
	
}