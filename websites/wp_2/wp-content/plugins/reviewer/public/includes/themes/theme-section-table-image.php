<?php 
if( isset( $review['review_use_featured_image'] ) ) {
	if ( $review['review_use_featured_image'] == 'no' ) {
		$image_url = ( isset( $review['review_image'] ) && !empty( $review['review_image'] ) ) ? $review['review_image'] : '';
	} else {
		if( has_post_thumbnail( $review['review_post_id'] ) ) {
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $review['review_post_id'] ), 'full' );
			$image_url = $thumb[0];
		} else {
			$image_url =  '';
		}
	}
} else {
	$image_url = ( isset( $review['review_image'] ) && !empty( $review['review_image'] ) ) ? $review['review_image'] : '';
}
?>
<?php if ( !empty( $image_url ) ): ?>
<div class="rwp-image" style="background-image: url(<?php echo $image_url ?>);">
</div><!-- /table image --> 
<?php endif ?>