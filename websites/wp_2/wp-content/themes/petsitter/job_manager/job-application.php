<?php if ( $apply = get_the_job_application_method() ) :
	wp_enqueue_script( 'wp-job-manager-job-application' );
	?>
	<div class="job_application application">
		<div class="application_btns">
			<?php do_action( 'job_application_start', $apply ); ?>
		</div>
		

		<button class="application_button btn btn-primary btn-lg">
			<i class="fa fa-check"></i> <?php _e( 'Apply for job', 'petsitter' ); ?>
		</button>

		<div class="application_details">
			<?php
				/**
				 * job_manager_application_details_email or job_manager_application_details_url hook
				 */
				do_action( 'job_manager_application_details_' . $apply->type, $apply );
			?>
		</div>
		<?php do_action( 'job_application_end', $apply ); ?>
	</div>
<?php endif; ?>
