<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Product_To_User extends ORM {

	protected $_table_name = 'products_to_users';
	protected $_primary_key = 'product_to_user_id';

	protected $_belongs_to = array(
		'product'	  => array('model' => 'Product', 'foreign_key' => 'product_id')
	);
	
	public function save_user_product(Model_Product $product, Model_User $user)
	{
		$this->filter_by_product($product)
			->filter_by_user($user);
		
		if($this->count_all())
			return FALSE;
		
		$this->product_id = $product->pk();
		$this->user_id = $user->pk();
		
		$this->save();
		
		return $this->saved();
	}
	
	public function filter_by_user(Model_User $user)
	{
		return $this->where($this->object_name().'.user_id', '=', $user->pk());
	}
	
	public function filter_by_product(Model_Product $product)
	{
		return $this->where($this->object_name().'.product_id', '=', $product->pk());
	}
	
	public function delete_by_product($product)
	{
		if(empty($product))
		{
			return;
		}
		
		DB::delete($this->table_name())
			->where('product_id', is_array($product) ? 'IN' : '=', $product)
			->execute($this->_db);
	}
	
	public static function count_by_user(Model_User $user)
	{
		$self = new self();
		$self->with('product');
		
		$model = new Model_Product;
		
		$self->where($model->object_name().'.'.$model->primary_key(), 'IS NOT', NULL);
		$model->query_active($self);
		
		return $self->where($self->object_name().'.user_id', '=', (int)$user->pk())
				->count_all();
	}

}

