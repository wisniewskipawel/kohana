<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_News extends ORM {

	protected $_table_name = 'news';
	protected $_primary_key = 'news_id';
	protected $_primary_val = 'news_title';

	protected $_has_many = array(
		'images' => array('model' => 'Image', 'foreign_key' => 'object_id'
	));

	public function get_all_admin($offset, $limit)
	{
		$result = $this
			->select(array(DB::expr("
				(
					SELECT
						image_id
					FROM
						images
					WHERE
						images.object_id = news.news_id AND images.object_type = 'news'
					ORDER BY
						images.image_id ASC
					LIMIT
						1
				 )
		"), 'news_image_id'))
			->select(array(DB::expr("
				(
					SELECT
						image
					FROM
						images
					WHERE
						images.object_id = news.news_id AND images.object_type = 'news'
					ORDER BY
						images.image_id ASC
					LIMIT
						1
				)
		"), 'news_image'))
			->order_by('news_id', 'DESC')
			->limit($limit)
			->offset($offset);
		
		if (Modules::enabled('site_comments'))
		{
			$result
					->select(array(DB::expr('
						(
							SELECT
								COUNT(*)
							FROM
								comments AS comment
							WHERE
								comment.comment_object_type = \'news\' AND comment.comment_object_id = news.news_id
						)
			'), 'comments_count'));
		}

		return $result->find_all();
	}

	public function add_news($values, $file = array())
	{	
		$values['news_date_added'] = strtotime($values['news_date_added']);
		$values['news_visible_from'] = strtotime($values['news_visible_from']);
		
		$this->values($values)->save();
		
		if ( upload::not_empty($file))
		{
			$this->add_image($file);
		}
	}

	public function edit_news($values, $file = array())
	{	
		$values['news_date_added'] = strtotime($values['news_date_added']);
		$values['news_visible_from'] = strtotime($values['news_visible_from']);
		
		$this->values($values)->save();

		if ( ! empty($values['delete_image'])) 
		{
			$this->delete_image();
		}

		if (upload::not_empty($file)) {
			$this->add_image($file, TRUE);
		}
	}
	
	public function delete_image()
	{
		img::delete('news', $this->news_id, $this->news_image);
		$this->news_image = 0;
		$this->save();
		return $this;
	}

	public function add_image($file)
	{
		$values['news_image'] = time();
		$uploaded_file_path = upload::save($file, NULL, NULL);
		img::process('news', 'news', $this->news_id, $values['news_image'], $uploaded_file_path);
		$this->news_image = $values['news_image'];
		$this->save();
	}

	public function get_comments()
	{
		return ORM::factory('Comment')
				->where('comment_object_type', '=', 'news')
				->where('comment_object_id', '=', $this->news_id)
				->order_by('comment_date_added', 'ASC')
				->find_all();
	}
	
	public function add_comment(array $values)
	{
		$values['comment_object_type'] = 'news';
		$values['comment_object_id'] = $this->news_id;
		ORM::factory('Comment')
				->add_comment($values);
	}

	public function when_published() 
	{
		return Date::fuzzy_span($this->news_visible_from);
	}
	
	public function delete()
	{
		$this->delete_image();
		return parent::delete();
	}
	
}
