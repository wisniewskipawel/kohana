<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package PetSitter
 */
?>

<?php global $petsitter_data; ?>

		<!-- Footer -->
		<footer class="footer" id="footer">

			<?php
			$footer_widgets_layout = $petsitter_data['opt-footer-widgets-layout'];
			$footer_widget_1 = '';
			$footer_widget_2 = '';
			$footer_widget_3 = '';
			$footer_widget_4 = '';

			switch ($footer_widgets_layout) {
				case '1':
					$footer_widget_1 = 'col-sm-6 col-md-2';
					$footer_widget_2 = 'col-sm-6 col-md-2';
					$footer_widget_3 = 'col-sm-6 col-md-4';
					$footer_widget_4 = 'col-sm-6 col-md-4';
					break;
				case '2':
					$footer_widget_1 = 'col-sm-6 col-md-3';
					$footer_widget_2 = 'col-sm-6 col-md-3';
					$footer_widget_3 = 'col-sm-6 col-md-3';
					$footer_widget_4 = 'col-sm-6 col-md-3';
					break;
				case '3':
					$footer_widget_1 = 'col-sm-4 col-md-6';
					$footer_widget_2 = 'col-sm-4 col-md-3';
					$footer_widget_3 = 'col-sm-4 col-md-3';
					break;
				case '4':
					$footer_widget_1 = 'col-sm-4 col-md-3';
					$footer_widget_2 = 'col-sm-4 col-md-3';
					$footer_widget_3 = 'col-sm-4 col-md-6';
					break;
				case '5':
					$footer_widget_1 = 'col-sm-4 col-md-4';
					$footer_widget_2 = 'col-sm-4 col-md-4';
					$footer_widget_3 = 'col-sm-4 col-md-4';
					break;
				case '6':
					$footer_widget_1 = 'col-sm-4 col-md-4';
					$footer_widget_2 = 'col-sm-8 col-md-8';
					break;
				case '7':
					$footer_widget_1 = 'col-sm-8 col-md-8';
					$footer_widget_2 = 'col-sm-4 col-md-4';
					break;
			}
			?>

			<?php if($petsitter_data['opt-footer-widgets'] == 1 && !is_page_template( 'template-coming-soon.php' )): ?>
			<div class="footer-widgets">
				<div class="container">
					<div class="row">
						<div class="<?php echo $footer_widget_1; ?>">
							<?php dynamic_sidebar('petsitter-footer-widget-1'); ?>
						</div>
						<div class="<?php echo $footer_widget_2; ?>">
							<?php dynamic_sidebar('petsitter-footer-widget-2'); ?>
						</div>

						<?php if( $footer_widgets_layout == 1 || $footer_widgets_layout == 2 ): ?>
						<div class="clearfix visible-sm"></div>
						<?php endif; ?>

						<?php if( $footer_widgets_layout == 1 || $footer_widgets_layout == 2 || $footer_widgets_layout == 3  || $footer_widgets_layout == 4  || $footer_widgets_layout == 5 ): ?>
						<div class="<?php echo $footer_widget_3; ?>">
							<?php dynamic_sidebar('petsitter-footer-widget-3'); ?>
						</div>
						<?php endif; ?>

						<?php if( $footer_widgets_layout == 1 || $footer_widgets_layout == 2 ): ?>
						<div class="<?php echo $footer_widget_4; ?>">
							<?php dynamic_sidebar('petsitter-footer-widget-4'); ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<?php if($petsitter_data['opt-footer-copyright'] == 1): ?>
			<div class="footer-copyright">
				<div class="container">
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="footer-copyright-txt">
								<?php echo $petsitter_data['opt-footer-text']; ?>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="social-links-wrapper">

								<?php if($petsitter_data['petsitter__footer-links'] == 1): ?>
								<!-- Social Links / End -->
								<?php if(isset($petsitter_data['petsitter__footer-social-text']) && $petsitter_data['petsitter__footer-social-text'] != ""): ?>
									<span class="social-links-txt"><?php echo $petsitter_data['petsitter__footer-social-text']; ?></span>
								<?php endif; ?>
								<ul class="social-links social-links__light">

									<?php if(isset($petsitter_data['petsitter__footer-social-fb']) && $petsitter_data['petsitter__footer-social-fb'] != ""): ?>
									<li><a href="<?php echo $petsitter_data['petsitter__footer-social-fb']; ?>"><i class="fa fa-facebook"></i></a></li>
									<?php endif; ?>

									<?php if(isset($petsitter_data['petsitter__footer-social-twitter']) && $petsitter_data['petsitter__footer-social-twitter'] != ""): ?>
									<li><a href="<?php echo $petsitter_data['petsitter__footer-social-twitter']; ?>"><i class="fa fa-twitter"></i></a></li>
									<?php endif; ?>

									<?php if(isset($petsitter_data['petsitter__footer-social-linkedin']) && $petsitter_data['petsitter__footer-social-linkedin'] != ""): ?>
									<li><a href="<?php echo $petsitter_data['petsitter__footer-social-linkedin']; ?>"><i class="fa fa-linkedin"></i></a></li>
									<?php endif; ?>

									<?php if(isset($petsitter_data['petsitter__footer-social-google-plus']) && $petsitter_data['petsitter__footer-social-google-plus'] != ""): ?>
									<li><a href="<?php echo $petsitter_data['petsitter__footer-social-google-plus']; ?>"><i class="fa fa-google-plus"></i></a></li>
									<?php endif; ?>

									<?php if(isset($petsitter_data['petsitter__footer-social-pinterest']) && $petsitter_data['petsitter__footer-social-pinterest'] != ""): ?>
									<li><a href="<?php echo $petsitter_data['petsitter__footer-social-pinterest']; ?>"><i class="fa fa-pinterest"></i></a></li>
									<?php endif; ?>

									<?php if(isset($petsitter_data['petsitter__footer-social-youtube']) && $petsitter_data['petsitter__footer-social-youtube'] != ""): ?>
									<li><a href="<?php echo $petsitter_data['petsitter__footer-social-youtube']; ?>"><i class="fa fa-youtube"></i></a></li>
									<?php endif; ?>

									<?php if(isset($petsitter_data['petsitter__footer-social-instagram']) && $petsitter_data['petsitter__footer-social-instagram'] != ""): ?>
									<li><a href="<?php echo $petsitter_data['petsitter__footer-social-instagram']; ?>"><i class="fa fa-instagram"></i></a></li>
									<?php endif; ?>

									<?php if(isset($petsitter_data['petsitter__footer-social-tumblr']) && $petsitter_data['petsitter__footer-social-tumblr'] != ""): ?>
									<li><a href="<?php echo $petsitter_data['petsitter__footer-social-tumblr']; ?>"><i class="fa fa-tumblr"></i></a></li>
									<?php endif; ?>

									<?php if(isset($petsitter_data['petsitter__footer-social-dribbble']) && $petsitter_data['petsitter__footer-social-dribbble'] != ""): ?>
									<li><a href="<?php echo $petsitter_data['petsitter__footer-social-dribbble']; ?>"><i class="fa fa-dribbble"></i></a></li>
									<?php endif; ?>

									<?php if(isset($petsitter_data['petsitter__footer-social-vimeo']) && $petsitter_data['petsitter__footer-social-vimeo'] != ""): ?>
									<li><a href="<?php echo $petsitter_data['petsitter__footer-social-vimeo']; ?>"><i class="fa fa-vimeo-square"></i></a></li>
									<?php endif; ?>

									<?php if(isset($petsitter_data['petsitter__footer-social-flickr']) && $petsitter_data['petsitter__footer-social-flickr'] != ""): ?>
									<li><a href="<?php echo $petsitter_data['petsitter__footer-social-flickr']; ?>"><i class="fa fa-flickr"></i></a></li>
									<?php endif; ?>

									<?php if(isset($petsitter_data['petsitter__footer-social-yelp']) && $petsitter_data['petsitter__footer-social-yelp'] != ""): ?>
									<li><a href="<?php echo $petsitter_data['petsitter__footer-social-yelp']; ?>"><i class="fa fa-yelp"></i></a></li>
									<?php endif; ?>

									<?php if(isset($petsitter_data['petsitter__footer-social-rss']) && $petsitter_data['petsitter__footer-social-rss'] != ""): ?>
									<li><a href="<?php echo $petsitter_data['petsitter__footer-social-rss']; ?>"><i class="fa fa-rss"></i></a></li>
									<?php endif; ?>

								</ul>
								<!-- Social Links / End -->
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</footer>
		<!-- Footer / End -->

	</div><!-- .main -->
</div><!-- .site-wrapper -->

<?php wp_footer(); ?>
</body>
</html>
