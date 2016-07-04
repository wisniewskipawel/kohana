<?php 
global $petsitter_data;

//Placeholder Img URL
$resume_placeholder    = $petsitter_data['petsitter__candidate-placeholder']['url']; ?>

<?php if ( resume_manager_user_can_view_resume( $post->ID ) ) : ?>
	<div class="single-resume-content">

		<?php do_action( 'single_resume_start' ); ?>

		<div class="row resume-profile-info">
			<div class="col-md-5">
				<figure class="alignnone">
					<?php the_candidate_photo('portfolio-n', $resume_placeholder); ?>
				</figure>
				<div class="gallery-imgs">
					<?php display_resume_gallery_data('small'); ?>
				</div>
			</div>
			<div class="col-md-7">
				<?php the_title( '<h2 class="name">', '</h2>' ); ?>
				<h4 class="job-title"><?php the_candidate_title(); ?></h4>

				<ul class="meta">
					<?php do_action( 'single_resume_meta_start' ); ?>

					<?php if ( get_the_resume_category() ) : ?>
						<li class="resume-category"><?php the_resume_category(); ?></li>
					<?php endif; ?>

					<li class="location"><?php the_candidate_location(false); ?></li>

					<li class="date-posted" itemprop="datePosted"><date><?php printf( __( 'Updated %s ago', 'petsitter' ), human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ) ) ); ?></date></li>

					<?php do_action( 'single_resume_meta_end' ); ?>
				</ul>

				<?php the_resume_links(); ?>
			</div>
		</div>

		<div class="spacer-sm"></div>

		<div class="resume_description">
			<h4><?php _e( 'Description', 'petsitter' ); ?></h4>
			<?php echo apply_filters( 'the_resume_description', get_the_content() ); ?>

			<?php the_candidate_video(); ?>
		</div>

		<?php if (!class_exists( 'GRM_Init' )) { ?>
			<?php if( get_the_candidate_location() ) { ?>

				<hr class="lg">

				<h4><?php _e( 'Location', 'petsitter' ); ?></h4>
				<script type="text/javascript">
					jQuery(function($){
						$('#map_canvas').gmap3({
							marker:{
								address: '<?php echo get_the_candidate_location(); ?>' 
							},
								map:{
								options:{
								zoom: 13,
								scrollwheel: false,
								streetViewControl : true
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
			<?php } ?>
		<?php } ?>

		<hr class="lg">

		<div class="row">
			<div class="col-md-4 col-sm-4">
				<?php if ( ( $skills = wp_get_object_terms( $post->ID, 'resume_skill', array( 'fields' => 'names' ) ) ) && is_array( $skills ) ) : ?>
					<h4><?php _e( 'Skills', 'petsitter' ); ?></h4>
					<div class="list list__arrow1">
						<ul>
							<?php echo '<li>' . implode( '</li><li>', $skills ) . '</li>'; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
			<div class="col-md-4 col-sm-4">
				<?php if ( $items = get_post_meta( $post->ID, '_candidate_experience', true ) ) : ?>
					<h4><?php _e( 'Experience', 'petsitter' ); ?></h4>
					<div class="list list__arrow1">
						<ul>
						<?php
							foreach( $items as $item ) : ?>

								<li>
									<small class="date"><?php echo esc_html( $item['date'] ); ?></small><br>
									<?php printf( __( '%s at %s', 'petsitter' ), '<strong class="job_title">' . esc_html( $item['job_title'] ) . '</strong>', '<strong class="employer">' . esc_html( $item['employer'] ) . '</strong>' ); ?><br>

									<?php echo wptexturize( $item['notes'] ); ?>
								</li>
							<?php endforeach;
						?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
			<div class="col-md-4 col-sm-4">
				<?php if ( $items = get_post_meta( $post->ID, '_candidate_education', true ) ) : ?>
					<h4><?php _e( 'Education', 'petsitter' ); ?></h4>
					<div class="list list__arrow1">
						<ul>
						<?php
							foreach( $items as $item ) : ?>
						
								<li>
									<small class="date"><?php echo esc_html( $item['date'] ); ?></small><br>
									<?php printf( __( '%s at %s', 'petsitter' ), '<strong class="qualification">' . esc_html( $item['qualification'] ) . '</strong>', '<strong class="location">' . esc_html( $item['location'] ) . '</strong>' ); ?><br>
									<?php echo wptexturize( $item['notes'] ); ?>
								</li>
						
							<?php endforeach;
						?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php // Hook position changed (for adding new field via Field Editor in "Bottom of resume listing" position) ?>
		<?php do_action( 'single_resume_end' ); ?>

		<?php get_job_manager_template( 'contact-details.php', array( 'post' => $post ), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>
		
	</div>
<?php else : ?>

	<?php get_job_manager_template_part( 'access-denied', 'single-resume', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

<?php endif; ?>