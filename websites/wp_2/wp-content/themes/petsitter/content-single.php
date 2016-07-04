<?php
/**
 * @package PetSitter
 */
?>

<?php global $petsitter_data; 

$link_url          = esc_url(get_post_meta(get_the_ID(), 'petsitter_format_link_url', true));
$quote_author      = get_post_meta(get_the_ID(), 'petsitter_format_quote_author', true);
$quote_pos         = get_post_meta(get_the_ID(), 'petsitter_format_quote_pos', true);
$gallery_ids       = get_post_meta(get_the_ID(), 'petsitter_format_gallery_id', true);
$gallery_ids_array = array_map( 'trim', explode( ',', $gallery_ids ) );
$post_class        = 'post__with-icon';

$blog_date         = $petsitter_data['petsitter__post-date-icon'];

if ( $blog_date == 0) :
	$post_class     = 'post__without-icon';
endif;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>

	<?php if (get_post_format() == 'gallery' && $gallery_ids != "") { ?>
	
	<!-- begin gallery -->
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

			<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, 'thumbnail-lg'); ?>
			<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
			<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
			
			<div class="item">
				<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" />
			</div>

			<?php endforeach; ?>

		<?php endif; ?>
	</div>
	<!-- /Gallery -->

	<?php } else { ?>

		<?php if(has_post_thumbnail() && $petsitter_data['opt-post-image'] == 1 ) { ?>
		<figure class="alignnone entry-thumb">
			<?php the_post_thumbnail(); ?>
		</figure>
		<?php } ?>

	<?php } ?>

	<header class="entry-header">
		<?php if ($blog_date == 1) : ?>
		<div class="entry-icon visible-md visible-lg">
			<span class="date-lg"><?php the_time('j'); ?></span>
			<span class="date-sm"><?php the_time('M, Y'); ?></span>
			<?php
				switch(get_post_format()) {
					case 'image':
						$format_class = 'camera';
						break;
					case 'gallery':
						$format_class = 'picture';
						break;
					case 'video':
						$format_class = 'video';
						break;
					case 'quote':
						$format_class = 'quote';
						break;
					case 'link':
						$format_class = 'link';
						break;
					default:
						$format_class = 'text-doc';
						break;
				}
			?>
			<i class="entypo <?php echo $format_class; ?>"></i>
		</div>
		<?php endif; ?>
		<?php if(get_post_format() == 'link') { ?>

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', $link_url ), '</a></h2>' ); ?>
		<span class="entry-url"><a href="<?php echo $link_url; ?>"><?php echo $link_url; ?></a></span>

		<?php } else { ?>

		<?php if($petsitter_data['opt-post-title'] == 1): ?>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php endif; ?>

		<?php } ?>

		<div class="entry-meta">
			<?php petsitter_entry_categories(); ?>
			<?php petsitter_entry_tags(); ?>
			<?php petsitter_posted_by(); ?>
			<?php petsitter_entry_comments(); ?>
		</div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		
		<?php if(get_post_format() == 'quote') { ?>
			<blockquote>
				<?php the_content(); ?>
			</blockquote>
			<cite><?php echo $quote_author; ?> <span><?php echo $quote_pos; ?></span></cite>
		<?php } else { ?>
			<?php the_content(); ?>
		<?php } ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'petsitter' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

<?php if($petsitter_data['opt-social-box'] == 1): ?>
	<div class="post-share-box">
		<span class="share-box-title"><?php _e('Social Share:', 'petsitter'); ?></span>
		<ul class="social-links">
			<li>
				<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title(); ?>"><i class="fa fa-facebook"></i></a>
			</li>
			<li>
				<a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>"><i class="fa fa-twitter"></i></a>
			</li>
			<li>
				<a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>"><i class="fa fa-linkedin"></i></a>
			</li>
			<li>
				<a href="http://reddit.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>"><i class="fa fa-reddit"></i></a>
			</li>
			<li>
				<a href="http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink()); ?>&amp;name=<?php echo urlencode($post->post_title); ?>&amp;description=<?php echo urlencode(get_the_excerpt()); ?>"><i class="fa fa-tumblr"></i></a>
			</li>
			<li>
				<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i></a>
			</li>
			<li>
				<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
				<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;description=<?php echo urlencode($post->post_title); ?>&amp;media=<?php echo urlencode($full_image[0]); ?>"><i class="fa fa-pinterest"></i></a>
			</li>
			<li>
				<a href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>"><i class="fa fa-envelope"></i></a>
			</li>
		</ul>
	</div><!-- .share-box -->
	<?php endif; ?>

<?php if($petsitter_data['opt-info-box']): ?>
<div class="about-author">
	<div class="about-author-body clearfix">
		<div class="avatar-holder alignleft">
			<?php echo get_avatar(get_the_author_meta('email'), '100'); ?>
		</div>
		<div class="description">
			<h4><?php the_author(); ?></h4>
			<?php the_author_meta("description"); ?>
		</div>
	</div>
</div><!-- .about-author -->
<?php endif; ?>