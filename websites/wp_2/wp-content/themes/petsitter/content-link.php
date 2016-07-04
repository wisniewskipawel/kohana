<?php
/**
 * content-link.php
 *
 * The default template for displaying posts with the Link post format.
 */

global $petsitter_data;

$post_class     = 'post__with-icon';
$blog_date      = $petsitter_data['petsitter__post-date-icon'];

$link_url = esc_url(get_post_meta(get_the_ID(), 'petsitter_format_link_url', true));

if ( $blog_date == 0) :
	$post_class     = 'post__without-icon';
endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
	<?php if(has_post_thumbnail()) { ?>
	<figure class="alignnone entry-thumb">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
	</figure>
	<?php } ?>
	<header class="entry-header">
		<?php if ($blog_date == 1) : ?>
		<div class="entry-icon visible-md visible-lg">
			<span class="date-lg"><?php the_time('j'); ?></span>
			<span class="date-sm"><?php the_time('M, Y'); ?></span>
			<i class="entypo link"></i>
		</div>
		<?php endif; ?>
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', $link_url ), '</a></h2>' ); ?>
		<span class="entry-url"><a href="<?php echo $link_url; ?>"><?php echo $link_url; ?></a></span>
		<div class="entry-meta">
			<?php petsitter_entry_categories(); ?>
			<?php petsitter_entry_tags(); ?>
			<?php petsitter_posted_by(); ?>
			<?php petsitter_entry_comments(); ?>
		</div>
	</header><!-- .entry-header -->
</article><!-- #post-## -->