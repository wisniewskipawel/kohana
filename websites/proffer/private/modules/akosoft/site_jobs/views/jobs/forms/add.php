<?php echo $form->param('class', 'form_add_job bform')->render_form_open() ?>

	<ul class="errors">
		<?php if ($form->param('errors')): ?>
			<?php foreach ($form->param('errors') as $e): ?>
				<li><strong><?php echo $e['label'] ?><?php echo (strpos($e['driver_name'], ':') !== FALSE ? '' : ':') ?></strong> <?php echo $e['message'] ?></li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>

	<?php echo $form->form_id->render(); ?>

	<fieldset class="border">
		<div class="job-categories">
			<?php echo $form->category_id->render(TRUE); ?>
		</div>
		
		<?php echo $form->title->html('row_class', 'full')->render(TRUE) ?>

		<?php echo $form->content->html('row_class', 'full')->render(TRUE) ?>
	</fieldset>

	<fieldset id="attributes_fields" class="border"<?php if(!$form->has('attributes')) echo 'style="display: none;"' ?>>
		<legend><?php echo ___('jobs.attributes') ?></legend>
		<?php echo $form->render_partial(NULL, 'jobs/forms/partials/attributes'); ?>
	</fieldset>
	
	<fieldset class="price_fieldset border">
		
		<?php echo $form->price->render(TRUE) ?>
		<?php echo $form->date_realization_limit->render(TRUE) ?>
		
	</fieldset>

	<fieldset class="contact_data_fieldset border">
		
		<?php if($field = $form->contact_data->get('person_type')) echo $field->render(TRUE) ?>
		<?php if($field = $form->contact_data->get('company_id')) echo $field->render(TRUE) ?>
		<?php if($field = $form->contact_data->get('person')) echo $field->render(TRUE) ?>
		<?php if($field = $form->contact_data->get('email')) echo $field->render(TRUE) ?>
		<?php if($field = $form->contact_data->get('www')) echo $field->render(TRUE) ?>
		<?php if($field = $form->contact_data->get('telephone')) echo $field->render(TRUE) ?>
		
	</fieldset>

	<fieldset class="localization_fieldset border">
		
		<div class="fields">
			<?php if($field = $form->contact_data->address->get('province')) echo $field->render(TRUE) ?>
			<?php if($field = $form->contact_data->address->get('county')) echo $field->render(TRUE) ?>
			<?php if($field = $form->contact_data->address->get('city')) echo $field->render(TRUE) ?>
			<?php if($field = $form->contact_data->address->get('postal_code')) echo $field->render(TRUE) ?>
			<?php if($field = $form->contact_data->address->get('street')) echo $field->render(TRUE) ?>
		</div>
		
		<?php if($field = $form->contact_data->address->get('map')) echo $field->render(TRUE) ?>
		
	</fieldset>

	<fieldset class="promotions_fieldset border">
		<?php echo $form->promotions->availability_span->render(TRUE) ?>

		<?php if($form->promotions->has('promotion')): ?>
		<div class="promotion_choose">
			<?php 
			$payment_promote = new Payment_Job_Promote(); 
			foreach($form->promotions->promotion->data('values') as $value): 
			?>
			<label class="radio_option promotion_<?php echo $value['name'] ?>">
				<?php
				echo Form::radio(
					$form->promotions->promotion->html('name'), 
					$value['name'], 
					$value['name'] == $form->promotions->promotion->get_value(),
					$value['attributes']
				);
				?>
				<div class="promotion_description">
					<?php echo $value['label'] ?>
				</div>
				<div class="promotion_price">
					<?php echo payment::price_format($payment_promote->get_lowest_price($value['name'])) ?>
				</div>
			</label>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</fieldset>

	<?php echo $form->param('buttons_manager')->layout('bform/site/drivers_layouts/buttons')->render() ?>

<?php echo $form->render_form_close() ?>

<script type="text/javascript">
$(function() {
	jQuery('.job-categories').on('change', 'select', function() {
		var $select = jQuery(this);
		var $container = $select.parents('.job-categories');
		var parent_category_id = $select.val();
		var $form = $container.parents('form');
		var $attributes = $form.find('#attributes_fields').hide();

		if(!parent_category_id) {
			return;
		}

		jQuery.ajax({
			url: base_url + 'ajax/jobs/on_category_change',
			data: {
				category_id: parent_category_id,
				form_id: $form.find('[name=form_id]').val()
			},
			dataType: 'json',
			success: function(data) {
				if (data.categories) {
					$container.html(data.categories);
				}

				if(data.attributes) {
					$attributes.html(data.attributes).show();
				}
			}
		});
	});
	
	$('#bform-person-type').bind('change', person_type_select);
	person_type_select();
});

function person_type_select() {
	var $person_type = $('#bform-person-type');
	
	$('#bform-company-id-row, #bform-person-row').hide();

	if($person_type.val() === 'company') {
		if($('#bform-company-id-row').show().length === 0) {
			$('#bform-person-row').show()
				.find('label').html('<?php echo ___('jobs.form.person.company') ?> <span class="required">*</span>');
		}
		
	} else if($person_type.val() === 'person') {
		$('#bform-company-id-row').hide();
		$('#bform-person-row').show()
				.find('label').html('<?php echo ___('jobs.form.person.person') ?> <span class="required">*</span>');
	}
}
</script>
