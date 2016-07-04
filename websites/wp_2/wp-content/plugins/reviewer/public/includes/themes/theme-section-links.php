<?php $links = $this->review_field( 'review_custom_links' , true ); if ( !empty( $links ) ): ?>
<div class="rwp-custom-links">
<?php  
	$color 			= $this->template_field('template_text_color', true );
	$size 			= intval( $this->template_field('template_box_font_size', true) - 2 );
	$nofollow 		= $this->preferences_field( 'preferences_nofollow', true );
	$has_nofollow 	=  in_array('box_custom_links', $nofollow);		
?>
<?php foreach ($this->review_field( 'review_custom_links' , true ) as $link): ?>
	
	<a 	href="<?php echo $link['url'] ?>"
		style="color: <?php echo $color ?>;" 
		<?php 
		if( $has_nofollow ) {
			echo ' rel="nofollow" ';
		}
		?>

	><?php echo $link['label'] ?></a>

<?php endforeach ?>

</div> <!-- /custom-links -->
<?php endif ?>