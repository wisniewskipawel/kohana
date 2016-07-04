<?php get_header(); ?>

<?php global $petsitter_data;

$portfolio_content  = '';
$portfolio_info     = '';
$img_size           = '';

// Grab Gallery IDs
$gallery_ids        = get_post_meta(get_the_ID(), 'petsitter_format_gallery_id', true);
$gallery_ids_array  = array_map( 'trim', explode( ',', $gallery_ids ) );

if($petsitter_data['opt-portfolio-layout'] == 3) {
	$portfolio_content  = 'col-md-12 mgb-30';
	$portfolio_info     = 'col-md-12';
	$img_size           = 'thumbnail-xlg';
} elseif($petsitter_data['opt-portfolio-layout'] == 2) {
	$portfolio_content  = 'col-md-8 col-md-push-4';
	$portfolio_info     = 'col-md-4 col-md-pull-8';
	$img_size           = 'portfolio-single-half';
} else {
	$portfolio_content  = 'col-md-8';
	$portfolio_info     = 'col-md-4';
	$img_size           = 'portfolio-single-half';
}
?>

<section class="page-content">
	<div class="container">

		<!-- Loop -->
		<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="row">
			
			<div class="<?php echo $portfolio_content; ?>">

				<?php if($petsitter_data['opt-portfolio-nav'] == 1) : ?>
				<nav class="project-nav clearfix">
					
					<?php if( get_previous_post() ) : ?>
					<span class="prev pull-left"><?php previous_post_link('&larr; %link') ?></span>
					<?php endif; ?>
					
					<?php if( get_next_post() ) : ?>
					<span class="next pull-right"><?php next_post_link('%link &rarr;') ?></span>
					<?php endif; ?>

				</nav>
				<?php endif; ?>


				<?php if ( $gallery_ids !="" ) { ?>

					<!-- Gallery -->
					<!-- <div class="prev-next-holder pull-right hidden-xs">
						<a class="prev-btn" id="portfolio-carousel-prev"></a>
						<a class="next-btn" id="portfolio-carousel-next"></a>
					</div> -->
					<div class="owl-carousel owl-theme owl-slider thumbnail" id="portfolio-carousel">
						<?php 
						$args = array(
							'post_type'      => 'attachment',
					    'post_mime_type' => 'image',
					    'post_status'    => 'inherit',
					    'posts_per_page' => -1,
							'post__in'       => $gallery_ids_array
						);
						$attachments = get_posts($args); ?>

						<?php if ($attachments) : ?>

						<?php foreach ($attachments as $attachment) : ?>

						<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, $img_size); ?>
						<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
						<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
						
						<div class="item">
							<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" />
						</div>

						<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<!-- /Gallery -->

					<script>
						jQuery(document).ready(function() {
							jQuery("#portfolio-carousel").owlCarousel({
								navigation : false,
					      slideSpeed : 300,
					      paginationSpeed : 400,
					      singleItem:true
							});
						});
					</script>

				<?php } else {

					if( has_post_thumbnail() ) {
						$thumb    = get_post_thumbnail_id();
						$img_url  = wp_get_attachment_url( $thumb,'full'); //get img URL
						$image    = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $img_size);

						echo '<figure class="thumbnail thumbnail__portfolio-single">';
							echo '<img src="'. $image[0] .'" alt="'. get_the_title() .'" />';
						echo '</figure>';
					}

				} ?>

			</div>
			
			<!-- Project Description -->
			<div class="<?php echo $portfolio_info; ?>">
				<?php the_content(); ?>
			</div>
		</div>
		<?php endwhile; endif; ?>
		<!-- Loop / End -->


		<?php if($petsitter_data['opt-portfolio-related'] == 1) : ?>
		<hr class="lg">

		<!-- Related Projects -->
		<h3><?php echo $petsitter_data['opt-portfolio-related-title']; ?></h3>

		<div class="prev-next-holder text-right">
			<a class="prev-btn" id="carousel-prev"><i class="fa fa-angle-left"></i></a>
			<a class="next-btn" id="carousel-next"><i class="fa fa-angle-right"></i></a>
		</div>

		<!-- Gallery -->
		<div class="owl-carousel-wrapper row">
			<div id="owl-carousel" class="owl-carousel">
				<?php
				//Get array of terms
				$terms = get_the_terms( $post->ID , 'portfolio_category');
				//Pluck out the IDs to get an array of IDS
				$term_ids = array_values(wp_list_pluck($terms,'term_id'));

				//Query posts with tax_query. Choose in 'IN' if want to query posts with any of the terms
				//Chose 'AND' if you want to query for posts with all terms
				$second_query = new WP_Query( array(
					'post_type'           => 'portfolio',
					'tax_query'           => array(
						array(
							'taxonomy'  => 'portfolio_category',
							'field'     => 'id',
							'terms'     => $term_ids,
							'operator'  => 'IN' //Or 'AND' or 'NOT IN'
						)),
					'posts_per_page'      => 8,
					'ignore_sticky_posts' => 1,
					'orderby'             => 'rand',
					'post__not_in'        => array($post->ID),
				));

				//Loop through posts and display...
				if($second_query->have_posts()) {
				while ($second_query->have_posts() ) : $second_query->the_post();

				$thumb   = get_post_thumbnail_id();
				$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
				$image   = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'portfolio-n');

				$short_info = get_post_meta(get_the_ID(), 'petsitter_short_info', true);
				?>

				<div class="project-item">
					<div class="project-item-inner">
						<?php if(has_post_thumbnail()): ?>
						<figure class="alignnone project-img">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<img src="<?php echo $image[0] ?>" alt="" />
							</a>
						</figure>
						<?php endif; ?>
						<div class="project-desc">
							<h4 class="title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							</h4>
							<span class="desc">
							<?php if( $short_info != "") { ?>
								<?php echo $short_info; ?>
							<?php } else { ?>
								<?php the_time(get_option('date_format')); ?>
							<?php } ?>
							</span>
						</div>
					</div>
				</div>
				<?php endwhile; wp_reset_query(); } ?>
			</div>
		</div>
		<!-- Related Projects / End -->
		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>