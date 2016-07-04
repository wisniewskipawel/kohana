<?php
/**
 * Single Resume (for WP Job Manager - Resume Profiles)
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package PetSitter
 * @since PetSitter 1.6.0
 */

get_header(); ?>

	<div id="primary" class="page-content">
		<div id="content" class="container" role="main">
			<div class="company-profile row">

				<div class="company-profile-jobs col-md-9 col-sm-8 col-xs-12">
					<?php if ( have_posts() ) : ?>
					<div class="resumes">
						<ul class="resumes">
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_job_manager_template_part( 'content', 'resume', '/wp-job-manager-resumes/' ); ?>
							<?php endwhile; ?>
						</ul>
					</div>
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
				</div>

				<div class="company-profile-info job-meta col-md-3 col-sm-4 col-xs-4">

					<figure class="alignnone job-cover-img">
						<?php the_candidate_photo('portfolio-n'); ?>
					</figure>

					<?php the_title( '<h3 class="name">', '</h3>' ); ?>

					<!-- Meta -->
					<div class="list">
						<ul class="list__arrow1">
							<?php do_action( 'single_resume_meta_start' ); ?>

							<?php the_company_tagline( '<li><em>', '</em></li>' ); ?>
						
							<li><?php the_candidate_location(false); ?></li>
						
							<li class="date-posted" itemprop="datePosted"><date><?php printf( __( 'Updated %s ago', 'petsitter' ), human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ) ) ); ?></date></li>
						
							<?php do_action( 'single_resume_meta_end' ); ?>
						</ul>
						<?php the_resume_links(); ?>
					</div>
					<!-- /Meta -->

				</div>
			</div>
		</div><!-- #content -->

	</div><!-- #primary -->

<?php get_footer(); ?>