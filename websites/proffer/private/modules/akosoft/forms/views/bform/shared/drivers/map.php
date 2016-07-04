<?php 
$values = $driver->get_value(); 

$gmaps_config = Kohana::$config->load('regions.gmaps');
?>
<div id="<?php echo $driver->data('name') ?>" class="field_map"></div>
<?php echo Form::hidden($driver->data('field_lat'), $values['lat']) ?>
<?php echo Form::hidden($driver->data('field_lng'), $values['lng']) ?>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">

function updateMarkerPosition(latLng) {
	$('input[name="<?php echo $driver->data('field_lat') ?>"]').val(latLng.lat());
	$('input[name="<?php echo $driver->data('field_lng') ?>"]').val(latLng.lng());
}

function initialize() {
	var latLng = new google.maps.LatLng(<?php echo (($values['lat'] AND $values['lng']) ? $values['lat'].','.$values['lng'] : $gmaps_config['start_point']['lat'].','.$gmaps_config['start_point']['lng']) ?>);
	var map = new google.maps.Map(document.getElementById('<?php echo $driver->data('name') ?>'), {
	  zoom: 5,
	  center: latLng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	var marker = new google.maps.Marker({
	  position: latLng,
	  title: '<?php echo ___('bform.driver.map.marker.title') ?>',
	  map: map,
	  draggable: true
	});

	var marker_position_changed = false;
	updateMarkerPosition(latLng);

	google.maps.event.addListener(marker, 'dragend', function() {
	  marker_position_changed = true;
	  updateMarkerPosition(marker.getPosition());
	});
	
	<?php if($driver->data('geocode')): ?>
		$('.geocode-province, .geocode-county, .geocode-postalcode, .geocode-street').bind('change', changed_address);
		<?php if(!$values['lat'] OR !$values['lng']): ?>
		changed_address();
		<?php endif; ?>
		
		function changed_address() {
			if(marker_position_changed)
				return;
			
			setTimeout(function() {
				var address = '';

				var province = $('.geocode-province').val();
				if(province) {
					address += ', '+$('.geocode-province :selected').text();
				}

				var county = $('.geocode-county').val();
				if(county) {
					address += ', '+$('.geocode-county :selected').text();
				}

				var postal_code = $('.geocode-postalcode').val();
				if(postal_code.length > 5) {
					address += ', '+postal_code;
				}
				
				if(!province && $('.geocode-city').val()) {
					address += ', '+$('.geocode-city').val();
				}
				
				var street = $('.geocode-street').val();
				if(street.length) {
					address += ', '+street;
				}

				if(address.length) {
					geocode(map, '<?php echo Arr::path($gmaps_config, 'geocoder.prepend_region') ?> '+ address, marker);
				}
			}, 1000);
		}
	<?php endif; ?>
}

function geocode(map, address, marker) {
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode({address: address}, get_address);

	function get_address(results, status)
	{
		if(status == google.maps.GeocoderStatus.OK) 
		{
			var point = results[0].geometry.location;
			
			updateMarkerPosition(point);
			
			marker.setPosition(point);
			map.setCenter(point);
			map.fitBounds(results[0].geometry.bounds);
		}
	}  
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>