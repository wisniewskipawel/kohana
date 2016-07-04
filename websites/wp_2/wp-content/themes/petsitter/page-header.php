<?php 
global $petsitter_data; 

$page_header_parallax       = "";
$page_header_parallax_ratio = $petsitter_data['petsitter__page-header-parallax-ratio'];
if ($petsitter_data['petsitter__page-header-parallax-bg'] == 1) {
	$page_header_parallax = 'data-stellar-background-ratio="'.$page_header_parallax_ratio.'"';
}
?>

<div class="page-heading" <?php echo $page_header_parallax; ?>>
	<div class="container">

		<div class="row">
			<div class="col-md-6">

				<?php 
				// check for WooCommerce. If true, load WooCommerce custom layout
				if (class_exists('woocommerce') && ((is_woocommerce() == "true") || (is_checkout() == "true") || (is_cart() == "true") || (is_account_page() == "true") )){ ?>
				
				<h1>
					<?php if ( is_search() ) : ?>
						<?php printf( __( 'Search Results: &ldquo;%s&rdquo;', 'petsitter' ), get_search_query() ); ?>
					<?php elseif ( is_tax() ) : ?>
						<?php echo single_term_title( "", false ); ?>
					<?php elseif ( is_shop() ) : ?>
						<?php
							$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );

							echo apply_filters( 'the_title', ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) ) ? $shop_page_title : $shop_page->post_title );
						?>
					<?php else : ?>
						<?php the_title(); ?>
					<?php endif; ?>
					<?php if ( get_query_var( 'paged' ) ) : ?>
						<?php printf( __( '&nbsp;&ndash; Page %s', 'petsitter' ), get_query_var( 'paged' ) ); ?>
					<?php endif; ?>
				</h1>
				
				<?php // Standard Heading
				} else { ?>

					<?php if(is_home()){ ?>
						<h1><?php echo $petsitter_data['opt-blog-title']; ?></h1>
					<?php } elseif(is_search()) { ?>
						<h1><?php echo sprintf( __( '%s Search Results for ', 'petsitter' ), $wp_query->found_posts ); echo '<span>"' . get_search_query() . '"</span>'; ?></h1>
					
					<?php } elseif ( is_author() ) { ?>
						<?php 
							global $author;
							$userdata = get_userdata($author);
						?>
							<h1><?php echo $userdata->display_name; ?></h1>
							
					<?php } elseif ( is_404() ) { ?>
						<h1><?php printf( __( 'Page not found', 'petsitter' )); ?></h1>
					
					<?php } elseif ( is_category() ) { ?>
						<h1><?php printf( __( 'Category Archives: %s', 'petsitter' ), '<span>"' . single_cat_title( '', false ) . '"</span>' ); ?></h1>
						
					<?php } elseif ( is_tax('portfolio_category') ) { ?>
						<h1><?php $terms_as_text = get_the_term_list( $post->ID, 'portfolio_category', '', ', ', '' ) ;
						echo strip_tags($terms_as_text); ?></h1>

					<?php } elseif ( is_tax('job_listing_category') ) { ?>
						<?php $taxonomy = get_taxonomy( get_queried_object()->taxonomy ); ?>
					<?php if( $taxonomy ) : ?>
						<h1><?php echo esc_attr( $taxonomy->labels->singular_name ); ?>: '<?php echo single_cat_title( '', false ); ?>'</h1>
					<?php endif; ?>

					<?php } elseif ( is_tax('job_listing_type') ) { ?>
						<?php $taxonomy = get_taxonomy( get_queried_object()->taxonomy ); ?>
					<?php if( $taxonomy ) : ?>
						<h1><?php echo esc_attr( $taxonomy->labels->singular_name ); ?>: '<?php echo single_cat_title( '', false ); ?>'</h1>
					<?php endif; ?>

					<?php } elseif ( is_tax('resume_category') ) { ?>
						<?php $taxonomy = get_taxonomy( get_queried_object()->taxonomy ); ?>
					<?php if( $taxonomy ) : ?>
						<h1><?php echo esc_attr( $taxonomy->labels->singular_name ); ?>: '<?php echo single_cat_title( '', false ); ?>'</h1>
					<?php endif; ?>

					<?php } elseif ( is_tax('resume_skill') ) { ?>
						<?php $taxonomy = get_taxonomy( get_queried_object()->taxonomy ); ?>
					<?php if( $taxonomy ) : ?>
						<h1><?php echo esc_attr( $taxonomy->labels->singular_name ); ?>: '<?php echo single_cat_title( '', false ); ?>'</h1>
					<?php endif; ?>

					<?php } elseif ( is_post_type_archive('job_listing') ) { ?>
						<h1><?php printf( __( 'All Jobs', 'petsitter' )); ?></h1>

					<?php } elseif ( is_post_type_archive('resume') ) { ?>
						<h1><?php printf( __( 'All Resumes', 'petsitter' )); ?></h1>
					
					<?php } elseif ( is_day() ) { ?>
						<h1><?php printf( __( 'Day: %s', 'petsitter' ), '<span>' . get_the_date() . '</span>' ); ?></h1>
						
					<?php } elseif ( is_month() ) { ?>	
						<h1><?php printf( __( 'Month: %s', 'petsitter' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'petsitter' ) ) . '</span>' ); ?></h1>
						
					<?php } elseif ( is_year() ) { ?>	
						<h1><?php printf( __( 'Year: %s', 'petsitter' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'petsitter' ) ) . '</span>' ); ?></h1>
							
					<?php } elseif ( is_tag() ) { ?>
						<h1><?php printf( __( 'Tag Archives: %s', 'petsitter' ), '<span>"' . single_cat_title( '', false ) . '"</span>' ); ?></h1>
					
					<?php } else { ?>
						<h1><?php the_title(); ?></h1>
					<?php } ?>

					<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
				
				<?php } ?>
			</div>
			<div class="col-md-6">
				<?php 
				// Breadcrumb
				if (function_exists( 'breadcrumb_trail' ) && $petsitter_data['breadcrumbs'] == 1 ) {
					breadcrumb_trail();
				}?>
			</div>
		</div>
	</div>
</div>