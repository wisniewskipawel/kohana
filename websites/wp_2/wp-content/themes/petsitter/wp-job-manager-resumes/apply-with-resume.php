<?php global $post;

if ( ! get_option( 'resume_manager_force_application' ) ) {
	echo '<hr />';
}

if ( is_user_logged_in() && sizeof( $resumes ) ) : ?>
	<form class="apply_with_resume" method="post">
		<p><?php _e( 'Apply using your online resume; just enter a short message and choose one of your resumes to email your application.', 'petsitter' ); ?></p><br>
		<div class="form-group">
			<label for="resume_id"><?php _e( 'Online resume', 'petsitter' ); ?>:</label>
			<div class="select-style">
				<select name="resume_id" id="resume_id" class="form-control" required>
					<option value=""><?php _e( 'Choose a resume...', 'petsitter' ); ?></option>
					<?php
						foreach ( $resumes as $resume ) {
							echo '<option value="' . absint( $resume->ID ) . '">' . esc_html( $resume->post_title ) . '</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label><?php _e( 'Message', 'petsitter' ); ?>:</label>
			<div class="form-group">
				<textarea name="application_message" cols="20" rows="4" class="form-control" required><?php
					if ( isset( $_POST['application_message'] ) ) {
						echo esc_textarea( stripslashes( $_POST['application_message'] ) );
					} else {
						echo _x( 'To whom it may concern,', 'default cover letter', 'petsitter' ) . "\n\n";
				
						printf( _x( 'I am very interested in the %s position at %s. I believe my skills and work experience make me an ideal candidate for this role. I look forward to speaking with you soon about this position.', 'default cover letter', 'petsitter' ), $post->post_title, get_post_meta( $post->ID, '_company_name', true ) );
				
						echo "\n\n" . _x( 'Thank you for your consideration.', 'default cover letter', 'petsitter' );
					}
				?></textarea>
			</div>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-secondary" name="wp_job_manager_resumes_apply_with_resume" value="<?php esc_attr_e( 'Send application', 'petsitter' ); ?>" />
			<input type="hidden" name="job_id" value="<?php echo absint( $post->ID ); ?>" />
		</div>
	</form>
<?php else : ?>
	<form class="apply_with_resume" method="post" action="<?php echo get_permalink( get_option( 'resume_manager_submit_resume_form_page_id' ) ); ?>">
		<p><?php _e( 'You can apply to this job and others using your online resume. Click the link below to submit your online resume and email your application to this employer.', 'petsitter' ); ?></p>

		<p>
			<input type="submit" class="btn btn-secondary" name="wp_job_manager_resumes_apply_with_resume_create" value="<?php esc_attr_e( 'Submit resume and apply', 'petsitter' ); ?>" />
			<input type="hidden" name="job_id" value="<?php echo absint( $post->ID ); ?>" />
		</p>
	</form>
<?php endif; ?>