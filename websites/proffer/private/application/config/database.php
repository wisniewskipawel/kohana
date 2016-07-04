<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
return array
(
	'default' => array
	(
		'type'	   => 'MySQL',
		'connection' => array(
			'hostname'	=> 'localhost',
			'username'	=> '1245_Proffer',
			'password'	=> 'Proffer13',
			'persistent'	=> FALSE,
			'database'		=> '1245_Proffer',
			'port'		=> NULL,
		),
		'table_prefix' => '',
		'charset'	  => 'utf8',
		'caching'	  => FALSE,
		'profiling'	=> TRUE,
	),
	'backup' => array
	(
		'type'	   => 'MySQLi',
		'connection' => array(
			'hostname'	=> 'localhost',
			'username'	=> '1245_Proffer',
			'password'	=> 'Proffer13',
			'persistent'	=> FALSE,
			'database'		=> '1245_Proffer',
			'port'		=> NULL,
		),
		'table_prefix' => '',
		'charset'	  => 'utf8',
		'caching'	  => FALSE,
		'profiling'	=> TRUE,
	),
);
