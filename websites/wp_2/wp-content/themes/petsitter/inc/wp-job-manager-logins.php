<?php

/** For Job Manager **/
add_filter( 'submit_job_form_login_url', 'custom_submit_job_form_login_url' );

if(!function_exists('custom_submit_job_form_login_url')) { 
	function custom_submit_job_form_login_url() {
		global $petsitter_data;

		if(isset($petsitter_data['petsitter__job-manager-login-page'])) {
			return get_permalink($petsitter_data['petsitter__job-manager-login-page']);
		}
	}
}

/** For Job Manager Dashboard Pages **/
add_filter( 'job_manager_job_dashboard_login_url', 'wpjms_redirect_login_url' );

if(!function_exists('wpjms_redirect_login_url')) { 
	function wpjms_redirect_login_url() {
		global $petsitter_data;

		if(isset($petsitter_data['petsitter__job-manager-login-page'])) {
			return get_permalink($petsitter_data['petsitter__job-manager-login-page']);
		}
	}
}

/** For Resume Manager **/
add_filter( 'submit_resume_form_login_url', 'custom_submit_resume_form_login_url' );

if(!function_exists('custom_submit_resume_form_login_url')) { 
	function custom_submit_resume_form_login_url() {
		global $petsitter_data;

		if(isset($petsitter_data['petsitter__resume-manager-login-page'])) {
	  	return get_permalink($petsitter_data['petsitter__resume-manager-login-page']);
		}
	}
}

/** For Bookmarks Add-on **/
add_filter( 'job_manager_bookmark_form_login_url', 'bookmarks_redirect_login_url' );

if(!function_exists('bookmarks_redirect_login_url')) { 
	function bookmarks_redirect_login_url() {
		global $petsitter_data;

		if(isset($petsitter_data['petsitter__job-manager-login-page'])) {
			return get_permalink($petsitter_data['petsitter__job-manager-login-page']);
		}
	}
}

/** For Application Add-on **/
add_filter( 'job_manager_job_applications_login_required_message', 'application_redirect_login_url' );

if(!function_exists('application_redirect_login_url')) { 
	function application_redirect_login_url() {
		global $petsitter_data;

		if(isset($petsitter_data['petsitter__job-manager-login-page'])) {
			return get_permalink($petsitter_data['petsitter__job-manager-login-page']);
		}
	}
}