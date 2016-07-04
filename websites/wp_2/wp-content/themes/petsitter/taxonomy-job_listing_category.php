<?php
/**
 * Job Category
 *
 * @package PetSitter
 * @since PetSitter 1.4.3
 */

get_header(); ?>

	<div class="page-content">
		<div class="container">

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

			<?php remove_filter( 'posts_clauses', 'order_featured_job_listing' ); ?>

		</div>
	</div>

<?php get_footer(); ?>