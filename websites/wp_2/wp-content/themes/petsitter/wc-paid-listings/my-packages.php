<?php
/**
 * My Packages
 *
 * Shows packages on the account page
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<h2><?php 
	if ( 'job_listing' === $type ) {
		echo apply_filters( 'woocommerce_my_account_wc_paid_listings_packages_title', __( 'My job packages', 'petsitter' ), $type ); 
	} else {
		echo apply_filters( 'woocommerce_my_account_wc_paid_listings_packages_title', __( 'My resume packages', 'petsitter' ), $type ); 
	}
?></h2>

<div class="table-responsive">
	<table class="table shop_table my_account_job_packages my_account_wc_paid_listing_packages">
		<thead>
			<tr>
				<th scope="col"><?php _e( 'Package Name', 'petsitter' ); ?></th>
				<th scope="col"><?php _e( 'Remaining', 'petsitter' ); ?></th>
				<?php if ( 'job_listing' === $type ) : ?>
					<th scope="col"><?php _e( 'Listing Duration', 'petsitter' ); ?></th>
				<?php endif; ?>
				<th scope="col"><?php _e( 'Featured?', 'petsitter' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $packages as $package ) : 
				$package = wc_paid_listings_get_package( $package );
				?>
				<tr>
					<td><?php echo $package->get_title(); ?></td>
					<td><?php echo $package->get_limit() ? absint( $package->get_limit() - $package->get_count() ) : __( 'Unlimited', 'petsitter' ); ?></td>
					<?php if ( 'job_listing' === $type ) : ?>
						<td><?php echo $package->get_duration() ? sprintf( _n( '%d day', '%d days', $package->get_duration(), 'petsitter' ), $package->get_duration() ) : '-'; ?></td>
					<?php endif; ?>
					<td><?php echo $package->is_featured() ? __( 'Yes', 'petsitter' ) : __( 'No', 'petsitter' ); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>