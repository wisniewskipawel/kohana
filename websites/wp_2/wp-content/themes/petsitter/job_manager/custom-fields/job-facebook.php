<?php

/**
 * Facebook custom field for WP Job Manager
 *
 * @package PetSitter
 * @since   1.5.5
 */

// Adding Facebook field to front-end
add_filter( 'submit_job_form_fields', 'frontend_add_facebook_field' );

if( !function_exists( 'frontend_add_facebook_field' ) ) {
	function frontend_add_facebook_field( $fields ) {
	  $fields['company']['company_facebook'] = array(
	    'label'       => __( 'Facebook username', 'petsitter' ),
	    'type'        => 'text',
	    'required'    => false,
	    'placeholder' => __( 'yourname', 'petsitter' ),
	    'priority'    => 6
	  );
	  return $fields;
	}
}

add_action( 'job_manager_update_job_data', 'frontend_add_facebook_field_save', 10, 2 );

if( !function_exists( 'frontend_add_facebook_field_save' ) ) {
	function frontend_add_facebook_field_save( $job_id, $values ) {
	  update_post_meta( $job_id, '_company_facebook', $values['company']['company_facebook'] );
	}
}


// Adding Facebook field to backend
add_filter( 'job_manager_job_listing_data_fields', 'admin_add_facebook_field' );

if( !function_exists( 'admin_add_facebook_field' ) ) {
	function admin_add_facebook_field( $fields ) {
	  $fields['_company_facebook'] = array(
	    'label'       => __( 'Facebook username', 'petsitter' ),
	    'type'        => 'text',
	    'placeholder' => __( 'yourname', 'petsitter' ),
	    'description' => __( 'Your Facebook username here.', 'petsitter' )
	  );
	  return $fields;
	}
}