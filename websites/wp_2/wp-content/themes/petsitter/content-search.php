<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package PetSitter
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post__with-icon'); ?>>
	<?php if(has_post_thumbnail()) { ?>
	<figure class="alignnone entry-thumb">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
	</figure>
	<?php } ?>
	<header class="entry-header">
		<?php // Hide meta info for pages.
		if ( 'post' == get_post_type() ) : ?>
		<div class="entry-icon visible-md visible-lg">
			<span class="date-lg"><?php the_time('j'); ?></span>
			<span class="date-sm"><?php the_time('M, Y'); ?></span>
			<i class="entypo text-doc"></i>
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
		<a href="<?php the_permalink() ?>" class="btn btn-secondary"><?php _e('Read More', 'petsitter'); ?></a>
	</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->