<?php
//Theme Options vars
global $petsitter_data;
$filter         = $petsitter_data['opt-portfolio-filter'];
$count          = $petsitter_data['opt-portfolio-num'];
$title          = $petsitter_data['opt-portfolio-meta'];
$lightbox       = $petsitter_data['opt-portfolio-lightbox'];
$filter_btn_txt = $petsitter_data['opt-portfolio-filter-btn-txt'];
?>

<?php global $more;	$more = 0;

$grid    = "";
$imgsize = "";
$item    = "";
$wrap    = "";
if ( is_page_template('template-portfolio-2cols.php') ) {
	$grid    = "project-feed__2cols";
	$imgsize = "portfolio-lg";
	$item    = "col-sm-6 col-md-6";
} elseif (is_page_template('template-portfolio-4cols.php') ) {
	$grid    = "project-feed__3cols";
	$imgsize = "portfolio-n";
	$item    = "col-sm-6 col-md-3";
} elseif (is_page_template('template-portfolio-fullw.php') ) {
	$grid    = "project-feed__fullw";
	$imgsize = "portfolio-n";
	$item    = "";
	$wrap    = "container__fullw";
} else {
	$grid    = "project-feed__3cols";
	$imgsize = "portfolio-n";
	$item    = "col-sm-6 col-md-4";
}

?>

<!-- Page Content -->
<section class="page-content">
	<div class="container <?php echo $wrap; ?>">

		<?php if ( post_type_exists('portfolio') ) { ?>

		<?php
		// Category 
		$values        = get_post_custom_values("category");
		$cat_valued_id = get_post_custom_values("category_id");
		$cat           = $values[0];
		$cat_id        = $cat_valued_id[0];

		$catinclude    = 'portfolio_category='. $cat; ?>

		<?php if($filter == 1) { ?> 
		<!-- Project Feed Filter -->
		<ul class="project-feed-filter">
			
			<li><a href="#" class="btn btn-sm btn-default btn-secondary" data-filter="*">
				<?php if ( $cat ) { ?>
					<?php echo $cat; ?>
				<?php } else { ?>
					<?php echo $filter_btn_txt; ?>
				<?php } ?>
			</a></li>

			<?php 
			$portfolio_categories = get_categories(array('taxonomy'=>'portfolio_category', 'hierarchical'=>1, 'parent'=>$cat_id));
			foreach($portfolio_categories as $portfolio_category)
				echo '<li><a href="#" class="btn btn-sm btn-default" data-filter=".'.$portfolio_category->slug.'">' . $portfolio_category->name . '</a></li>';
			?>
		</ul>
		<!-- Project Feed Filter / End -->
		<?php } ?>


		<?php 
		// Loop
		$temp = $wp_query;
		$wp_query= null;
		$wp_query = new WP_Query(); ?>
		<?php $wp_query->query("post_type=portfolio&".$catinclude."&paged=".$paged.'&showposts='.$count); ?>
		<?php if ( ! have_posts() ) : ?>
		<div class="error404 not-found">
			<h2><?php _e( 'Not Found', 'petsitter' ); ?></h2>
			<div>
				<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'petsitter' ); ?></p>
				<div class="row">
					<div class="col-md-4"><?php get_search_form(); ?></div>
				</div>
			</div><!-- .entry-content -->
		</div><!-- #post-0 -->
		<?php endif; ?>


		<!-- Gallery -->
		<div class="project-feed row <?php echo $grid; ?>">
			<?php while ( have_posts() ) : the_post(); 

			$portfolio_terms = wp_get_object_terms($post->ID, 'portfolio_category');
			$portfolio_class = "folioItem " . $portfolio_terms[0]->slug;
			$portfolio_sort  = $portfolio_terms[0]->slug . '[1][0]';
			$portfolio_type  = $portfolio_terms[0]->slug;
			
			$thumb   = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
			$image   = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $imgsize);

			$short_info = get_post_meta(get_the_ID(), 'petsitter_short_info', true);
			?>
		  <div class="project-item <?php echo $item; ?> <?php foreach( $portfolio_terms as $portfolio_class ) { echo $portfolio_class->slug.' ';} ?>">
		  	<div class="project-item-inner">

		  		<?php if(has_post_thumbnail()): ?>

		  		<figure class="alignnone project-img">

		  			<?php if($lightbox == 1) { //Show Both ?>
							<img src="<?php echo $image[0] ?>" alt="" />
							<div class="overlay">
								<a href="<?php the_permalink(); ?>" class="dlink"><i class="fa fa-link"></i></a>
								<a href="<?php echo $img_url; ?>" class="popup-link zoom"><i class="fa fa-search"></i></a>
							</div>
		  			<?php } elseif ( $lightbox == 2 ) { //Show Lightbox Icon ?>

		  				<img src="<?php echo $image[0] ?>" alt="" />
							<div class="overlay">
								<a href="<?php echo $img_url; ?>" class="popup-link zoom single-link"><i class="fa fa-search"></i></a>
							</div>

		  			<?php } elseif ( $lightbox == 3 ) { //Show Link Icon ?>

			  			<img src="<?php echo $image[0] ?>" alt="" />
							<div class="overlay">
								<a href="<?php the_permalink(); ?>" class="dlink single-link"><i class="fa fa-link"></i></a>
							</div>

		  			<?php } else { //Hide Both ?>

		  				<?php if(has_post_thumbnail()): ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<img src="<?php echo $image[0] ?>" alt="" />
								</a>
							<?php endif; ?>

		  			<?php } ?>
		  		</figure>

		  		<?php endif; ?>

					<?php if($title == "1") : ?>
						<div class="project-desc">
							<h4 class="title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							</h4>
							<span class="desc">
							<?php if( $short_info != "") { ?>
								<?php echo $short_info; ?>
							<?php } else { ?>
								<?php the_time(get_option('date_format')); ?>
							<?php } ?>
							</span>
						</div>
					<?php endif; ?>
				</div>
		  </div>
		<?php endwhile; ?>
		</div>
		<!-- Gallery / End -->

		<!-- Pagination -->
		<?php petsitter_pagination(); ?>
		<!-- /Pagination -->

		<?php $wp_query = null; $wp_query = $temp;?>

		<script>
			jQuery(function($){
		    // initialize Isotope after all images have loaded
		    var $container = $('.project-feed').imagesLoaded( function() {
		        var $filter = $('.project-feed-filter');

		        $container.isotope({
		            filter:       '*',
		            resizable:    false,
		            layoutMode:   'fitRows',
		            itemSelector: '.project-item'
		        });

		        // filter items on button click
		        $filter.on( 'click', 'a', function() {
		            var filterValue = $(this).attr('data-filter');
		            $filter.find('a').removeClass('btn-secondary');
		            $(this).addClass('btn-secondary');
		            $container.isotope({ 
		                filter: filterValue
		            });
		            return false;
		        });

		    });
			});
		</script>

		<?php } else { ?>

		<div class="alert alert-warning"><?php _e( '<strong>DF Custom Post Types for Petsitter</strong> plugin is missed. Please install it to see Portfolio posts.', 'petsitter' ); ?></div>

		<?php } ?>

	</div>

</section>
<!-- Page Content / End -->