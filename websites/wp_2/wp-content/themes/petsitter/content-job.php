<?php
/**
 * content-job_listing.php
 *
 * The template for displaying jobs.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		
		<?php the_content(); ?>

	</div><!-- .entry-content -->
</article><!-- #post-## -->