<?php

/**
 * Google+ custom field for WP Job Manager
 *
 * @package PetSitter
 * @since   1.5.5
 */

// Adding Google+ field to front-end
add_filter( 'submit_job_form_fields', 'frontend_add_google_field' );

if( !function_exists( 'frontend_add_google_field' ) ) {
	function frontend_add_google_field( $fields ) {
	  $fields['company']['company_google'] = array(
	    'label'       => __( 'Google+ Account ID', 'petsitter' ),
	    'type'        => 'text',
	    'required'    => false,
	    'placeholder' => __( 'Account ID', 'petsitter' ),
	    'priority'    => 6
	  );
	  return $fields;
	}
}

add_action( 'job_manager_update_job_data', 'frontend_add_google_field_save', 10, 2 );

if( !function_exists( 'frontend_add_google_field_save' ) ) {
	function frontend_add_google_field_save( $job_id, $values ) {
	  update_post_meta( $job_id, '_company_google', $values['company']['company_google'] );
	}
}


// Adding Google+ field to backend
add_filter( 'job_manager_job_listing_data_fields', 'admin_add_google_field' );

if( !function_exists( 'admin_add_google_field' ) ) {
	function admin_add_google_field( $fields ) {
	  $fields['_company_google'] = array(
	    'label'       => __( 'Google+ Account ID', 'petsitter' ),
	    'type'        => 'text',
	    'placeholder' => __( 'Account ID', 'petsitter' ),
	    'description' => __( 'Your Google+ Account ID here.', 'petsitter' )
	  );
	  return $fields;
	}
}