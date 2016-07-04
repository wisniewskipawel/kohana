<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Catalog_Company_Promotion_Types {

	/**
	 * @var Catalog_Company_Promotion_Type[]
	 */
	protected $types = array();

	/**
	 * Catalog_Company_Promotion_Types constructor.
	 */
	public function __construct()
	{
		$types = catalog::config('promotion_types');

		foreach($types as $type)
		{
			if(isset($type['id']) AND isset($type['slug']))
			{
				$this->types[] = new Catalog_Company_Promotion_Type($type);
			}
		}
	}

	/**
	 * @param $id
	 * @return Catalog_Company_Promotion_Type|null
	 */
	public function get_by_id($id)
	{
		foreach($this->types as $type)
		{
			if($type->get_id() == $id)
			{
				return $type;
			}
		}

		return NULL;
	}

	/**
	 * @param $slug
	 * @return Catalog_Company_Promotion_Type|null
	 */
	public function get_by_slug($slug)
	{
		foreach($this->types as $type)
		{
			if($type->get_slug() == $slug)
			{
				return $type;
			}
		}

		return NULL;
	}

	/**
	 * @return Catalog_Company_Promotion_Type[]
	 */
	public function get_available()
	{
		return $this->types;
	}

	/**
	 * @return Catalog_Company_Promotion_Type[]
	 */
	public function get_enabled()
	{
		$types_enabled = array();

		foreach($this->types as $type)
		{
			if($type->is_enabled())
			{
				$types_enabled[] = $type;
			}
		}

		return $types_enabled;
	}

	/**
	 * @return Catalog_Company_Promotion_Type[]
	 */
	public function get_promotions_enabled()
	{
		$types = array();

		foreach($this->get_enabled() as $type)
		{
			if(!$type->is_type(Model_Catalog_Company::PROMOTION_TYPE_BASIC))
			{
				$types[] = $type;
			}
		}

		return $types;
	}

	/**
	 * @param Catalog_Company_Promotion_Type[] $types
	 * @return array
	 */
	public static function for_select($types)
	{
		$select = array();

		foreach($types as $type)
		{
			$select[$type->get_id()] = $type->get_title();
		}

		return $select;
	}

}