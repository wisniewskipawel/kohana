<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package PetSitter
 */

get_header(); ?>

<div class="page-content">
	<div class="container">

		<div class="row">
			<div class="col-md-8 col-md-offset-2 text-center">
				<h2 class="error-title">404</h2>
				<h3><?php _e( 'We\'re sorry, but the page you were looking for doesn\'t exist.', 'petsitter' ); ?></h3>
				
				<p class="error-desc"><?php _e( 'Please try using our search box below to look for information on the our site.', 'petsitter' ); ?></p>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<?php get_search_form(); ?>
			</div>
		</div>

		<div class="spacer-lg"></div>

	</div>
</div>
<!-- Page Content / End -->

<?php get_footer(); ?>