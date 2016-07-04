<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package PetSitter
 */

get_header(); ?>

<div class="page-content">
	<div class="container">
		<div class="row">
			<!-- Content -->
			<div id="content" class="col-md-8">
				
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
			<aside class="sidebar col-md-3 col-md-offset-1 col-bordered">
				<?php dynamic_sidebar(); ?>
			</aside>
			<!-- /Sidebar -->
		</div>
	</div>
</div>

<?php get_footer(); ?>