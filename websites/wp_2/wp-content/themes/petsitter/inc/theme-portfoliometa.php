<?php
/*-----------------------------------------------------------------------------------*/
/*	Define Metabox Fields
/*-----------------------------------------------------------------------------------*/

$prefix = 'petsitter_';

$meta_box_portfolio = array(
	'id' => 'petsitter-meta-box-portfolio-video',
	'title' => __('Item Info', 'petsitter'),
	'page' => 'portfolio',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Short Info','petsitter'),
			'desc' => __('You can write a few words here.','petsitter'),
			'id' => $prefix.'short_info',
			'type' => 'text',
			'std' => ''
		),
		array(
			"name" => __('Gallery - Gallery IDs','petsitter'),
			"desc" => __('Enter the gallery IDs you created. Example: 9,21','petsitter'),
			"id"   => $prefix."format_gallery_id",
			"type" => "text",
			'std'  => ""
		),
	),
	
);

add_action('admin_menu', 'petsitter_add_box_portfolio');


/*-----------------------------------------------------------------------------------*/
/*	Add metabox to edit page
/*-----------------------------------------------------------------------------------*/
 
function petsitter_add_box_portfolio() {
	global $meta_box_portfolio;

	add_meta_box($meta_box_portfolio['id'], $meta_box_portfolio['title'], 'petsitter_show_box_portfolio_video', $meta_box_portfolio['page'], $meta_box_portfolio['context'], $meta_box_portfolio['priority']);
}


/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/

function petsitter_show_box_portfolio_video() {
	global $meta_box_portfolio, $post;
 	
	// Use nonce for verification
	echo '<input type="hidden" name="petsitter_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo '<table class="form-table">';
 
	foreach ($meta_box_portfolio['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		switch ($field['type']) {
 
			
			//If Text		
			case 'text':
			
			echo '<tr>',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="line-height:20px; display:block; color:#999; margin:5px 0 0 0; font-weight:400;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'" size="30" style="width:75%; margin-right: 20px; float:left;" />';
			
			break;
			
			//If textarea		
			case 'textarea':
			
			echo '<tr>',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="line-height:18px; display:block; color:#999; margin:5px 0 0 0;">'. $field['desc'].'</span></label></th>',
				'<td>';
			echo '<textarea name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" rows="8" cols="5" style="width:75%; margin-right: 20px; float:left;">', $meta ? $meta : $field['std'], '</textarea>';
			
			break;
			
			//If Select	
			case 'select':
			
				echo '<tr>',
				'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">'. $field['desc'].'</span></label></th>',
				'<td>';
			
				echo'<select id="' . $field['id'] . '" name="'.$field['id'].'">';
			
				foreach ($field['options'] as $option) {
					
					echo'<option';
					if ($meta == $option ) { 
						echo ' selected="selected"'; 
					}
					echo'>'. $option .'</option>';
				
				} 
				
				echo'</select>';
			
			break;

		}

	}
 
	echo '</table>';
}
 
add_action('save_post', 'petsitter_save_data_portfolio');


/*-----------------------------------------------------------------------------------*/
/*	Save data when post is edited
/*-----------------------------------------------------------------------------------*/
 
function petsitter_save_data_portfolio($post_id) {
	global $meta_box_portfolio;
 
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

	foreach ($meta_box_portfolio['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
 
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
	
}