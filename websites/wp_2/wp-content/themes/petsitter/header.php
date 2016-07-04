<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package PetSitter
 */
?><!DOCTYPE html>
<!--[if IE]>        <html <?php language_attributes(); ?> class="ie"><![endif]-->
<!--[if !IE]><!-->  <html <?php language_attributes(); ?> class="not-ie">  <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php global $petsitter_data; ?>

<?php if($petsitter_data['favicon']): ?>
<link rel="shortcut icon" href="<?php echo $petsitter_data['favicon']['url']; ?>" type="image/x-icon" />
<?php endif; ?>

<?php if($petsitter_data['iphone_icon_retina']): ?>
<!-- For iPhone Retina display -->
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo $petsitter_data['iphone_icon_retina']['url']; ?>">
<?php endif; ?>

<?php if($petsitter_data['ipad_icon_retina']): ?>
<!-- For iPad Retina display -->
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo $petsitter_data['ipad_icon_retina']['url']; ?>">
<?php endif; ?>

<?php wp_head(); ?>

<?php if($petsitter_data['ace-editor-css']) { ?>
<!-- Custom CSS -->
<style>
<?php echo $petsitter_data['ace-editor-css']; ?>
</style>
<?php } ?>
</head>

<body <?php body_class(); ?>>

<?php
$layout_class  = '';

if($petsitter_data['petsitter__layout'] == 2) {
	$layout_class  = 'site-wrapper__boxed';
} else {
	$layout_class  = 'site-wrapper__full-width';
}
?>

