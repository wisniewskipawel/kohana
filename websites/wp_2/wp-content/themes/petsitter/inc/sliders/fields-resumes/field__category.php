<?php 
global $petsitter_data; 
$field_resume_category = $petsitter_data['petsitter__slider-resumes-field-category'];

$show_resume_categories = true;
if ( ! get_option( 'resume_manager_enable_categories' ) ) {
	$show_resume_categories = false;
} ?>

<?php if ( $show_resume_categories && ! is_tax( 'resume_category' ) && get_terms( 'resume_category' ) ) : ?>
<div class="form-group">
	<div class="select-style">
		<?php wp_dropdown_categories( array( 'taxonomy' => 'resume_category', 'hierarchical' => 1, 'show_option_all' => $field_resume_category, 'name' => 'search_category', 'orderby' => 'name', 'class' => 'form-control', ) ); ?>
	</div>
</div>
<?php endif; ?>