<?php
/**
 * Single Job/Company Post (for WP Job Manager - Company Profiles)
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package PetSitter
 * @since PetSitter 1.4.0
 */

get_header(); ?>

	<div id="primary" class="page-content">
		<div id="content" class="container" role="main">
			<div class="company-profile row">

				<div class="company-profile-jobs col-md-9 col-sm-8 col-xs-12">
					<?php if ( have_posts() ) : ?>
					<div class="job_listings">
						<ul class="job_listings">
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_job_manager_template_part( 'content', 'job_listing' ); ?>
							<?php endwhile; ?>
						</ul>
					</div>
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
				</div>

				<div class="company-profile-info job-meta col-md-3 col-sm-4 col-xs-4">

					<figure class="alignnone job-cover-img">
						<?php the_company_logo('portfolio-n'); ?>
					</figure>

					<h3><?php _e( 'Details', 'petsitter' ); ?></h3>

					<!-- Meta -->
					<?php do_action( 'single_job_listing_meta_before' ); ?>
					<div class="list">
						<ul class="list__arrow1">
							<?php do_action( 'single_job_listing_meta_start' ); ?>

							<?php the_company_tagline( '<li><em>', '</em></li>' ); ?>

							<?php if ( get_the_company_website() ) : ?>
							<li><a href="<?php echo get_the_company_website(); ?>" itemprop="url" target="_blank">
								<i class="fa fa-link"></i>&nbsp; <?php _e( 'Website', 'petsitter' ); ?>
							</a></li>
							<?php endif; ?>

							<?php if ( get_the_company_twitter() ) : ?>
							<li><a href="http://twitter.com/<?php echo get_the_company_twitter(); ?>" target="_blank">
								<i class="fa fa-twitter"></i>&nbsp; <?php _e( 'Twitter', 'petsitter' ); ?>
							</a></li>
							<?php endif; ?>
						
							<li class="location" itemprop="jobLocation"><?php the_job_location(false); ?></li>
						
							<li class="date-posted" itemprop="datePosted"><date><?php printf( __( 'Posted %s ago', 'petsitter' ), human_time_diff( get_post_time( 'U' ), current_time( 'timestamp' ) ) ); ?></date></li>
						
							<?php if ( is_position_filled() ) : ?>
								<li class="position-filled"><?php _e( 'This position has been filled', 'petsitter' ); ?></li>
							<?php endif; ?>
						
							<?php do_action( 'single_job_listing_meta_end' ); ?>
						</ul>
					</div>
					<!-- /Meta -->

				</div>
			</div>
		</div><!-- #content -->

	</div><!-- #primary -->

<?php get_footer(); ?>