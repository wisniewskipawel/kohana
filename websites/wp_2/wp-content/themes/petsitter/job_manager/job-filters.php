<?php wp_enqueue_script( 'wp-job-manager-ajax-filters' );
do_action( 'job_manager_job_filters_before', $atts ); 

global $petsitter_data; 

// Keywords Search Field - Placeholder Text
if(isset($petsitter_data['petsitter__form-jobs-field-keywords'])) {
	$field_keywords = $petsitter_data['petsitter__form-jobs-field-keywords'];
} else {
	$field_keywords = __('Keywords', 'petsitter');
}

// Location Search Field - Placeholder Text
if(isset($petsitter_data['petsitter__form-jobs-field-location'])) {
	$field_location = $petsitter_data['petsitter__form-jobs-field-location'];
} else {
	$field_location = __('Any Location', 'petsitter');
}

// Categories Search Field - Placeholder Text
if(isset($petsitter_data['petsitter__form-jobs-field-category'])) {
	$field_category = $petsitter_data['petsitter__form-jobs-field-category'];
} else {
	$field_category = __('Any category', 'petsitter');
}

$search_jobs_class = '';
if ( $show_categories ) {
	$search_jobs_class = 'search_jobs-with-categories';
}
?>

<form class="job_filters">
	<?php do_action( 'job_manager_job_filters_start', $atts ); ?>

	<div class="search_jobs <?php echo $search_jobs_class; ?>">
		<?php do_action( 'job_manager_job_filters_search_jobs_start', $atts ); ?>

		<div class="search_keywords">
			<label for="search_keywords"><?php echo esc_attr( $field_keywords ); ?></label>
			<input type="text" name="search_keywords" id="search_keywords" class="form-control" placeholder="<?php echo esc_attr( $field_keywords ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
		</div>

		<div class="search_location">
			<label for="search_location"><?php echo esc_attr( $field_location ); ?></label>
			<input type="text" name="search_location" id="search_location" class="form-control" placeholder="<?php echo esc_attr( $field_location ); ?>" value="<?php echo esc_attr( $location ); ?>" />
		</div>

		<?php if ( $categories ) : ?>
			<?php foreach ( $categories as $category ) : ?>
				<input type="hidden" name="search_categories[]" value="<?php echo sanitize_title( $category ); ?>" />
			<?php endforeach; ?>
		<?php elseif ( $show_categories && ! is_tax( 'job_listing_category' ) && get_terms( 'job_listing_category' ) ) : ?>
			<div class="search_categories">
				<label for="search_categories"><?php echo esc_attr( $field_category ); ?></label>
				<?php if ( $show_category_multiselect ) : ?>
					<?php job_manager_dropdown_categories( array( 'taxonomy' => 'job_listing_category', 'hierarchical' => 1, 'name' => 'search_categories', 'orderby' => 'name', 'selected' => $selected_category, 'hide_empty' => false, 'class' => 'form-control', 'placeholder' => $field_category ) ); ?>
				<?php else : ?>	
					<?php job_manager_dropdown_categories( array( 'taxonomy' => 'job_listing_category', 'hierarchical' => 1, 'show_option_all' => $field_category, 'name' => 'search_categories', 'orderby' => 'name', 'selected' => $selected_category, 'class' => 'form-control', 'multiple' => false ) ); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="search_submit">
			<label for="search_submit"><?php _e( 'Submit', 'petsitter' ); ?></label>
			<button type="submit" class="btn btn-block btn-secondary btn-single-icon"><i class="fa fa-lg fa-search"></i></button>
		</div>

		<?php do_action( 'job_manager_job_filters_search_jobs_end', $atts ); ?>
	</div>

	<?php do_action( 'job_manager_job_filters_end', $atts ); ?>
</form>

<?php do_action( 'job_manager_job_filters_after', $atts ); ?>

<noscript><?php _e( 'Your browser does not support JavaScript, or it is disabled. JavaScript must be enabled in order to view listings.', 'petsitter' ); ?></noscript>