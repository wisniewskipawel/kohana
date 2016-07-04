<?php

// ==== Post Format meta boxes ====================================== //


// === Define Metabox Fields ====================================== //

$prefix = 'petsitter_';
 
$meta_box_post_formats = array(
	'id' => 'petsitter-meta-box-post-formats',
	'title' =>  __('Post Formats Meta', 'petsitter'),
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			"name" => __('Gallery - Gallery IDs','petsitter'),
			"desc" => __('Enter the gallery IDs you created. Example: 9,21','petsitter'),
			"id"   => $prefix."format_gallery_id",
			"type" => "text",
			'std'  => ""
		),

		array(
			"name" => __('Quote - Author','petsitter'),
			"desc" => __('Enter quote auhthor name for Quote post format','petsitter'),
			"id"   => $prefix."format_quote_author",
			"type" => "text",
			'std'  => ""
		),

		array(
			"name" => __('Quote - Author Info','petsitter'),
			"desc" => __('Enter quote auhthor info (position) for Quote post format','petsitter'),
			"id"   => $prefix."format_quote_pos",
			"type" => "text",
			'std'  => ""
		),

		array(
			"name" => __('Link - URL','petsitter'),
			"desc" => __('URL for the link','petsitter'),
			"id"   => $prefix."format_link_url",
			"type" => "text",
			'std'  => ""
		)
	),
);

add_action('admin_menu', 'petsitter_add_box');


/*-----------------------------------------------------------------------------------*/
/*	Add metabox to edit page
/*-----------------------------------------------------------------------------------*/
 
function petsitter_add_box() {
	global $meta_box_post_formats;
 
	add_meta_box($meta_box_post_formats['id'], $meta_box_post_formats['title'], 'petsitter_show_box_quote', $meta_box_post_formats['page'], $meta_box_post_formats['context'], $meta_box_post_formats['priority']);
}


/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/

function petsitter_show_box_quote() {
	global $meta_box_post_formats, $post;

	// Use nonce for verification
	echo '<input type="hidden" name="petsitter_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo '<table class="form-table">';
 
	foreach ($meta_box_post_formats['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		switch ($field['type']) {
 			
 			//If Text		
			case 'text':
			
			echo '<tr>',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px; font-weight:400; font-size:13px;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';
			
			break;
			
			//If textarea		
			case 'textarea':
			
			echo '<tr>',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px; font-weight:400; font-size:13px;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<textarea name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES)), '" rows="8" cols="5" style="width:75%; margin-right: 20px; float:left;">', $meta ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES)), '</textarea>';
			
			break;

		}

	}
 
	echo '</table>';
}
 
add_action('save_post', 'petsitter_save_data');


/*-----------------------------------------------------------------------------------*/
/*	Save data when post is edited
/*-----------------------------------------------------------------------------------*/
 
function petsitter_save_data($post_id) {
	global $meta_box_post_formats;
 
	// verify nonce
	if ( !isset($_POST['petsitter_meta_box_nonce']) || !wp_verify_nonce( $_POST['petsitter_meta_box_nonce'], basename(__FILE__) )) {
		return $post_id;
	}
 
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
 
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
 
	foreach ($meta_box_post_formats['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
 
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}

}