<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Catalog_Company_Promotion_Type {

	/**
	 * @var array
	 */
	protected $data = array();

	/**
	 * Catalog_Company_Promotion_Type constructor.
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * @return int
	 */
	public function get_id()
	{
		return (int)$this->data['id'];
	}

	/**
	 * @return string
	 */
	public function get_slug()
	{
		return $this->data['slug'];
	}

	/**
	 * @return string
	 */
	public function get_title()
	{
		return ___('catalog.companies.promotion.types.'.$this->get_id());
	}

	/**
	 * @return array
	 */
	public function get_limits()
	{
		return $this->data['limits'];
	}

	/**
	 * @return bool
	 */
	public function is_enabled()
	{
		return (bool)$this->data['enabled'];
	}

	/**
	 * @param int $type
	 * @return bool
	 */
	public function is_type($type)
	{
		return $this->get_id() == $type;
	}

	/**
	 * @param string $limit_type
	 * @return mixed
	 */
	public function get_limit($limit_type)
	{
		return Arr::path($this->data, array('limits', $limit_type));
	}

}
