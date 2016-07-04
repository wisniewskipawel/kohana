<?php
/**
 * content-gallery.php
 *
 * The default template for displaying posts with the Gallery post format.
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

<?php // Grab Gallery IDs
$gallery_ids = get_post_meta(get_the_ID(), 'petsitter_format_gallery_id', true);
$gallery_ids_array = array_map( 'trim', explode( ',', $gallery_ids ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
	<div class="row">
		
		<div class="<?php echo $image_size; ?>">
			<!-- Gallery -->
			<div class="owl-carousel owl-theme owl-slider thumbnail">
				<?php 
				$args = array(
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'post_status'    => 'inherit',
					'posts_per_page' => -1,
					'post__in'       => $gallery_ids_array
				);
				$attachments = get_posts($args); ?>

				<?php if ($attachments) : ?>

				<?php foreach ($attachments as $attachment) : ?>

				<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, $thumb_size); ?>
				<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
				<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
				
				<div class="item">
					<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" />
				</div>

				<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<!-- /Gallery -->
		</div>
		

		<div class="<?php echo $details_size; ?>">
			<header class="entry-header">
				
				<?php if ($blog_date == 1) : ?>
				<div class="entry-icon <?php echo $entry_icon; ?>">
					<span class="date-lg"><?php the_time('j'); ?></span>
					<span class="date-sm"><?php the_time('M, Y'); ?></span>

					<?php if ( $blog_layout == 1 ) : ?>
					<i class="entypo picture"></i>
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
			
			<?php if ( ! post_password_required() ) : ?>
			<footer class="entry-footer">
				<a href="<?php the_permalink() ?>" class="btn btn-secondary"><?php echo $petsitter_data['petsitter__blog-more-txt']; ?></a>
			</footer><!-- .entry-footer -->
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post-## -->