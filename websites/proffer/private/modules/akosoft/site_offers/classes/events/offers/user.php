<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Offers_User extends Events {
	
	public function on_with_statistics()
	{
		$model = $this->param('model');
		
		$model->select(array(DB::expr('
				(
					SELECT
						COUNT(*)
					FROM
						offers
					WHERE
						offers.user_id = user.user_id
				)
			'), 'offers_count'));
	}
	
}