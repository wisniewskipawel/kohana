<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Widget_Posts_Category extends Widget_Box {
	
	public function render($view_file = NULL)
	{
		$view = '';
		$root = (new Model_Post_Category())->find_root();
		$categories = $root->find_childrens();
		
		foreach($categories as $category)
		{
			$model = new Model_Post;
			$posts = $model->filter_by_approved()
				->filter_by_category($category)
				->limit(Posts::config('posts_recent_box.limit') ?: 5)
				->get_list();
			
			if(count($posts) > 0)
			{
				$this->set('category', $category)
					->set('posts', $posts);
				
				$view .= (string)parent::render($view_file);
			}
		}
		
		return $view;
	}
	
}
