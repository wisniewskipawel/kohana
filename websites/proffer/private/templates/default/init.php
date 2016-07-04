<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

Events::add_listener('settings/form_appearance_create', array('Events_Template_Default_Settings', 'on_form_appearance_create'));
Events::add_listener('settings/form_appearance_save', array('Events_Template_Default_Settings', 'on_form_appearance_save'));
