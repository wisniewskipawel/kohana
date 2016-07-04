<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Model_Job_Comment extends ORM implements IEmailMessageReceiver {
	
	public $subcomments = array();
	
	protected $_table_name = 'job_comments';
	
	protected $_belongs_to = array(
		'job' => array('model' => 'Job'),
		'user' => array('model' => 'User', 'foreign_key' => 'user_id'),
		'parent_comment' => array('model' => 'Job_Comment', 'foreign_key' => 'parent_comment_id'),
	);
	
	protected $_created_column = array(
		'format' => 'Y-m-d H:i:s',
		'column' => 'date_added',
	);
	
	protected $_updated_column = array(
		'format' => 'Y-m-d H:i:s',
		'column' => 'date_updated',
	);
	
	protected $_left_column = 'lft';
	protected $_right_column = 'rgt';
	
	public function add_comment(Model_Job $job, $values, Model_Job_Comment $parent_comment = NULL)
	{
		$this->job_id = $job->pk();
		
		$this->_db->begin();
		
		if($parent_comment)
		{
			$this->parent_comment_id = $parent_comment->pk();
			$this->create_space($job, $parent_comment->{$this->_right_column});
			
			$this->{$this->_left_column} = $parent_comment->{$this->_right_column};
			$this->{$this->_right_column} = $parent_comment->{$this->_right_column} + 1;
			
			$this->level = $parent_comment->level + 1;
		}
		else
		{
			$offset_rgt = DB::select($this->_right_column)
				->from($this->table_name())
				->where('job_id', '=', $job->pk())
				->order_by($this->_right_column, 'DESC')
				->limit(1)
				->execute($this->_db)
				->get($this->_right_column, 0);
			
			$this->{$this->_left_column} = $offset_rgt + 1;
			$this->{$this->_right_column} = $offset_rgt + 2;
			$this->level = 1;
		}
		
		$this->values($values, array('body', 'user_id'));
		$this->ip_address = Request::$client_ip;
		
		try
		{
			$this->save();
		}
		catch (Exception $e)
		{
			$this->_db->rollback();
			
			throw $e;
		}
		
		$this->_db->commit();
		
		return $this->saved();
	}
	
	public function create_space(Model_Job $job, $start, $size = 2)
	{
		DB::update($this->_table_name)
			->set(array($this->_right_column => DB::expr($this->_right_column.' + '.$size)))
			->where($this->_right_column,'>=', $start)
			->where('job_id', '=', $job->pk())
			->execute($this->_db);
		
		DB::update($this->_table_name)
			->set(array($this->_left_column => DB::expr($this->_left_column.' + '.$size)))
			->where($this->_left_column,'>=', $start)
			->where('job_id', '=', $job->pk())
			->execute($this->_db);
	}
	
	protected function delete_space(Model_Job $job, $start, $size = 2)
	{
		DB::update($this->_table_name)
				->set(array($this->_left_column => DB::expr($this->_left_column.' - '.$size)))
				->where($this->_left_column, '>=', $start)
				->where('job_id', '=', $job->pk())
				->execute($this->_db);

		DB::update($this->_table_name)
				->set(array($this->_right_column => DB::expr($this->_right_column.' - '.$size)))
				->where($this->_right_column,'>=', $start)
				->where('job_id', '=', $job->pk())
				->execute($this->_db);
	}
	
	public function edit_comment($values)
	{
		$this->values($values, array('body'));
		$this->save();
		
		return $this->saved();
	}
	
	public function filter_by_job(Model_Job $job)
	{
		return $this->where('job_id', '=', (int)$job->pk());
	}

	public function count_by_job(Model_Job $job)
	{
		$this->filter_by_job($job);
		
		return $this->count_all();
	}
	
	public function find_by_job(Model_Job $job)
	{
		$this->filter_by_job($job);
		
		$order_dir = 'desc';
		$this->order_by('date_added', $order_dir);
		
		$comments = $this->find_all();
		
		if(count($comments))
		{
			$comments_tree = array();

			for($i=0; $i < count($comments); $i++)
			{
				$comment = $comments[$i];
				if(!$comment->has_parent())
				{
					if($comment->has_subcomments())
					{
						$comment->_add_subcomment($comments, $order_dir);
					}
					$comments_tree[] = $comment;
				}
			}

			return $comments_tree;
		}
		
		return NULL;
	}
	
	public function _add_subcomment($comments, $order_dir)
	{
		for($i=0; $i < count($comments); $i++)
		{
			$subcomment = $comments[$i];
			
			if($subcomment && $subcomment->has_parent() && $subcomment->parent_comment_id == $this->pk())
			{
				if($subcomment->has_subcomments())
				{
					$subcomment->_add_subcomment($comments, $order_dir);
				}
				
				if($order_dir == 'asc')
				{
					$this->subcomments[] = $subcomment;
				}
				else
				{
					array_unshift($this->subcomments, $subcomment);
				}
			}
		}
	}
	
	public function has_parent()
	{
		return !empty($this->parent_comment_id) AND $this->parent_comment->loaded();
	}
	
	public function has_subcomments()
	{
		return ($this->{$this->_left_column} +1) < $this->{$this->_right_column};
	}
	
	public function has_user()
	{
		return $this->user_id AND $this->user->loaded();
	}
	
	public function get_user()
	{
		return $this->has_user() ? $this->user : NULL;
	}
	
	public function delete_by_job($jobs)
	{
		if(empty($jobs))
		{
			return;
		}
		
		$comments = DB::select($this->primary_key())
			->from($this->table_name())
			->where('job_id', 'IN', (array)$jobs)
			->group_by($this->primary_key())
			->execute($this->_db)
			->as_array(NULL, $this->primary_key());
			
		$this->delete_comments($comments);
	}
	
	public function delete_comments($comments)
	{
		if(empty($comments))
		{
			return;
		}

		DB::delete($this->table_name())
			->where($this->primary_key(), 'IN', (array)$comments)
			->execute($this->_db);
	}
	
	public function delete()
	{
		$this->delete_comments($this->pk());
		
		$this->clear();
		
		return $this;
	}

	public function get_email_address()
	{
		$user = $this->get_user();
		return $user ? $user->get_email_address() : NULL;
	}

	public function send_email_message($subject, $message = NULL, $params = NULL)
	{
		if($subject instanceof Model_Email)
		{
			return $subject->send($this->get_email_address(), $params);
		}

		return Email::send($this->get_email_address(), $subject, $message, $params);
	}
	
}