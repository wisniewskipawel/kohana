<?php
/**
 * content-image.php
 *
 * The default template for displaying posts with the Image post format.
 */

global $petsitter_data;

$image_size     = 'col-md-12';
$details_size   = 'col-md-12';
$post_class     = 'post__with-icon';
$thumb_size     = 'thumbnail-lg';
$entry_icon     = 'visible-md visible-lg';

$blog_layout    = $petsitter_data['petsitter__blog-image-size'];
$blog_date      = $petsitter_data['petsitter__post-date-icon'];

if ( $blog_layout == 2 ) :
	$image_size     = 'col-xs-4 col-sm-4 col-md-5';
	$details_size   = 'col-xs-8 col-sm-8 col-md-7';
	$post_class     = 'post__without-icon';
	$thumb_size     = 'portfolio-n';
	$entry_icon     = '';
endif;

if ( $blog_date == 0) :
	$post_class     = 'post__without-icon';
endif;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
	<div class="row">
		
		<div class="<?php echo $image_size; ?>">
			<?php if(has_post_thumbnail()) { ?>
			<figure class="alignnone entry-thumb thumb__rollover">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($thumb_size); ?></a>
			</figure>
			<?php } ?>
		</div>
		
		<div class="<?php echo $details_size; ?>">
			<header class="entry-header">

				<?php if ($blog_date == 1) : ?>
				<div class="entry-icon <?php echo $entry_icon; ?>">
					<span class="date-lg"><?php the_time('j'); ?></span>
					<span class="date-sm"><?php the_time('M, Y'); ?></span>

					<?php if ( $blog_layout == 1 ) : ?>
					<i class="entypo camera"></i>
					<?php endif; ?>

				</div>
				<?php endif; ?>

				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				<div class="entry-meta">
					<?php petsitter_entry_categories(); ?>
					<?php petsitter_entry_tags(); ?>
					<?php petsitter_posted_by(); ?>
					<?php petsitter_entry_comments(); ?>
				</div>
			</header><!-- .entry-header -->

			<div class="entry-content">

				<?php the_excerpt(); ?>

				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'petsitter' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->
		</div>
	</div>
</article><!-- #post-## -->