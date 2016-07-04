<?php 
Media::css('jquery.datetimepicker.css', 'js/libs/datetimepicker/');
Media::js('jquery.datetimepicker.js', 'js/libs/datetimepicker/');

$value = ($driver->data('clear_value') === TRUE OR !$driver->get_value()) ? 
	NULL : date($driver->data('format'), strtotime($driver->get_value()));

echo Form::input(
	$driver->html('name'), 
	$value, 
	array(
		'id' => $driver->html('id'), 
		'class' => $driver->html('class'), 
		'size' => $driver->html('size'), 
		'title' => $driver->html('title'),
		'placeholder' => $driver->html('placeholder'), 
	)
);

$datetime_options = array(
	'timepicker' => $driver->data('time'),
	'datepicker' => $driver->data('date'),
	'format' => $driver->data('format'),
	'lang' => I18n::lang(),
	'dayOfWeekStart' => 1,
	'value' => $value,
);

if($driver->data('date'))
{
	$datetime_options['formatDate'] = $driver->data('format_date');
	
	if($driver->data('date_from'))
	{
		$datetime_options['minDate'] = date($driver->data('format'), strtotime($driver->data('date_from')));
	}
	
	if($driver->data('date_to'))
	{
		$datetime_options['maxDate'] = date($driver->data('format'), strtotime($driver->data('date_to')));
	}
}

?>
<script type="text/javascript">
$(function() {
	$('#<?php echo $driver->html('id') ?>').datetimepicker(<?php echo json_encode($datetime_options) ?>);
});
</script>