<div class="site-wrapper <?php echo $layout_class; ?>">

	<?php if( is_page_template('template-coming-soon.php') ) { ?>
	<!-- Header -->
	<header class="header header-coming-soon">

		<div class="header-main">
			<div class="container">
				<!-- Logo -->
				<div class="logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo $petsitter_data['petsitter__coming-soon-logo']['url']; ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('description'); ?>" />
					</a>
				</div>
				<!-- Logo / End -->
			</div>
		</div>

	</header>
	<!-- Header / End -->
	<?php } else { ?>

	<!-- Header -->
	<header class="header header-menu-fullw">

		<?php if($petsitter_data['petsitter__header-top-bar'] == 1): ?>
		<!-- Header Top -->
		<div class="header-top">
			<div class="container">
				<div class="header-top-left">
					<?php
					// Secondary navigation
					petsitter_secondary_nav(); ?>
				</div>
				<div class="header-top-right">
					<?php // Cart
					if ( isset( $petsitter_data['petsitter__header-cart'] ) ) {
						$header_cart = $petsitter_data['petsitter__header-cart'];
					} else {
						$header_cart = '0';
					}
					if ( class_exists( 'WooCommerce' ) && $header_cart == 1) { ?>

						<div class="header-cart">
							<a class="cart-contents btn btn-sm btn-default" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'petsitter' ); ?>">
							<i class="fa fa-shopping-cart"></i>
							<span class="cart-number"><?php echo sprintf('%d', WC()->cart->cart_contents_count, WC()->cart->cart_contents_count ); ?></span>
							</a>
						</div>
					<?php } ?>

					<?php
					// Account navigation
					petsitter_tertiary_nav(); ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<!-- Header Main -->
		<div class="header-main">
			<div class="container">

				<!-- Logo -->
				<div class="logo">
					<?php if($petsitter_data['logo-standard']['url'] !== "") { ?>

						<!-- Logo Standard -->
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo $petsitter_data['logo-standard']['url']; ?>" class="logo-standard__light" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('description'); ?>" />
						</a>

					<?php } else { ?>

						<!-- Logo Text Default -->
						<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>

						<?php if (get_bloginfo('description') ) : ?>
						<p class="tagline"><?php bloginfo( 'description' ); ?></p>
						<?php endif; ?>
					<?php } ?>
				</div>
				<!-- Logo / End -->

				<button type="button" class="navbar-toggle">
					<i class="fa fa-bars"></i>
				</button>

				<!-- Header Info -->
				<div class="head-info">
					<ul class="head-info-list">

						<?php if(isset($petsitter_data['petsitter__header-phone-number']) && $petsitter_data['petsitter__header-phone-number'] != ""): ?>
						<li>
							<?php if(isset($petsitter_data['petsitter__header-phone-title']) && $petsitter_data['petsitter__header-phone-title'] != ""): ?>
							<span><?php echo $petsitter_data['petsitter__header-phone-title']; ?></span>
							<?php endif; ?>

							<?php if(isset($petsitter_data['petsitter__header-phone-number']) && $petsitter_data['petsitter__header-phone-number'] != ""): ?>
							<?php echo $petsitter_data['petsitter__header-phone-number']; ?>
							<?php endif; ?>
						</li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-email']) && $petsitter_data['petsitter__header-email'] != ""): ?>
						<li>
							<?php if(isset($petsitter_data['petsitter__header-email-title']) && $petsitter_data['petsitter__header-email-title'] != ""): ?>
							<span><?php echo $petsitter_data['petsitter__header-email-title']; ?></span>
							<?php endif; ?>

							<?php if(isset($petsitter_data['petsitter__header-email']) && $petsitter_data['petsitter__header-email'] != ""): ?>
							<a href="mailto:<?php echo $petsitter_data['petsitter__header-email']; ?>"><?php echo $petsitter_data['petsitter__header-email']; ?></a>
							<?php endif; ?>
						</li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-custom-info-text']) && $petsitter_data['petsitter__header-custom-info-text'] != ""): ?>
						<li>
							<?php if(isset($petsitter_data['petsitter__header-custom-info-title']) && $petsitter_data['petsitter__header-custom-info-title'] != ""): ?>
							<span><?php echo $petsitter_data['petsitter__header-custom-info-title']; ?></span>
							<?php endif; ?>

							<?php if(isset($petsitter_data['petsitter__header-custom-info-text']) && $petsitter_data['petsitter__header-custom-info-text'] != ""): ?>
							<?php echo $petsitter_data['petsitter__header-custom-info-text']; ?>
							<?php endif; ?>
						</li>
						<?php endif; ?>

					</ul>
					<?php if($petsitter_data['petsitter__header-links'] == 1): ?>
					<!-- Social Links / End -->
					<ul class="social-links">

						<?php if(isset($petsitter_data['petsitter__header-social-fb']) && $petsitter_data['petsitter__header-social-fb'] != ""): ?>
						<li><a href="<?php echo $petsitter_data['petsitter__header-social-fb']; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-social-twitter']) && $petsitter_data['petsitter__header-social-twitter'] != ""): ?>
						<li><a href="<?php echo $petsitter_data['petsitter__header-social-twitter']; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-social-linkedin']) && $petsitter_data['petsitter__header-social-linkedin'] != ""): ?>
						<li><a href="<?php echo $petsitter_data['petsitter__header-social-linkedin']; ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-social-google-plus']) && $petsitter_data['petsitter__header-social-google-plus'] != ""): ?>
						<li><a href="<?php echo $petsitter_data['petsitter__header-social-google-plus']; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-social-pinterest']) && $petsitter_data['petsitter__header-social-pinterest'] != ""): ?>
						<li><a href="<?php echo $petsitter_data['petsitter__header-social-pinterest']; ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-social-youtube']) && $petsitter_data['petsitter__header-social-youtube'] != ""): ?>
						<li><a href="<?php echo $petsitter_data['petsitter__header-social-youtube']; ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-social-instagram']) && $petsitter_data['petsitter__header-social-instagram'] != ""): ?>
						<li><a href="<?php echo $petsitter_data['petsitter__header-social-instagram']; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-social-tumblr']) && $petsitter_data['petsitter__header-social-tumblr'] != ""): ?>
						<li><a href="<?php echo $petsitter_data['petsitter__header-social-tumblr']; ?>" target="_blank"><i class="fa fa-tumblr"></i></a></li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-social-dribbble']) && $petsitter_data['petsitter__header-social-dribbble'] != ""): ?>
						<li><a href="<?php echo $petsitter_data['petsitter__header-social-dribbble']; ?>" target="_blank"><i class="fa fa-dribbble"></i></a></li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-social-vimeo']) && $petsitter_data['petsitter__header-social-vimeo'] != ""): ?>
						<li><a href="<?php echo $petsitter_data['petsitter__header-social-vimeo']; ?>" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-social-flickr']) && $petsitter_data['petsitter__header-social-flickr'] != ""): ?>
						<li><a href="<?php echo $petsitter_data['petsitter__header-social-flickr']; ?>" target="_blank"><i class="fa fa-flickr"></i></a></li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-social-yelp']) && $petsitter_data['petsitter__header-social-yelp'] != ""): ?>
						<li><a href="<?php echo $petsitter_data['petsitter__header-social-yelp']; ?>" target="_blank"><i class="fa fa-yelp"></i></a></li>
						<?php endif; ?>

						<?php if(isset($petsitter_data['petsitter__header-social-rss']) && $petsitter_data['petsitter__header-social-rss'] != ""): ?>
						<li><a href="<?php echo $petsitter_data['petsitter__header-social-rss']; ?>" target="_blank"><i class="fa fa-rss"></i></a></li>
						<?php endif; ?>

					</ul>
					<!-- Social Links / End -->
					<?php endif; ?>
				</div>
				<!-- Header Info / End -->

			</div>
		</div>

		<!-- Navigation -->
		<nav class="nav-main">
			<div class="container">
				<?php
				// Primary navigation
				petsitter_nav(); ?>
			</div>
		</nav>
		<!-- Navigation / End -->

	</header>
	<!-- Header / End -->

	<?php } ?>


	<!-- Main -->
	<div class="main" role="main">

		<?php if(!is_search() && !is_404()) { // search and 404 pages excluded to avoid errors
			$title     = get_post_meta(get_the_ID(), 'petsitter_page_title', true);
			$slider    = get_post_meta(get_the_ID(), 'petsitter_page_slider', true);

			// Page Heading
			if($title != "Hide" && !is_page_template('template-coming-soon.php')) {
				get_template_part('page-header');
			}

			// Slider
			if($slider == "Show") { ?>

			<?php get_template_part('inc/sliders/flexslider'); ?>

			<?php } ?>

		<?php } elseif(is_search() || is_404()) {
			get_template_part('page-header');
		} ?>
