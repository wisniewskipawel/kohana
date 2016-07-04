<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Newsletter_Queue extends ORM {

	protected $_table_name = 'newsletter_queue';
	protected $_primary_key = 'queue_id';
	protected $_primary_val = 'email_id';

	protected $_belongs_to = array(
		'letter'        => array('model' => 'Newsletter_Letter', 'foreign_key' => 'letter_id'),
		'subscriber'    => array('model' => 'Newsletter_Subscriber', 'foreign_key' => 'email_id')
	);

	public function to_send($limit)
	{
		$this->where('queue_send_at', '<', DB::expr('NOW()'));
		$this->with('letter')->with('subscriber');
		$this->order_by('queue_id', 'ASC');
		$this->limit($limit);
		return $this->find_all();
	}

	public function get_list() 
	{
		$this->with('letter');
		$this->select(array(DB::expr('
			(
				SELECT
					COUNT(*)
				FROM
					newsletter_queue AS q
				WHERE
					newsletter_queue.letter_id = q.letter_id
			)
		'), 'count'));
		$this->group_by('letter_id');
		$this->order_by('queue_id', "DESC");
		return $this->find_all();
	}

}
