<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Offer_To_User extends ORM {

	protected $_table_name = 'offers_to_users';
	protected $_primary_key = 'offer_to_user_id';

	protected $_belongs_to = array(
		'offer'	  => array('model' => 'Offer', 'foreign_key' => 'offer_id'),
	);
	
	public function delete_by_offer($offer)
	{
		if(empty($offer))
		{
			return;
		}
		
		DB::delete($this->table_name())
			->where('offer_id', is_array($offer) ? 'IN' : '=', $offer)
			->execute($this->_db);
	}
	
	public static function count_by_user(Model_User $user)
	{
		$self = new self();
		$self->with('offer');
		
		$model = new Model_Offer;
		
		$self->where($model->object_name().'.'.$model->primary_key(), 'IS NOT', NULL);
		$model->query_active($self);
		
		return $self->where($self->object_name().'.user_id', '=', (int)$user->pk())
				->count_all();
	}

}
