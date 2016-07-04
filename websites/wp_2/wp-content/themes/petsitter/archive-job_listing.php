<?php
/**
 * Job Archives
 *
 * @package PetSitter
 * @since PetSitter 1.4.3
 */

get_header(); ?>

	<div class="page-content">
		<div class="container">
			<?php echo do_shortcode( '[jobs]' ); ?>
		</div>
	</div>

<?php get_footer(); ?>