<?php
/**
 * Single view Company information box
 *
 * Hooked into single_job_listing_start priority 30
 *
 * @since  1.14.0
 */
global $post;
global $petsitter_data;

if ( ! get_the_company_name() ) {
	return;
}

//Placeholder Img URL
$job_placeholder    = $petsitter_data['petsitter__employer-placeholder']['url'];
?>

<?php // Moved here @since 1.3 ?>
<?php do_action( 'single_job_listing_meta_after' ); ?>

<div class="row job-profile-info" itemscope itemtype="http://data-vocabulary.org/Organization">
	<div class="col-md-5">
		<figure class="alignnone job-cover-img">
			<?php the_company_logo('portfolio-n', $job_placeholder); ?>
		</figure>
		<div class="gallery-imgs">
			<?php display_job_gallery_data('small'); ?>
		</div>
	</div>
	<div class="col-md-7">
		<?php the_company_name( '<h2 class="name" itemprop="name">', '</h2>' ); ?>
		<?php the_title( '<h4>', '</h4>' ); ?>
		<?php the_company_tagline( '<p class="tagline">', '</p>' ); ?>
			
		<!-- Meta -->
		<?php do_action( 'single_job_listing_meta_before' ); ?>

		<ul class="meta">
			<?php do_action( 'single_job_listing_meta_start' ); ?>

			<li class="job-type <?php echo get_the_job_type() ? sanitize_title( get_the_job_type()->slug ) : ''; ?>" itemprop="employmentType"><?php the_job_type(); ?></li>

			<?php if (class_exists( 'Astoundify_Job_Manager_Regions' )) { ?>
				<?php $stripped_location = strip_tags(get_the_job_location()); ?>
				<li class="location" itemprop="jobLocation"><?php echo $stripped_location ?></li>
			<?php } else { ?>
				<li class="location" itemprop="jobLocation"><?php the_job_location(false); ?></li>
			<?php } ?>

			<li class="date-posted" itemprop="datePosted"><date><?php printf( __( 'Posted %s ago', 'petsitter' ), human_time_diff( get_post_time( 'U' ), current_time( 'timestamp' ) ) ); ?></date></li>

			<?php if ( is_position_filled() ) : ?>
				<li class="position-filled"><?php _e( 'This position has been filled', 'petsitter' ); ?></li>
			<?php elseif ( ! candidates_can_apply() && 'preview' !== $post->post_status ) : ?>
				<li class="listing-expired"><?php _e( 'Applications have closed', 'petsitter' ); ?></li>
			<?php endif; ?>

			<?php do_action( 'single_job_listing_meta_end' ); ?>
		</ul>
		<!-- /Meta -->

		<?php // Removed from here @since 1.3 
		// do_action( 'single_job_listing_meta_after' ); ?>

		<!-- Company Links -->
		<div class="company-links-wrapper">

		<?php 
		$website = get_the_company_website();
		$facebook_link = get_post_meta( $post->ID, '_company_facebook', true );
		$google_link = get_post_meta( $post->ID, '_company_google', true );
		$linkedin_link = get_post_meta( $post->ID, '_company_linkedin', true );
		?>

		<?php if ( $website ) : ?>
			<a class="website" href="<?php echo esc_url( $website ); ?>" itemprop="url" target="_blank" rel="nofollow"><?php _e( 'Website', 'petsitter' ); ?></a>
		<?php endif; ?>

		<?php the_company_twitter(); ?>

		<?php if ( $facebook_link ) : ?>
		<a class="company_facebook" href="https://www.facebook.com/<?php echo esc_attr( $facebook_link ); ?>" itemprop="url" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i><?php _e('Facebook', 'petsitter'); ?></a>
		<?php endif; ?>

		<?php if ( $google_link ) : ?>
		<a class="company_google" href="http://plus.google.com/<?php echo esc_attr( $google_link ); ?>" itemprop="url" target="_blank" rel="nofollow"><i class="fa fa-google-plus"></i><?php _e('Google+', 'petsitter'); ?></a>
		<?php endif; ?>

		<?php if ( $linkedin_link ) : ?>
		<a class="company_google" href="<?php echo esc_url( $linkedin_link ); ?>" itemprop="url" target="_blank" rel="nofollow"><i class="fa fa-linkedin"></i><?php _e('LinkedIn', 'petsitter'); ?></a>
		<?php endif; ?>

		</div>
		<!-- Company Links / End -->
		
	</div>
</div>