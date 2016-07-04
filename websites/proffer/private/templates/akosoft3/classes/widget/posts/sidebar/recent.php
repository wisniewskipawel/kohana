<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2015, AkoSoft
*/

class Widget_Posts_Sidebar_Recent extends Widget_Box {
	
	public function render($view_file = NULL)
	{
		$posts = Model_Post::factory()
			->with_images(FALSE, 'post_lead')
			->limit(5)
			->get_list();
		
		$this->set('posts', $posts);
		
		return parent::render($view_file);
	}
	
}
