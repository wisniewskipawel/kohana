<?php
/* Template Name: Left Sidebar */

/**
 * The template for displaying page with left sidebar.
 *
 * @package PetSitter
 */

get_header(); ?>

<div class="page-content">
	<div class="container">
		<div class="row">
			<!-- Content -->
			<div id="content" class="col-md-8 col-md-offset-1 col-md-push-3">
				
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
					<div id="page-content">
						<?php get_template_part( 'content', 'page' ); ?>
					</div>					
				</div>
			  <?php endwhile; ?>
		
			</div>
			<!-- /Content -->
		
			<!-- Sidebar -->
			<div id="sidebar" class="sidebar col-md-3 col-md-pull-9 col-bordered">
				<?php dynamic_sidebar(); ?>
			</div>
			<!-- /Sidebar -->
		</div>
	</div>
</div>

<?php get_footer(); ?>