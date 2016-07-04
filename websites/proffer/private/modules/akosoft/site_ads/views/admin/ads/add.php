<h2><?php echo ___('ads.admin.add.title') ?></h2>

<script type="text/javascript">
$(document).ready(function() {
	$('#bform-ad-type').on('change', on_ad_type_change);
	
	on_ad_type_change();
	
	function on_ad_type_change() {
		var type = $('#bform-ad-type').val();
		
		if (type == '') {
			$('.ad-banner').hide();
			$('.ad-text').hide();
		} else if (type == <?php echo Model_Ad::TEXT_C ?> || type == <?php echo Model_Ad::TEXT_C1 ?>) {

			$.ajax({
				url: base_url + '/ajax/ads/get_ad_availability',
				data : { type: type },
				success: function(data) {
					if (data.length) {
						$('select#bform-display-length').html(data);
					}
				}
			});

			$('.ad-text').show();
			$('.ad-banner').hide();
			$('.ad-link').find("label").addClass("required");
			$('.ad-text label').addClass('required');
		} else {
			$('.ad-banner').show();
			$('.ad-text').hide();
			$('.ad-link label.required').removeClass("required");
		}
	}

	jQuery('select#ad-user').on('change', on_change_user);
	on_change_user();
	
	function on_change_user() {
		var value = jQuery('select#ad-user').val();
		
		if (value == 'new') {
			jQuery('.ad-user').show();
		} else {
			jQuery('.ad-user').hide();
		}
	}
});
</script>

<div class="box">

	<?php echo $form ?>
	
</div>