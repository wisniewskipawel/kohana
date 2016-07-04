<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Transaction extends ORM {
    
	protected $_table_name = 'transactions';
	protected $_primary_key = 'transaction_id';
	protected $_primary_val = 'transaction_hash';

	public function add_transaction($hash)
	{
		$this->transaction_hash = $hash;
		$this->transaction_date_added = date('Y-m-d H:i:s');
		$this->save();

		if (mt_rand(0, 100) == 50)
		{
			$old = self::factory($this->_object_name)
					->select(array(DB::expr('
						IF (
							(
								transaction_date_added + INTERVAL 10 MINUTE < NOW()
							)
						, 1, 0)
					'), 'expired'))
					->having('expired', '=', 1)
					->find_all();
			foreach ($old as $t)
			{
				$t->delete();
			}
		}
	}
	
}
