<?php
/**
 * The template for displaying all single posts.
 *
 * @package PetSitter
 */

get_header(); ?>

<?php global $petsitter_data;
	
	$content_class = '';
	$sidebar_class = '';

	$blog_sidebar = $petsitter_data['opt-blog-sidebar']; 
	switch ($blog_sidebar) {
		case '1':
			$content_class = 'col-md-8';
			$sidebar_class = 'col-md-3 col-md-offset-1 col-bordered';
			break;
		case '2':
			$content_class = 'col-md-8 col-md-8 col-md-offset-1 col-md-push-3';
			$sidebar_class = 'col-md-3 col-md-pull-9 col-bordered';
			break;
		case '3':
			$content_class = 'col-md-12';
			break;
	}

?>

<section id="primary" class="page-content">
	<div class="container">
		<div class="row">
			<main id="main" class="content <?php echo $content_class; ?>" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php // petsitter_post_nav(); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

			<?php if( $blog_sidebar != 3) : ?>

			<hr class="visible-sm visible-xs lg">

			<div id="sidebar" class="sidebar <?php echo $sidebar_class; ?>">
				<?php get_sidebar(); ?>
			</div>

			<?php endif; ?>
		</div>
	</div>	
</section><!-- #primary -->
<?php get_footer(); ?>