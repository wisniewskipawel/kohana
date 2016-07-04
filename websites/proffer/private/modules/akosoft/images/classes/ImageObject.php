<?php
/**
 * @author	AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class ImageObject {
	
	protected $_image_data = NULL;
	
	protected $_image_manager = NULL;
	
	public function __construct($image_data, ImageManager $image_manager)
	{
		$this->_image_manager = $image_manager;
		$this->_image_data = $image_data;
	}
	
	public function get_id()
	{
		return Arr::get($this->_image_data, 'image_id');
	}

	public function exists($type)
	{
		return $this->_image_manager->exists($type, $this->_image_data);
	}

	public function get_uri($type)
	{
		return $this->_image_manager->get_uri($type, $this->_image_data);
	}

	public function get_url($type, $protocol = NULL)
	{
		return $this->_image_manager->get_url($type, $this->_image_data, $protocol);
	}

	public function get_disk_path($type)
	{
		return $this->_image_manager->get_disk_path($type, $this->_image_data);
	}
	
	public function delete()
	{
		return $this->_image_manager->delete($this->get_id());
	}

}
