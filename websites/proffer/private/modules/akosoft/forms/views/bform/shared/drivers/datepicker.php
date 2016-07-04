<?php 
Media::css('jquery-ui.min.css', 'js/libs/jquery-ui/');
Media::js('jquery-ui.min.js', 'js/libs/jquery-ui/');

echo Form::input(
	$driver->html('name'), 
	($driver->data('clear_value') === TRUE) ? '' : $driver->get_value(), 
	array(
		'id' => $driver->html('id'), 
		'class' => $driver->html('class'), 
		'size' => $driver->html('size'), 
		'title' => $driver->html('title'),
		'placeholder' => $driver->html('placeholder'), 
	)
);
?>
<script type="text/javascript">
$(function() {
	$('#<?php echo $driver->html('id') ?>').datepicker(<?php echo json_encode(array(
		'dateFormat' => "yy-mm-dd",
		'minDate' => $driver->data('date_from'),
		'maxDate' => $driver->data('date_to'),
	)) ?>);
});
</script>