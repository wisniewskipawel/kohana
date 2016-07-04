<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

$module = Modules::instance()->register('emails');

Events::add_listener('admin/menu/settings', array('Events_Emails_Admin', 'on_menu_settings'), 500);
