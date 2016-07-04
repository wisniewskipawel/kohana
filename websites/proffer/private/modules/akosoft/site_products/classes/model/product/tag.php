<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Product_Tag extends ORM {
	
	protected $_table_name = 'product_tags';
	protected $_primary_key = 'tag_id';
	
	public function save_tags(Model_Product $product, $tags, $delimeter = ',')
	{
		$this->delete_by_product($product);
		
		$tags = explode($delimeter, $tags);
		
		$valid_tags = array();
			
		foreach($tags as $tag)
		{
			$tag = UTF8::trim($tag);
			
			if(!$tag)
				continue;
			
			$valid_tags[URL::title($tag, '-', TRUE)] = $tag;
		}
		
		if(empty($valid_tags))
			return NULL;
		
		$product_tags = DB::select('tag_id', 'raw_tag')
			->from($this->table_name())
			->where('raw_tag', 'IN', array_keys($valid_tags))
			->as_assoc()
			->execute($this->_db)
			->as_array('tag_id', 'raw_tag');
		
		$tag_insert = DB::insert($this->table_name(), array('tag', 'raw_tag'));
		$counter = 0;
		foreach($valid_tags as $raw_tag => $tag)
		{
			if(in_array($raw_tag, $product_tags))
				continue;
			
			$tag_insert->values(array($tag, $raw_tag));
			$counter++;
		}
		
		$product_tags = array_keys($product_tags);
		
		if($counter)
		{
			list($insert_id, $num_rows) = $tag_insert->execute($this->_db);
			
			$last_row = $insert_id+$num_rows;
			for($insert_id; $insert_id < $last_row; $insert_id++)
			{
				$product_tags[] = $insert_id;
			}
		}
		
		$insert_query = DB::insert('product_to_tag', array('product_id', 'tag_id'));
		$counter=0;
		foreach($product_tags as $tag)
		{
			$insert_query->values(array((int)$product->pk(), (int)$tag));
			$counter++;
		}
		
		$counter AND $insert_query->execute($this->_db);
	}
	
	public function find_tags()
	{
		return $this->find_all();
	}
	
	public function find_by_raw_tag($raw_tag)
	{
		$this->where('raw_tag', '=', $raw_tag);
		
		return $this->find();
	}
	
	public function filter_by_product(Model_Product $product)
	{
		$this->where('product_id', '=', (int)$product->pk());
		
		return $this->join('product_to_tag')
			->on('product_to_tag.tag_id', '=', $this->object_name().'.tag_id');
	}
	
	public function get_tags_cloud($limit = 20)
	{
		$this->order_by('counter', 'DESC');
		
		$limit AND $this->limit($limit);
		
		return $this->find_tags();
	}
	
	public function as_string($delimeter = ', ')
	{
		$tags = $this->find_tags()
			->as_array(NULL, 'tag');
		
		return $tags ? implode($delimeter, $tags) : NULL;
	}
	
	public function delete_by_product($product)
	{
		if(empty($product))
		{
			return;
		}
		
		DB::delete('product_to_tag')
			->where('product_id', is_array($product) ? 'IN' : '=', $product)
			->execute($this->_db);
	}
	
}
