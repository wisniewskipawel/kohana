<?php
/**
 * content-quote.php
 *
 * The default template for displaying posts with the Quote post format.
 */

global $petsitter_data;

$post_class     = 'post__with-icon';

$quote_author = get_post_meta(get_the_ID(), 'petsitter_format_quote_author', true);
$quote_pos    = get_post_meta(get_the_ID(), 'petsitter_format_quote_pos', true);
$blog_date    = $petsitter_data['petsitter__post-date-icon'];

if ( $blog_date == 0) :
	$post_class     = 'post__without-icon';
endif;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>

	<header class="entry-header">
		<?php if ($blog_date == 1) : ?>
		<div class="entry-icon visible-md visible-lg">
			<span class="date-lg"><?php the_time('j'); ?></span>
			<span class="date-sm"><?php the_time('M, Y'); ?></span>
			<i class="entypo quote"></i>
		</div>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="quote-holder">
		<blockquote>
			<?php the_content(); ?>
		</blockquote>
		<cite><?php echo $quote_author; ?> <span><?php echo $quote_pos; ?></span></cite>
	</div>
</article><!-- #post-## -->