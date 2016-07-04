<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

Route::set('ckeditor/upload', 'ajax/ckeditor/upload')
	->defaults(array(
		'controller' => 'CKEditor',
		'action' => 'upload',
	));
