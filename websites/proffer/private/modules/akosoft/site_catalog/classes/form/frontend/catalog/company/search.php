<?php defined('SYSPATH') or die('No direct script access.');/*** @author	AkoSoft Team <biuro@akosoft.pl>* @link		http://www.akosoft.pl* @copyright	Copyright (c) 2013, AkoSoft*/class Form_Frontend_Catalog_Company_Search extends Bform_Form {		protected $_method = 'get';		public function  create(array $params = array()) 	{		$this->param('i18n_namespace', 'catalog');				$this->add_input_text('phrase');				$this->add_input_submit(___('form.search'));				$this->template('site');	}	}