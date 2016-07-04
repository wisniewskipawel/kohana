<?php
if($form->has('attributes')):
	$groups = array(
		'text' => array(),
		'select' => array(),
		'checkbox' => array(),
	);

foreach($form->attributes->get_all() as $attribute_field)
{
	if($attribute_field instanceof Bform_Driver_Input_Text)
	{
		$groups['text'][] = $attribute_field;
	}
	elseif($attribute_field instanceof Bform_Driver_Select)
	{
		$groups['select'][] = $attribute_field;
	}
	elseif($attribute_field instanceof Bform_Driver_Bool)
	{
		$groups['checkbox'][] = $attribute_field;
	}
}

foreach($groups as $group_name => $g_attribute_fields):
	foreach(array_chunk($g_attribute_fields, 3) as $attribute_fields):
?>
<div class="row attributes_group_<?php echo $group_name ?>">
	<?php foreach($attribute_fields as $attribute_field): ?>

	<?php echo$attribute_field->render(TRUE) ?>

	<?php endforeach; ?>
</div>
<?php endforeach; endforeach; endif; ?>