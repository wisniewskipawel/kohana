<?php wp_enqueue_script( 'wp-resume-manager-ajax-filters' );
do_action( 'resume_manager_resume_filters_before', $atts );

global $petsitter_data;

// Keywords Search Field - Placeholder Text
if(isset($petsitter_data['petsitter__form-resumes-field-keywords'])) {
	$field_keywords = $petsitter_data['petsitter__form-resumes-field-keywords'];
} else {
	$field_keywords = __('Keywords', 'petsitter');
}

// Location Search Field - Placeholder Text
if(isset($petsitter_data['petsitter__form-resumes-field-location'])) {
	$field_location = $petsitter_data['petsitter__form-resumes-field-location'];
} else {
	$field_location = __('Any Location', 'petsitter');
}

// Categories Search Field - Placeholder Text
if(isset($petsitter_data['petsitter__form-resumes-field-category'])) {
	$field_category = $petsitter_data['petsitter__form-resumes-field-category'];
} else {
	$field_category = __('Any category', 'petsitter');
}

$search_resumes_class = '';
if ( $show_categories && get_option( 'resume_manager_enable_categories' ) ) {
	$search_resumes_class = 'search_resumes-with-categories';
}
?>

<form class="resume_filters">

	<div class="search_resumes <?php echo $search_resumes_class; ?>">
		<?php do_action( 'resume_manager_resume_filters_search_resumes_start', $atts ); ?>

		<div class="search_keywords resume-filter">
			<label for="search_keywords"><?php echo esc_attr( $field_keywords ); ?></label>
			<input type="text" name="search_keywords" id="search_keywords" class="form-control" placeholder="<?php echo esc_attr( $field_keywords ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
		</div>

		<div class="search_location resume-filter">
			<label for="search_location"><?php echo esc_attr( $field_location ); ?></label>
			<input type="text" name="search_location" id="search_location" class="form-control" placeholder="<?php echo esc_attr( $field_location ); ?>" value="<?php echo esc_attr( $location ); ?>" />
		</div>

		<?php if ( $categories ) : ?>
			<?php foreach ( $categories as $category ) : ?>
				<input type="hidden" name="search_categories[]" value="<?php echo sanitize_title( $category ); ?>" />
			<?php endforeach; ?>
		<?php elseif ( $show_categories && get_option( 'resume_manager_enable_categories' ) && ! is_tax( 'resume_category' ) && get_terms( 'resume_category' ) ) : ?>
			<div class="search_categories resume-filter">
				<label for="search_categories"><?php echo esc_attr( $field_category ); ?></label>
				<?php if ( $show_category_multiselect ) : ?>
					<?php job_manager_dropdown_categories( array( 'taxonomy' => 'resume_category', 'hierarchical' => 1, 'name' => 'search_categories', 'orderby' => 'name', 'selected' => $selected_category, 'hide_empty' => false, 'placeholder' => $field_category ) ); ?>
				<?php else : ?>
					<?php wp_dropdown_categories( array( 'taxonomy' => 'resume_category', 'hierarchical' => 1, 'show_option_all' => $field_category, 'name' => 'search_categories', 'orderby' => 'name', 'selected' => $selected_category ) ); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="search_submit resume-filter">
			<label for="search_submit"><?php _e( 'Submit', 'petsitter' ); ?></label>
			<button type="submit" class="btn btn-block btn-secondary btn-single-icon"><i class="fa fa-lg fa-search"></i></button>
		</div>

		<?php do_action( 'resume_manager_resume_filters_search_resumes_end', $atts ); ?>
	</div>

	<div class="showing_resumes"></div>
</form>

<?php do_action( 'resume_manager_resume_filters_after', $atts ); ?>