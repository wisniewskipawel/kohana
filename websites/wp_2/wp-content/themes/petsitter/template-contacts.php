<?php /* Template Name: Contacts */ ?>

<?php get_header(); ?>

<?php global $petsitter_data; ?>

<div class="page-content">
	<div class="container">

		<?php if($petsitter_data['opt-contact-gmap'] == 1): ?>
		<script type="text/javascript">
			jQuery(function($){
				$('#map_canvas').gmap3({
					marker:{
						values:[
							{address:'<?php echo $petsitter_data["opt-contact-coordinates"]; ?>'},

							<?php if(isset($petsitter_data['opt-contact-coordinates2']) && $petsitter_data['opt-contact-coordinates2'] != ""): ?>
							{address:'<?php echo $petsitter_data["opt-contact-coordinates2"]; ?>'},
							<?php endif; ?>

						],
					},
					map:{
						options:{
							zoom: <?php echo $petsitter_data["opt-contact-zoom"]; ?>,
							scrollwheel: false,
							streetViewControl : true,
							<?php if(isset($petsitter_data['babysitter__map-center-coordinates']) && $petsitter_data['babysitter__map-center-coordinates'] != ""): ?>
							center: [<?php echo $petsitter_data["babysitter__map-center-coordinates"]; ?>],
							<?php endif; ?>
						}
					}
			  });
			});
		</script><!-- Google Map Init-->
		<!-- Google Map -->
		<div class="googlemap-wrapper">
			<div id="map_canvas" class="map-canvas"></div>
		</div>
		<!-- Google Map / End -->
		<?php endif; ?>


		<div class="row">
			<div class="col-md-9">
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
					<?php the_content(); ?>
				</div><!-- .post-->
				<?php endwhile; ?>
			</div>
			<div class="col-md-3">
				<hr class="visible-sm visible-xs lg">

				<?php if($petsitter_data['opt-contact-info'] == 1): ?>
				<!-- Contacts Info -->
				<div class="contacts-widget widget widget__sidebar">
					<h2><?php echo $petsitter_data['opt-contact-title']; ?></h2>
					<div class="widget-content">
						<ul class="contacts-info-list">
							<?php if(isset($petsitter_data['opt-contact-address']) && $petsitter_data['opt-contact-address'] != ""): ?>
							<li>
								<i class="fa fa-map-marker"></i>
								<div class="info-item">
									<?php echo $petsitter_data['opt-contact-address']; ?>
								</div>
							</li>
							<?php endif; ?>
							<?php if(isset($petsitter_data['opt-contact-address2']) && $petsitter_data['opt-contact-address2'] != ""): ?>
							<li>
								<i class="fa fa-map-marker"></i>
								<div class="info-item">
									<?php echo $petsitter_data['opt-contact-address2']; ?>
								</div>
							</li>
							<?php endif; ?>
							<?php if(isset($petsitter_data['opt-contact-phone']) && $petsitter_data['opt-contact-phone'] != ""): ?>
							<li>
								<i class="fa fa-phone"></i>
								<div class="info-item">
									<?php
										foreach( $petsitter_data['opt-contact-phone'] as $key => $value){
											echo "$value <br />";
										}
									?>
								</div>
							</li>
							<?php endif; ?>
							<?php if(isset($petsitter_data['opt-contact-fax']) && is_array( $petsitter_data['opt-contact-fax'] ) ): ?>
							<li>
								<i class="fa fa-fax"></i>
								<div class="info-item">
									<?php
										foreach( $petsitter_data['opt-contact-fax'] as $key => $value){
											echo "$value <br />";
										}
									?>
								</div>
							</li>
							<?php endif; ?>
							<?php if(isset($petsitter_data['opt-contact-skype']) && $petsitter_data['opt-contact-skype'] != ""): ?>
							<li>
								<i class="fa fa-skype"></i>
								<div class="info-item">
									<a href="skype:<?php echo $petsitter_data['opt-contact-skype']; ?>?call"><?php echo $petsitter_data['opt-contact-skype']; ?></a>
								</div>
							</li>
							<?php endif; ?>
							<?php if(isset($petsitter_data['opt-contact-email']) && $petsitter_data['opt-contact-email'] != ""): ?>
							<li>
								<i class="fa fa-envelope"></i>
								<span class="info-item">
									<?php
										foreach( $petsitter_data['opt-contact-email'] as $key => $value){
											echo "<a href='mailto:$value'>$value</a> <br />";
										}
									?>
								</span>
							</li>
							<?php endif; ?>
							<?php if(isset($petsitter_data['opt-contact-hours'])): ?>
							<li>
								<i class="fa fa-clock-o"></i>
								<div class="info-item">
									<?php echo $petsitter_data['opt-contact-hours']; ?>
								</div>
							</li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
				<!-- /Contacts Info -->
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
