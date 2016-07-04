<?php
/**
 * Resume Category
 *
 * @package PetSitter
 * @since PetSitter 1.4.7
 */

get_header(); ?>

	<div class="page-content">
		<div class="container">

			<?php if ( have_posts() ) : ?>
			<div class="resumes">
				<ul class="resumes">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_job_manager_template_part( 'content', 'resume', 'wp-job-manager-resumes' ); ?>
					<?php endwhile; ?>
				</ul>
			</div>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

		</div>
	</div>

<?php get_footer(); ?>