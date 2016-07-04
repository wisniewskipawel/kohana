<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class ImageCollection extends IteratorIterator implements Countable {

	/**
	 * @var array
	 */
	protected $_images = NULL;

	/**
	 * @var ImageManager|null
	 */
	protected $_image_manager = NULL;

	/**
	 * ImageCollection constructor.
	 * @param array $images
	 * @param ImageManager $image_manager
	 */
	public function __construct($images, ImageManager $image_manager)
	{
		$this->_image_manager = $image_manager;
		$this->_images = $images;
		
		parent::__construct(new ArrayIterator($this->_images));
	}

	/**
	 * @return ImageObject
	 */
	public function current()
	{
		return new ImageObject(parent::current(), $this->_image_manager);
	}

	/**
	 * @return ImageObject
	 */
	public function first()
	{
		$this->rewind();
		return $this->current();
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return count($this->_images);
	}

	/**
	 * @param $image_id
	 * @return ImageObject|null
	 */
	public function find_by_id($image_id)
	{
		return isset($this->_images[$image_id]) ? new ImageObject($this->_images[$image_id], $this->_image_manager) : NULL;
	}

}
