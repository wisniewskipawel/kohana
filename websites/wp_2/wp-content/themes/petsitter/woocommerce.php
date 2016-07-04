<?php
/**
 * The template for displaying Woocommerce shop page.
 *
 * @package PetSitter
 * @since PetSitter 1.2
 */

get_header(); ?>

<div class="page-content">
	<div class="container">
		<div class="row">
			<!-- Content -->
			<div id="content" class="col-md-8">
				
				<?php woocommerce_content(); ?>
		
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