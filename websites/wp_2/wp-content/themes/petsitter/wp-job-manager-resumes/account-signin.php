<?php if ( is_user_logged_in() ) : ?>

	<fieldset>
		<label><?php _e( 'Your account', 'petsitter' ); ?></label>
		<div class="field account-sign-in">
			<?php
				$user = wp_get_current_user();
				printf( __( 'You are currently signed in as <strong>%s</strong>.', 'petsitter' ), $user->user_login );
			?>

			&nbsp; <a class="btn btn-secondary btn-sm" href="<?php echo apply_filters( 'submit_resume_form_logout_url', wp_logout_url( get_permalink() ) ); ?>"><i class="fa fa-key"> </i><?php _e( 'Sign out', 'petsitter' ); ?></a>
		</div>
	</fieldset>

<?php else :

	$account_required             = resume_manager_user_requires_account();
	$registration_enabled         = resume_manager_enable_registration();
	$generate_username_from_email = resume_manager_generate_username_from_email();
	?>
	<fieldset>
		<label><?php _e( 'Have an account?', 'petsitter' ); ?></label>
		<div class="field account-sign-in">
			<p>
				<a class="btn btn-secondary btn-sm" href="<?php echo apply_filters( 'submit_resume_form_login_url', wp_login_url( get_permalink() ) ); ?>"><i class="fa fa-key"></i> <?php _e( 'Sign in', 'petsitter' ); ?></a>
			</p>

			<?php if ( $registration_enabled ) : ?>

				<div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
					<?php _e( 'If you don&rsquo;t have an account you can create one below by entering your email address. A password will be automatically emailed to you.', 'petsitter' ); ?>
				</div>

			<?php elseif ( $account_required ) : ?>

				<div class="alert alert-warning"><?php echo apply_filters( 'submit_resume_form_login_required_message',  __( 'You must sign in to submit a resume.', 'petsitter' ) ); ?></div>

			<?php endif; ?>
		</div>
	</fieldset>
	<?php if ( $registration_enabled ) : ?>
		<?php if ( ! $generate_username_from_email ) : ?>
			<fieldset>
				<label><?php _e( 'Username', 'petsitter' ); ?> <?php echo apply_filters( 'submit_resume_form_required_label', ( ! $account_required ) ? ' <small>' . __( '(optional)', 'petsitter' ) . '</small>' : '' ); ?></label>
				<div class="field">
					<input type="text" class="input-text" name="create_account_username" id="account_username" value="<?php if ( ! empty( $_POST['create_account_username'] ) ) echo sanitize_text_field( stripslashes( $_POST['create_account_username'] ) ); ?>" />
				</div>
			</fieldset>
		<?php endif; ?>
		<?php do_action( 'resume_manager_register_form' ); ?>
	<?php endif; ?>

<?php endif; ?>