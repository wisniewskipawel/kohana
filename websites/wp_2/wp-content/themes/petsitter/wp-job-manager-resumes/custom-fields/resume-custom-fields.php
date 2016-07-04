<?php

/**
 * Custom fields for Resume Manager
 *
 * @package PetSitter
 * @since   1.4.0
 */

// Adding Gallery field to front-end
add_filter( 'submit_resume_form_fields', 'frontend_add_gallery_field_resume' );

if( !function_exists( 'frontend_add_gallery_field_resume' ) ) {
	function frontend_add_gallery_field_resume( $fields ) {
	  $fields['resume_fields']['resume_gallery'] = array(
	    'label'       => __( 'Gallery Images', 'petsitter' ),
	    'type'        => 'file',
	    'required'    => false,
	    'placeholder' => '',
	    'multiple'    => true,
	    'priority'    => 6,
	    'ajax'        => true
	  );
	  return $fields;
	}
}

add_action( 'resume_manager_update_resume_data', 'frontend_add_gallery_field_save_resume', 10, 2 );

if( !function_exists( 'frontend_add_gallery_field_save_resume' ) ) {
	function frontend_add_gallery_field_save_resume( $resume_id, $values ) {
	  update_post_meta( $resume_id, '_resume_gallery', $values['resume_fields']['resume_gallery'] );
	}
}


// Adding Gallery field to backend
add_filter( 'resume_manager_resume_fields', 'admin_add_gallery_field_resume' );

if( !function_exists( 'admin_add_gallery_field_resume' ) ) {
	function admin_add_gallery_field_resume( $fields ) {
	  $fields['_resume_gallery'] = array(
	    'label'       => __( 'Gallery Images', 'petsitter' ),
	    'type'        => 'file',
	    'placeholder' => __( 'URL to your Image', 'petsitter' ),
	    'multiple'    => true,
	    'description' => ''
	  );
	  return $fields;
	}
}

// Show Gallery Images
if ( !function_exists( 'display_resume_gallery_data' ) && class_exists( 'WP_Resume_Manager' )) {
	function display_resume_gallery_data( $size = 'full', $default = null, $post = null ) {
	  global $post;

	  $gallery = get_post_meta( $post->ID, '_resume_gallery', true );

	  if ( $gallery ) {
		  foreach($gallery as $gallery) {

		  	$gallery_img_cropped = job_manager_get_resized_image( $gallery, $size );
		  	$gallery_img_full    = job_manager_get_resized_image( $gallery, 'full' );
		  	echo '<div class="gallery-img-holder">';
		  		echo '<figure class="alignleft gallery-item-thumb">';
		  			echo '<a href="' . $gallery_img_full . '" class="popup-link zoom">';
		  			echo '<img src="' . $gallery_img_cropped . '" alt="">';
		  			echo '</a>';
		  		echo '</figure>';
	  		echo '</div>';
		  }
		}
	}
}