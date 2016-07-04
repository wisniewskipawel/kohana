<?php 
global $petsitter_data;

//Placeholder Img URL
$resume_placeholder    = $petsitter_data['petsitter__candidate-placeholder']['url']; ?>

<li <?php resume_class(); ?>>
	<a href="<?php the_resume_permalink(); ?>">
		<?php the_candidate_photo( 'xsmall', $resume_placeholder); ?>
		<div class="candidate">
			<h3><?php the_title(); ?></h3>
		</div>
		<ul class="meta">
			<li class="candidate-title"><?php the_candidate_title(); ?></li>
			<li class="candidate-location"><?php the_candidate_location( false ); ?></li>
		</ul>
	</a>
</li>