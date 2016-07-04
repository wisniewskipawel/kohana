<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Admin_Jobs_Comment_Edit extends BForm_Form {
	
	public function create(array $params = array())
	{
		$comment = $params['comment'];
		
		$this->form_data($comment->as_array());
		
		$this->add_textarea('body');
		
		$this->add_input_submit(___('form.save'));
	}
	
}