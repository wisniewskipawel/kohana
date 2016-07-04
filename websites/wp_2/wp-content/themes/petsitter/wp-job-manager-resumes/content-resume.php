<?php 
global $petsitter_data;

$category = get_the_resume_category();
//Placeholder Img URL
$resume_placeholder    = $petsitter_data['petsitter__candidate-placeholder']['url']; ?>

<li <?php resume_class(); ?>>
	<a href="<?php the_resume_permalink(); ?>">
		<?php the_candidate_photo('xsmall', $resume_placeholder); ?>
		<div class="candidate-column">
			<h3><?php the_title(); ?></h3>
			<div class="candidate-title">
				<?php the_candidate_title( '<strong>', '</strong> ' ); ?>
			</div>
		</div>
		<div class="candidate-location-column">
			<?php the_candidate_location( false ); ?>
		</div>
		<div class="resume-posted-column <?php if ( $category ) : ?>resume-meta<?php endif; ?>">
			<date><?php printf( __( '%s ago', 'petsitter' ), human_time_diff( get_post_time( 'U' ), current_time( 'timestamp' ) ) ); ?></date>

			<?php if ( $category ) : ?>
				<div class="resume-category">
					<?php echo $category ?>
				</div>
			<?php endif; ?>
		</div>
	</a>
</li>