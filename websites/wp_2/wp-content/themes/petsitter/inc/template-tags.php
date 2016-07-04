<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package PetSitter
 */

if ( ! function_exists( 'petsitter_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function petsitter_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'petsitter' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'petsitter' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'petsitter' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'petsitter_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function petsitter_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'petsitter' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'petsitter' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'petsitter' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


if ( ! function_exists( 'petsitter_posted_by' ) ) :
/**
 * Prints HTML with meta information for the current author.
 */
function petsitter_posted_by() {

	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {

		$byline = sprintf(
			'<span class="entry-author author vcard"><i class="fa fa-user"></i> <a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo $byline;

	}

}
endif;


if ( ! function_exists( 'petsitter_entry_comments' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function petsitter_entry_comments() {

	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {

		if ( ! is_single() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"><i class="fa fa-comments"></i> ';
			comments_popup_link( __( 'Leave a comment', 'petsitter' ), __( '1 Comment', 'petsitter' ), __( '% Comments', 'petsitter' ) );
			echo '</span>';
		}

	}

}
endif;


if ( ! function_exists( 'petsitter_entry_categories' ) ) :
/**
 * Prints HTML with meta information for the categories.
 */
function petsitter_entry_categories() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'petsitter' ) );
		if ( $categories_list && petsitter_categorized_blog() ) {
			printf( '<span class="cat-links"><i class="fa fa-folder"></i> ' . __( '%1$s', 'petsitter' ) . '</span>', $categories_list );
		}
	}
}
endif;


if ( ! function_exists( 'petsitter_entry_tags' ) ) :
/**
 * Prints HTML with meta information for the tags.
 */
function petsitter_entry_tags() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'petsitter' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><i class="fa fa-tags"></i> ' . __( '%1$s', 'petsitter' ) . '</span>', $tags_list );
		}
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function petsitter_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'petsitter_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'petsitter_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so petsitter_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so petsitter_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in petsitter_categorized_blog.
 */
function petsitter_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'petsitter_categories' );
}
add_action( 'edit_category', 'petsitter_category_transient_flusher' );
add_action( 'save_post',     'petsitter_category_transient_flusher' );