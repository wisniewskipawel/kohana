<?php
$attributes = array();
$attributes['id'] = $driver->html('id');
$attributes['class'] = $driver->html('class');

if ($driver->data('type') == Bform::BUTTON_TYPE_CANCEL) 
{
	$attributes['onclick'] = 'history.go(-1); return false;';
}

if ($driver->data('type') == Bform::BUTTON_TYPE_SUBMIT OR $driver->data('type') == Bform::BUTTON_TYPE_SUBMIT_AND_ADD) 
{
	echo Form::submit($driver->html('name'), $driver->data('value'), $attributes);
} 
elseif ($driver->data('type') == Bform::BUTTON_TYPE_CANCEL)
{
	echo Form::button($driver->html('name'), $driver->data('value'), $attributes);
}
