<?php 
global $resume_preview;

if ( $resume_preview ) {
	return;
}

if ( resume_manager_user_can_view_contact_details( $post->ID ) ) :
	wp_enqueue_script( 'wp-resume-manager-resume-contact-details' );
	?>
	<div class="resume_contact">

		<button class="resume_contact_button btn btn-primary btn-lg">
			<i class="fa fa-envelope"></i> <?php _e( 'Contact', 'petsitter' ); ?>
		</button>

		<div class="resume_contact_details">
			<?php do_action( 'resume_manager_contact_details' ); ?>
		</div>
	</div>
<?php else : ?>

	<?php get_job_manager_template_part( 'access-denied', 'contact-details', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

<?php endif; ?>