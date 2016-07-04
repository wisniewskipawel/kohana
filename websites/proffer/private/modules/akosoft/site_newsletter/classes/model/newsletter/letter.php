<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Newsletter_Letter extends ORM {

	protected $_table_name = 'newsletter_letters';
	protected $_primary_key = 'letter_id';
	protected $_primary_val = 'letter_subject';

	public function add_letter(array $values) 
	{
		$this->values($values)->save();

		$subscribers = ORM::factory('newsletter_subscriber');
		
		if(!empty($values['accepted_ads']))
		{
			$subscribers->filter_by_accept_ads(TRUE);
		}
		$subscribers->filter_by_status(Model_Newsletter_Subscriber::STATUS_ACTIVE);
		$subscribers = $subscribers->find_all();
		
		foreach ($subscribers as $s)
		{
			$queue = ORM::factory('Newsletter_Queue');
			$queue->email_id = $s->email_id;
			$queue->letter_id = $this->letter_id;
			$queue->queue_send_at = $values['queue_send_at'];
			$queue->save();
		}
	}

}
