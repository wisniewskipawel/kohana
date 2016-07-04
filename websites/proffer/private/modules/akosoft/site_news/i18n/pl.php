<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
return array(
	'news' => array(
		'title' => 'News & Stories',
		
		'forms' => array(
			'news_title' => 'Tytuł',
			'news_content' => 'Treść',
			'contents' => 'Treści',
			'publish' => 'Publikowanie',
			'news_is_published' => 'Opublikowany?', 
			'news_visible_from' => 'Data od której aktualność jest widoczna:', 
			'news_meta_title' => 'META title', 
			'news_meta_description' => 'META description', 
			'news_meta_keywords' => 'META keywords', 
			'news_meta_robots' => 'META robots', 
		),
		
		'is_visible' => array(
			'yes' => 'tak',
			'no' => 'NIE',
			'date' => 'Zostanie opublikowany za :date',
		),
		
		'boxes' => array(
			'main_bottom' => array(
				'title' => 'News & Stories',
				'browse_archive' => 'More Stories',
			),
		),
		
		'admin' => array(
			
			'browse' => 'Przeglądaj aktualności',
			
			'settings' => array(
				'title' => 'Ustawienia',
				'success' => 'Zmiany zostały zapisane!',
			),
			
			'add' => array(
				'title' => 'Dodawanie aktualności',
				'btn' => 'Dodaj  aktualność',
				'success' => 'Zmiany zostały zapisane!',
			),
			
			'delete' => array(
				'success' => array(
					'one' => 'Aktualność została usunięta!',
					'many' => 'Aktualności zostały usunięte!',
				),
			),
			
			'edit' => array(
				'title' => 'Edycja aktualności',
				'success' => 'Aktualność została zmieniona!',
			),
		),
		
		'permissions' => array(
			'admin' => array(
				'index' => 'Zezwól na przeglądanie aktualności',
				'add' => 'Zezwól na dodawanie aktualności',
				'edit' => 'Zezwól na edycję aktualności',
				'delete' => 'Zezwól na usuwanie aktualności',
			),
		),
	),
	
	'site_news/frontend/news/show' => 'news/pokaz/<id>/<title>',
	'site_news/frontend/news/index' => 'news',
);