<?php 
global $petsitter_data; 
$field_category = $petsitter_data['petsitter__slider-jobs-field-category'];

$show_categories = true;
if ( ! get_option( 'job_manager_enable_categories' ) ) {
	$show_categories = false;
} ?>

<?php if ( $show_categories && ! is_tax( 'job_listing_category' ) && get_terms( 'job_listing_category' ) ) : ?>
	<div class="form-group">
		<div class="select-style">
			<?php wp_dropdown_categories( array( 'taxonomy' => 'job_listing_category', 'hierarchical' => 1, 'show_option_all' => $field_category, 'name' => 'search_category', 'orderby' => 'name', 'class' => 'form-control' ) ); ?>
		</div>
	</div>
<?php endif; ?>