<?php
/**
 * Template Name: Jobs Pricing - Style 1
 *
 * @package PetSitter
 * @since PetSitter 1.2
 */

global $wp_query;

$packages = new WP_Query( array(
	'post_type'  => 'product',
	'posts_per_page' => -1,
	'tax_query'  => array(
		array(
			'taxonomy' => 'product_type',
			'field'    => 'slug',
			'terms'    => array( 'job_package', 'job_package_subscription' )
		)
	),
	'meta_query' => array(
		array(
			'key'     => '_visibility',
			'value'   => array( 'catalog', 'visible' ),
			'compare' => 'IN'
		)
	)
) );

get_header(); ?>

	<div class="page-content woocommerce-page">
		<div class="container">

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<div class="wc-job-packages wc-job-packages__style1">

				<?php while ( $packages->have_posts() ) : $packages->the_post(); $package = get_product( get_post()->ID ); ?>

					<?php
						$table_style = "";
						$btn_style   = "";

						$count_posts = $packages->post_count;
						$table_col   = '';

						if ( $count_posts == 2 ) {
							$table_col = 'col-md-6 col-sm-6';
						} elseif ( $count_posts == 3) {
							$table_col = 'col-md-4 col-sm-4';
						} else {
							$table_col = 'col-md-3 col-sm-3';
						}

						if ( $package->is_featured()) {
							$table_style = "popular";
							$btn_style   = "btn-primary";
						} else {
							$table_style = "simple";
							$btn_style   = "btn-default";
						}
					?>
					<div class="<?php echo $table_col; ?>">
						<div class="pricing-table pricing-table__style1 woocommerce <?php echo $table_style; ?>">
							<header class="pricing-head">
								<h3><?php the_title(); ?></h3>
								<span class="price"><?php echo $package->get_price_html(); ?></span>
							</header>

							<div class="pricing-body">

								<p class="pricing-desc">
									<?php
										$limit = $package->get_limit();
										$duration = $package->get_duration();
										$obj  = get_post_type_object( 'job_listing' );

										echo _n(
											sprintf(
												'%1$s %2$s %3$s',
												$limit == 0 ? __( 'Unlimited', 'petsitter' ) : $limit,
												$obj->labels->singular_name,
												$duration == 0 ? '' : sprintf( 'for %d days',
												$duration )
											),
											sprintf(
												'%1$s %2$s %3$s',
												$limit == 0 ? __( 'Unlimited', 'petsitter' ) : $limit,
												$obj->labels->name,
												$duration == 0 ? '' : sprintf( 'for %d days',
												$duration )
											),
											$limit,
											'petsitter'
										) . ' ';
									?>
								</p>

								<?php the_content(); ?>

							</div>

							<footer class="pricing-footer">
								<?php
									$link 	= $package->add_to_cart_url();
									$label 	= apply_filters( 'add_to_cart_text', __( 'Add to cart', 'petsitter' ) );
								?>
								<a href="<?php echo esc_url( $link ); ?>" class="btn <?php echo $btn_style; ?>"><?php echo $label; ?></a>
							</footer>
						</div>
					</div>

				<?php endwhile; ?>

				</div>

			</div>
		</div>
	</div>

<?php get_footer(); ?>
