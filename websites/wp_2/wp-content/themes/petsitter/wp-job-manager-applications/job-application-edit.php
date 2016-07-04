<form class="job-manager-application-edit-form job-manager-form" method="post">
	
	<fieldset class="fieldset-status">
		<label for="application-status-<?php esc_attr_e( $application->ID ); ?>"><?php _e( 'Application status', 'petsitter' ); ?>:</label>
		<div class="field">
			<div class="select-style">
				<select id="application-status-<?php esc_attr_e( $application->ID ); ?>" name="application_status">
					<?php foreach ( get_job_application_statuses() as $name => $label ) : ?>
						<option value="<?php echo esc_attr( $name ); ?>" <?php selected( $application->post_status, $name ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</fieldset>

	<fieldset class="fieldset-rating">
		<label for="application-rating-<?php esc_attr_e( $application->ID ); ?>"><?php _e( 'Rating (out of 5)', 'petsitter' ); ?>:</label>
		<div class="field">
			<input type="number" class="form-control" id="application-rating-<?php esc_attr_e( $application->ID ); ?>" name="application_rating" step="0.1" max="5" min="0" placeholder="0" value="<?php echo esc_attr( get_job_application_rating( $application->ID ) ); ?>" />
		</div>
	</fieldset>

	<p>
		<a class="btn btn-sm btn-danger pull-right" href="<?php echo wp_nonce_url( add_query_arg( 'delete_job_application', $application->ID ), 'delete_job_application' ); ?>"><?php _e( 'Delete', 'petsitter' ); ?></a>
		<input type="submit" class="btn btn-secondary btn-sm" name="wp_job_manager_edit_application" value="<?php esc_attr_e( 'Save changes', 'petsitter' ); ?>" />
		<input type="hidden" name="application_id" value="<?php echo absint( $application->ID ); ?>" />
		<?php wp_nonce_field( 'edit_job_application' ); ?>
	</p>
</form>