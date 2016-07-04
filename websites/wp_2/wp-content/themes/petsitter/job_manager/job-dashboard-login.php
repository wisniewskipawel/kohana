<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div id="job-manager-job-dashboard">
		
			<div class="alert alert-warning">
				<?php _e( 'You need to be signed in to manage your listings.', 'petsitter' ); ?>
			</div>
		
			<p class="account-sign-in"><a class="btn btn-secondary" href="<?php echo apply_filters( 'job_manager_job_dashboard_login_url', wp_login_url( get_permalink() ) ); ?>"><i class="fa fa-key"></i> <?php _e( 'Sign in', 'petsitter' ); ?></a></p>
		
		</div>
	</div>
</div>