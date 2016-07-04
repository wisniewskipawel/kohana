<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

trait Trait_ImageModel {

	/**
	 * @var ImageCollection
	 */
	protected $images_collection;

	/**
	 * @return ImageCollection|null
	 */
	protected function load_images()
	{
		if(isset($this->_object) AND array_key_exists('image_ids', $this->_object) && array_key_exists('images', $this->_object))
		{
			if(isset($this->image_ids) AND isset($this->images))
			{
				$image_ids = explode(',', $this->image_ids);
				$images = explode(',', $this->images);

				$images_array = array();

				foreach($image_ids as $i => $id)
				{
					$images_array[$id] = array(
						'image_id' => $id,
						'image' => $images[$i],
					);
				}

				$this->images_collection = new ImageCollection($images_array, $this->get_image_manager());
			}
		}
		else
		{
			$this->images_collection = $this->get_image_manager()->find_images_by_object_id($this->pk());
		}

		return $this->images_collection;
	}

	/**
	 * @return ImageCollection|null
	 */
	public function get_images()
	{
		if($this->images_collection === NULL)
		{
			$this->load_images();
		}

		if(!count($this->images_collection))
			return NULL;

		return $this->images_collection;
	}

	/**
	 * @return ImageObject|null
	 */
	public function get_first_image()
	{
		$images = $this->get_images();
		return $images ? $images->first() : NULL;
	}

	/**
	 * @return ImageManager
	 */
	abstract public function get_image_manager();

	/**
	 * @return int
	 */
	abstract public function pk();

}
