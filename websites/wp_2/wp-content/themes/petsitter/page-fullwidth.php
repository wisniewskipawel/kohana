<?php
/* Template Name: Full Width */

/**
 * The template for displaying page without sidebar.
 *
 * @package petsitter
 */

get_header(); ?>

<div class="page-content">
	<div class="container">
		<!-- Content -->
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'petsitter' ),
					'after'  => '</div>',
				) );
			?>				
		</div><!--// Page -->
		<?php endwhile; ?>
		<!-- /Content -->
	</div>
</div>

<?php get_footer(); ?>