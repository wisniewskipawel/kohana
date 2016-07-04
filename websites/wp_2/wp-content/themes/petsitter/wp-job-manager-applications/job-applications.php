<div id="job-manager-job-applications">
	<div class="job-manager-job-applications__top">
		<p>
			<a href="<?php echo esc_url( add_query_arg( 'download-csv', true ) ); ?>" class="job-applications-download-csv btn btn-default"><i class="fa fa-download"></i> <?php _e( 'Download CSV', 'petsitter' ); ?></a>
		</p>
		<p><?php printf( __( 'The job applications for "%s" are listed below.', 'petsitter' ), '<a href="' . get_permalink( $job_id ) . '">' . get_the_title( $job_id ) . '</a>' ); ?></p>
	</div>
	<div class="job-applications">
		<form class="filter-job-applications" method="GET">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<div class="select-style">
							<select name="application_status">
								<option value=""><?php _e( 'Filter by status', 'petsitter' ); ?>...</option>
									<?php foreach ( get_job_application_statuses() as $name => $label ) : ?>
										<option value="<?php echo esc_attr( $name ); ?>" <?php selected( $application_status, $name ); ?>><?php echo esc_html( $label ); ?></option>
									<?php endforeach; ?>
								</select>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="select-style">
							<select name="application_orderby">
								<option value=""><?php _e( 'Newest first', 'petsitter' ); ?></option>
								<option value="name" <?php selected( $application_orderby, 'name' ); ?>><?php _e( 'Sort by name', 'petsitter' ); ?></option>
								<option value="rating" <?php selected( $application_orderby, 'rating' ); ?>><?php _e( 'Sort by rating', 'petsitter' ); ?></option>
							</select>
						</div>
					</div>
					<input type="hidden" name="action" value="show_applications" />
					<input type="hidden" name="job_id" value="<?php echo absint( $_GET['job_id'] ); ?>" />
					<?php if ( ! empty( $_GET['page_id'] ) ) : ?>
						<input type="hidden" name="page_id" value="<?php echo absint( $_GET['page_id'] ); ?>" />
					<?php endif; ?>
				</div>
			</div>
		</form>
		<ul class="job-applications">
			<?php foreach ( $applications as $application ) : ?>
				<li class="job-application" id="application-<?php esc_attr_e( $application->ID ); ?>">
					<header>
						<?php job_application_header( $application ); ?>
					</header>
					<section class="job-application-content">
						<?php job_application_meta( $application ); ?>
						<?php job_application_content( $application ); ?>
					</section>
					<section class="job-application-edit">
						<?php job_application_edit( $application ); ?>
					</section>
					<section class="job-application-notes">
						<?php job_application_notes( $application ); ?>
					</section>
					<footer>
						<?php job_application_footer( $application ); ?>
					</footer>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php get_job_manager_template( 'pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
	</div>
</div>