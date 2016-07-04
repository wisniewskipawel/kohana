<h2><?php echo ___('jobs.admin.fields.add.title') ?></h2>

<div class="box">
	<?php echo $form ?>
</div>
<script type="text/javascript">
$(function() {
	$('#bform-type').bind('change', function() {
		var $this = $(this);
		
		$.ajax({
			url: base_url+'/ajax/jobs/field_type_change',
			data: { type: $this.val() },
			success: function(data) {
				$this.parents('form').find('.collection_options').replaceWith(data);
			}
		});
	});
});
</script>