<?php
global $job_manager;
global $petsitter_data;

//Placeholder Img URL
$job_placeholder    = $petsitter_data['petsitter__employer-placeholder']['url']; ?>

<a href="<?php the_permalink(); ?>"><?php the_company_logo( 'portfolio-n', $job_placeholder); ?></a>

<div class="job_summary_content-holder">
	<div class="job_summary_content">

		<h5 class="name"><a href="<?php the_permalink(); ?>"><?php the_company_name(); ?></a></h5>
		<h6 class="job_summary_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
		<p class="job_summary_tagline"><?php the_company_tagline(); ?></p>

	</div>

	<footer class="job_summary_footer">
		<ul class="meta">
			<?php if ( get_the_job_type() ) : ?>
			<li class="category"><?php the_job_type(); ?></li>
			<?php endif; ?>
			<li class="location"><?php the_job_location( false ); ?></li>
			<li class="date"><?php printf( __( 'Posted %s ago', 'petsitter' ), human_time_diff( get_post_time( 'U' ), current_time( 'timestamp' ) ) ); ?></li>
		</ul>
	</footer>
</div>
