<?php if ( $packages || $user_packages ) :
	$checked = 1;
	?>
	<ul class="job_packages">
		<?php if ( $user_packages ) : ?>
			<li class="package-section"><?php _e( 'Your Packages:', 'petsitter' ); ?></li>
			<?php foreach ( $user_packages as $key => $package ) :
				$package = wc_paid_listings_get_package( $package );
				?>
				<li class="user-job-package">
					<div class="radio radio__custom radio__style1">
						<label for="user-package-<?php echo $package->get_id(); ?>">
							<input type="radio" <?php checked( $checked, 1 ); ?> name="job_package" value="user-<?php echo $key; ?>" id="user-package-<?php echo $package->get_id(); ?>" />
							<span><?php echo $package->get_title(); ?></span>
						</label>
					</div>
					<?php
						if ( $package->get_limit() ) {
							printf( _n( '%s job posted out of %d', '%s jobs posted out of %s', $package->get_count(), 'petsitter' ) . ', ', $package->get_count(), $package->get_limit() );
						} else {
							printf( _n( '%s job posted', '%s jobs posted', $package->get_count(), 'petsitter' ) . ', ', $package->get_count() );
						}

						if ( $package->get_duration() ) {
							printf( _n( 'listed for %s day', 'listed for %s days', $package->get_duration(), 'petsitter' ), $package->get_duration() );
						}

						$checked = 0;
					?>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
		<?php if ( $packages ) : ?>
			<li class="package-section"><?php _e( 'Purchase Package:', 'petsitter' ); ?></li>
			<?php foreach ( $packages as $key => $package ) :
				$product = wc_get_product( $package );
				if ( ! $product->is_type( array( 'job_package', 'job_package_subscription' ) ) || ! $product->is_purchasable() ) {
					continue;
				}
				?>
				<li class="job-package">
					<div class="radio radio__custom radio__style1">
						<label for="package-<?php echo $product->id; ?>">
							<input type="radio" <?php checked( $checked, 1 ); $checked = 0; ?> name="job_package" value="<?php echo $product->id; ?>" id="package-<?php echo $product->id; ?>" />
							<span><?php echo $product->get_title(); ?></span>
						</label>
					</div>
					<?php if ( ! empty( $product->post->post_excerpt ) ) : ?>
						<?php echo apply_filters( 'woocommerce_short_description', $product->post->post_excerpt ) ?>
					<?php else :
						printf( _n( '%s for %s job', '%s for %s jobs', $product->get_limit(), 'petsitter' ) . ' ', $product->get_price_html(), $product->get_limit() ? $product->get_limit() : __( 'unlimited', 'petsitter' ) );
						echo $product->get_duration() ? sprintf( _n( 'listed for %s day', 'listed for %s days', $product->get_duration(), 'petsitter' ), $product->get_duration() ) : '';
					endif; ?>
				</li>

			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
<?php else : ?>

	<p><?php _e( 'No packages found', 'petsitter' ); ?></p>

<?php endif; ?>