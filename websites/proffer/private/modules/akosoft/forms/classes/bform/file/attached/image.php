<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2015, AkoSoft
*/

class Bform_File_Attached_Image extends Bform_File_Base {
	
	protected $image;
	protected $imageId;
	
	public function __construct($image_id, $image)
	{
		$this->image = $image;
		$this->imageId = $image_id;
	}
	
	public function getImageId()
	{
		return $this->imageId;
	}
	
	public function getImage()
	{
		return $this->image;
	}

	public function getType()
	{
		return 'attached_image';
	}
	
	public function asFileInfoArray()
	{
		$array = parent::asFileInfoArray();
		$array['image_id'] = $this->imageId;
		$array['image'] = $this->image;
		
		return $array;
	}
	
}