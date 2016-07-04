<?php

/**
 * Gallery custom field for WP Job Manager
 *
 * @package PetSitter
 * @since   1.4.0
 */

// Adding Gallery field to front-end
add_filter( 'submit_job_form_fields', 'frontend_add_gallery_field' );

if( !function_exists( 'frontend_add_gallery_field' ) ) {
	function frontend_add_gallery_field( $fields ) {
	  $fields['company']['company_gallery'] = array(
	    'label'       => __( 'Gallery Images', 'petsitter' ),
	    'type'        => 'file',
	    'required'    => false,
	    'placeholder' => '',
	    'multiple'    => true,
	    'priority'    => 7,
	    'ajax'        => true
	  );
	  return $fields;
	}
}

add_action( 'job_manager_update_job_data', 'frontend_add_gallery_field_save', 10, 2 );

if( !function_exists( 'frontend_add_gallery_field_save' ) ) {
	function frontend_add_gallery_field_save( $job_id, $values ) {
	  update_post_meta( $job_id, '_company_gallery', $values['company']['company_gallery'] );
	}
}


// Adding Gallery field to backend
add_filter( 'job_manager_job_listing_data_fields', 'admin_add_gallery_field' );

if( !function_exists( 'admin_add_gallery_field' ) ) {
	function admin_add_gallery_field( $fields ) {
	  $fields['_company_gallery'] = array(
	    'label'       => __( 'Gallery Images', 'petsitter' ),
	    'type'        => 'file',
	    'placeholder' => __( 'URL to your Image', 'petsitter' ),
	    'multiple'    => true,
	    'description' => __( 'To add multiple images click on \'Add file\' button', 'petsitter' )
	  );
	  return $fields;
	}
}


// Show Gallery Images
if ( !function_exists( 'display_job_gallery_data' ) && class_exists( 'WP_Job_Manager' )) {
	function display_job_gallery_data( $size = 'full', $default = null, $post = null ) {
	  global $post;

	  $gallery = get_post_meta( $post->ID, '_company_gallery', true );

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