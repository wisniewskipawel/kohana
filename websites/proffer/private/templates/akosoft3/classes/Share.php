<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2015, AkoSoft
*/

class Share {
	
	protected $view;
	
	protected $view_file = 'share';
	
	public function __construct($url, $title, $description = '')
	{
		$this->view = new View();
		$this->view->set('url', $url);
		$this->view->set('title', $title);
		$this->view->set('description', $description);
	}
	
	public function add_image($url)
	{
		$this->view->set('image_url', $url);
		
		return $this;
	}
	
	public function add_send_friend_form($url, $form, $title)
	{
		$this->view->set('send_friend_url', $url);
		$this->view->set('send_friend_form', $form);
		$this->view->set('send_friend_title', $title);
		
		return $this;
	}
	
	public function render($view_file = NULL)
	{
		return (string)$this->view->render($view_file ? $view_file : $this->view_file);
	}
	
	public function __toString()
	{
		return $this->render();
	}
	
}