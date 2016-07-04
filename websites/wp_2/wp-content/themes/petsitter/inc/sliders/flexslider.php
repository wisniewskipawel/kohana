<?php global $petsitter_data;

$slider_controls = "";
if ($petsitter_data['petsitter__slider-controls'] == 1) {
	$slider_controls = 'true';
} else {
	$slider_controls = 'false';
}

$slider_autoplay = "";
if ($petsitter_data['petsitter__slider-autoplay'] == 1) {
	$slider_autoplay = 'true';
} else {
	$slider_autoplay = 'false';
}

$slider_loop = "";
if ($petsitter_data['petsitter__slider-loop'] == 1) {
	$slider_loop = 'true';
} else {
	$slider_loop = 'false';
}

$slider_parallax       = "";
$slider_parallax_ratio = $petsitter_data['petsitter__slider-parallax-ratio'];
if ($petsitter_data['petsitter__slider-parallax-bg'] == 1) {
	$slider_parallax = 'data-stellar-background-ratio="'.$slider_parallax_ratio.'"';
}
?>

<!-- Slider -->
<section class="slider-holder" <?php echo $slider_parallax; ?>>
	<div class="container">
		<div class="flexslider carousel">

			<?php // Slides
			if ( post_type_exists('slides') ) { ?>
				<ul class="slides">
				<?php
					query_posts("post_type=slides&posts_per_page=-1&post_status=publish&order=ASC&orderby=menu_order");
					while ( have_posts() ) : the_post();

					$sl_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail-xlg'); ?>

					<li>
						<!-- Featured Thumbnail -->
						<?php if(has_post_thumbnail($post->ID)) { ?>
							<img src="<?php echo $sl_image_url[0] ?>" alt="" />
						<?php } ?>
						<!-- /Featured Thumbnail -->
					</li>

					<?php endwhile;
					wp_reset_query(); ?>
				</ul>
			<?php } else { ?>
				<div class="row">
					<div class="col-md-8">
						<div class="alert alert-warning alert__slider"><?php _e( '<strong>DF Custom Post Types for Petsitter</strong> plugin is missed. Please install it to see Slider posts.', 'petsitter' ); ?></div>
					</div>
				</div>
			<?php } ?>


			<?php // Title and Buttons ?>
			<?php if( $petsitter_data['petsitter__slider-box-type'] == 1 ) { ?>
			<div class="slider-box">

				<?php if ( $petsitter_data['petsitter__slider-heading'] != "" ) : ?>
				<h2><?php echo $petsitter_data['petsitter__slider-heading']; ?></h2>
				<?php endif; ?>

				<?php if ( $petsitter_data['petsitter__slider-text'] != "" ) : ?>
				<div class="slider-box-text">
					<?php echo $petsitter_data['petsitter__slider-text']; ?>
				</div>
				<?php endif; ?>

				<div class="text-center">
					<?php if ( $petsitter_data['petsitter__slider-btn1-url'] != "" && $petsitter_data['petsitter__slider-btn1-txt'] != "") : ?>
					<a href="<?php echo $petsitter_data['petsitter__slider-btn1-url']; ?>" class="btn btn-primary btn-block"><?php echo $petsitter_data['petsitter__slider-btn1-txt']; ?></a>
					<?php endif; ?>

					<?php if ( $petsitter_data['petsitter__slider-conjunction'] != "" ) : ?>
					<div class="slider-box-conj"><?php echo $petsitter_data['petsitter__slider-conjunction']; ?></div>
					<?php endif; ?>

					<?php if ( $petsitter_data['petsitter__slider-btn2-url'] != "" && $petsitter_data['petsitter__slider-btn2-txt'] != "") : ?>
					<a href="<?php echo $petsitter_data['petsitter__slider-btn2-url']; ?>" class="btn btn-secondary btn-block"><?php echo $petsitter_data['petsitter__slider-btn2-txt']; ?></a>
					<?php endif; ?>
				</div>

			</div>

			<?php } elseif ( $petsitter_data['petsitter__slider-box-type'] == 2 ) { ?>

			<?php // Jobs Search Form ?>
			<div class="slider-box">
				<?php if (class_exists( 'WP_Job_Manager' )) { ?>

					<?php if ( $petsitter_data['petsitter__slider-search-heading'] != "" ) : ?>
					<h2><?php echo $petsitter_data['petsitter__slider-search-heading']; ?></h2>
					<?php endif; ?>
					<form method="GET" action="<?php echo $petsitter_data['petsitter__slider-search-slug']; ?>">
						<?php
						$layout = $petsitter_data['petsitter__slider-jobs-layout']['enabled'];

						if ($layout): foreach ($layout as $key=>$value) {

							switch($key) {

								case 'field__keywords': get_template_part( 'inc/sliders/fields-jobs/field__keywords' );
								break;

								case 'field__location': get_template_part( 'inc/sliders/fields-jobs/field__location' );
								break;

								case 'field__category': get_template_part( 'inc/sliders/fields-jobs/field__category' );
								break;

								case 'field__submit': get_template_part( 'inc/sliders/fields-jobs/field__submit' );
								break;

					    }

						}
						endif; ?>
					</form>

				<?php } else { ?>
					<div class="alert alert-warning">
						<?php _e('<strong>WP Job Manager</strong> plugin is missed. Please install and activate it.', 'petsitter'); ?>
					</div>
				<?php } ?>
			</div>


			<?php // Resume Search Form ?>
			<?php } elseif ( $petsitter_data['petsitter__slider-box-type'] == 3 ) { ?>

			<div class="slider-box">

				<?php if (class_exists( 'WP_Resume_Manager' )) { ?>
					<?php if ( $petsitter_data['petsitter__slider-search-heading-resumes'] != "" ) : ?>
					<h2><?php echo $petsitter_data['petsitter__slider-search-heading-resumes']; ?></h2>
					<?php endif; ?>
					<form method="GET" action="<?php echo $petsitter_data['petsitter__slider-search-slug-resumes']; ?>">

						<?php
						$layout_resumes = $petsitter_data['petsitter__slider-resumes-layout']['enabled'];

						if ($layout_resumes): foreach ($layout_resumes as $key=>$value) {

							switch($key) {

								case 'field__keywords': get_template_part( 'inc/sliders/fields-resumes/field__keywords' );
								break;

								case 'field__location': get_template_part( 'inc/sliders/fields-resumes/field__location' );
								break;

								case 'field__category': get_template_part( 'inc/sliders/fields-resumes/field__category' );
								break;

								case 'field__submit': get_template_part( 'inc/sliders/fields-resumes/field__submit' );
								break;
					    }

						}
						endif; ?>

					</form>

				<?php } else { ?>
					<div class="alert alert-warning">
						<?php _e('<strong>Resume Manager</strong> add-on is missed. Please install and activate it.', 'petsitter'); ?>
					</div>
				<?php } ?>
			</div>

			<?php } ?>

		</div>
	</div>
</section>


<?php // Slider Init ?>
<script>
	jQuery(function(){
		jQuery('body').addClass('loading');
	});

	jQuery(window).load(function() {
		jQuery('.flexslider').flexslider({
			animation: "fade",
			slideshowSpeed: <?php echo $petsitter_data['petsitter__slider-speed']; ?>000,
			controlNav: <?php echo $slider_controls; ?>,
			slideshow: <?php echo $slider_autoplay; ?>,
			animationLoop: <?php echo $slider_loop; ?>,
			directionNav: false,
			prevText: "",
			nextText: "",
			start: function(slider){
				jQuery('body').removeClass('loading');
			}
		});
	});
</script>
<!-- Slider / End -->
