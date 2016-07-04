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

	$single_resume_sidebar = $petsitter_data['petsitter__single-resume-sidebar']; 
	switch ($single_resume_sidebar) {
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

					<?php get_template_part( 'content', 'resume-custom' ); ?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

			<?php if( $single_resume_sidebar != 3) : ?>

			<hr class="visible-sm visible-xs lg">

			<!-- Sidebar -->
			<div class="sidebar <?php echo $sidebar_class; ?>">
			<?php dynamic_sidebar('resume-sidebar');?>
			</div>
			<!-- /Sidebar -->

			<?php endif; ?>
		</div>
	</div>	
</section><!-- #primary -->
<?php get_footer(); ?>