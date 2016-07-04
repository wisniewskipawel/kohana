<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

Media::css('cssmap-poland.css', 'js/vendor/cssmap/cssmap-poland/', array('minify' => TRUE, 'combine' => FALSE));
Media::js('jquery.cssmap.js', 'js/vendor/cssmap/');
$category_uri = $route->uri();
?>
<div id="widget_regions_map">

	<a href="#" class="show_hide_map_btn"><i class="glyphicon glyphicon-map-marker"></i> <?php echo ___('template.boxes.regions_map.title') ?> <span class="caret"></span></a>

	<div class="map">
		<ul class="poland">
			<li class="pl1"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 2), FALSE), 'Dolnośląskie') ?></li>
			<li class="pl2"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 3), FALSE), 'Kujawsko-pomorskie') ?></li>
			<li class="pl3"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 4), FALSE), 'Lubelskie') ?></li>
			<li class="pl4"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 5), FALSE), 'Lubuskie') ?></li>
			<li class="pl5"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 6), FALSE), 'Łódzkie') ?></li>
			<li class="pl6"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 7), FALSE), 'Małopolskie') ?></li>
			<li class="pl7"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 8), FALSE), 'Mazowieckie') ?></li>
			<li class="pl8"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 9), FALSE), 'Opolskie') ?></li>
			<li class="pl9"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 10), FALSE), 'Podkarpackie') ?></li>
			<li class="pl10"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 11), FALSE), 'Podlaskie') ?></li>
			<li class="pl11"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 1), FALSE), 'Pomorskie') ?></li>
			<li class="pl12"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 12), FALSE), 'Śląskie') ?></li>
			<li class="pl13"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 13), FALSE), 'Świętokrzyskie') ?></li>
			<li class="pl14"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 14), FALSE), 'Warmińsko-mazurskie') ?></li>
			<li class="pl15"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 15), FALSE), 'Wielkopolskie') ?></li>
			<li class="pl16"><?php echo HTML::anchor($category_uri.URL::query(array('province' => 16), FALSE), 'Zachodniopomorskie') ?></li>
		</ul>
	</div>

	<script>
		$(function() {
			$('.map').cssMap({
				'size'      :'240',
				'cities'    : false
			});

			$('#widget_regions_map .show_hide_map_btn').on('click', function(e) {
				e.preventDefault();
				$('#widget_regions_map').toggleClass('opened');
			});
		});
	</script>
</div>
