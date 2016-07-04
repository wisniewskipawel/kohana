<?php

/**
 * LinkedIn custom field for WP Job Manager
 *
 * @package PetSitter
 * @since   1.5.5
 */

// Adding Linkedin field to front-end
add_filter( 'submit_job_form_fields', 'frontend_add_linkedin_field' );

if( !function_exists( 'frontend_add_linkedin_field' ) ) {
	function frontend_add_linkedin_field( $fields ) {
	  $fields['company']['company_linkedin'] = array(
	    'label'       => __( 'LinkedIn Public Profile URL', 'petsitter' ),
	    'type'        => 'text',
	    'required'    => false,
	    'placeholder' => __( 'http://www.linkedin.com/...', 'petsitter' ),
	    'priority'    => 6
	  );
	  return $fields;
	}
}

add_action( 'job_manager_update_job_data', 'frontend_add_linkedin_field_save', 10, 2 );

if( !function_exists( 'frontend_add_linkedin_field_save' ) ) {
	function frontend_add_linkedin_field_save( $job_id, $values ) {
	  update_post_meta( $job_id, '_company_linkedin', $values['company']['company_linkedin'] );
	}
}


// Adding Linkedin field to backend
add_filter( 'job_manager_job_listing_data_fields', 'admin_add_linkedin_field' );

if( !function_exists( 'admin_add_linkedin_field' ) ) {
	function admin_add_linkedin_field( $fields ) {
	  $fields['_company_linkedin'] = array(
	    'label'       => __( 'LinkedIn Public Profile URL', 'petsitter' ),
	    'type'        => 'text',
	    'placeholder' => __( 'http://www.linkedin.com/...', 'petsitter' ),
	    'description' => __( 'Your Linkedin username here.', 'petsitter' )
	  );
	  return $fields;
	}
}