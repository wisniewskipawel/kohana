<div id="map"></div>

<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>

<script type="text/javascript">
var mapa;

$(function() {
	<?php if($company->company_map_lat <= 0 OR $company->company_map_lng <= 0): ?>
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode({address: '<?php echo $company->get_contact()->address->render('geocoder') ?>'}, get_address);

	function get_address(results, status)
	{
		if(status == google.maps.GeocoderStatus.OK) 
		{
			var point = results[0].geometry.location;

			init_map(point);
		}
	}   
	<?php else: ?>
		init_map(new google.maps.LatLng(<?php echo HTML::chars($company->company_map_lat) ?>, <?php echo HTML::chars($company->company_map_lng) ?>));
	<?php endif; ?>
});

function init_map(center_point) {
	var map_options = {
	  zoom: 14,
	  center: center_point,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	mapa = new google.maps.Map(document.getElementById("map"), map_options);

	var marker_options =
	{
		position: center_point,
		map: mapa,
		title: '<?php echo HTML::chars($company->company_name) ?>'
	}
	var marker = new google.maps.Marker(marker_options);
}
</script>
