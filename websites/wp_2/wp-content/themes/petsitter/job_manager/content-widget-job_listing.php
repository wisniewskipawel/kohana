<?php 
global $petsitter_data;

//Placeholder Img URL
$job_placeholder    = $petsitter_data['petsitter__employer-placeholder']['url']; ?>

<li <?php job_listing_class(); ?>>
	<a href="<?php the_job_permalink(); ?>">
		<?php the_company_logo( 'xsmall', $job_placeholder); ?>
		<div class="position">
			<h3><?php the_title(); ?></h3>
		</div>
		<ul class="meta">

			<?php if (class_exists( 'Astoundify_Job_Manager_Regions' )) { ?>
				<?php $stripped_location = strip_tags(get_the_job_location()); ?>
				<li class="location"><?php echo $stripped_location ?></li>
			<?php } else { ?>
				<li class="location"><?php the_job_location( false ); ?></li>
			<?php } ?>

			<li class="company"><?php the_company_name(); ?></li>
			<li class="job-type <?php echo get_the_job_type() ? sanitize_title( get_the_job_type()->slug ) : ''; ?>"><?php the_job_type(); ?></li>
		</ul>
	</a>
</li>