<?php
/*-----------------------------------------------------------------------------------*/
/*	Accordion
/*-----------------------------------------------------------------------------------*/

if (!function_exists('accordion_shortcode')) {
	function accordion_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'type' => ''
		), $atts));

		if( isset($GLOBALS['collapsibles_count']) ) {
			$GLOBALS['collapsibles_count']++;
		} else {
			$GLOBALS['collapsibles_count'] = 0;
		}

		if($type == 'type2') {
			$type = 'panel-group__alt';
		}

		$output = '<div class="panel-group accordion '.$type.'" id="custom-collapse-'.$GLOBALS['collapsibles_count'].'">';
		$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
	}
	add_shortcode('accordion', 'accordion_shortcode');
}

if (!function_exists('panel_shortcode')) {
	function panel_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'title' => 'Title goes here',
				'state' => ''
		), $atts));

		$panel_title = '';

		if($state == 'open') {
			$state = 'in';
		}

		if($state == 'closed') {
			$panel_title = 'collapsed';
		}

		$id = rand();

		$output = '<div class="panel panel-default">';
			$output .= '<div class="panel-heading">';
				$output .= '<h4 class="panel-title">';
					$output .= '<a data-toggle="collapse" data-parent="#custom-collapse-'.$GLOBALS['collapsibles_count'].'" href="#'.$id.'-panel" class="panel-title '.$panel_title.'">';
						$output .= $title;
					$output .= '</a>';
				$output .= '</h4>';
			$output .= '</div>';

			$output .= '<div id="'.$id.'-panel" class="panel-collapse collapse '.$state.'">';
				$output .= '<div class="panel-body">';
					$output .= do_shortcode($content);
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;

	}
	add_shortcode('panel', 'panel_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Alerts
/*-----------------------------------------------------------------------------------*/

if (!function_exists('alert')) {
	function alert( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'type'   => 'danger'
	    ), $atts));
		
	   return '<div class="alert alert-'.$type.' fade in alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('alert', 'alert');
}





/*-----------------------------------------------------------------------------------*/
/*	Animation
/*-----------------------------------------------------------------------------------*/

if (!function_exists('animate_shortcode')) {
	function animate_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'animation' => '',
				'delay' => ''
		), $atts));

		$output = '<div data-animation="'.$animation.'" data-animation-delay="'.$delay.'">';
		$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
	}
	add_shortcode('animate', 'animate_shortcode');
}







/*-----------------------------------------------------------------------------------*/
/*	Buttons
/*-----------------------------------------------------------------------------------*/

if (!function_exists('button_shortcode')) {
	function button_shortcode($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'color' => 'default',
				'link' => '#',
				'text' => 'Button',
				'size' => 'normal',
				'target' => '_self',
				'icon' => 'none',
				'custom_class' => ''
	   ), $atts));
	    
		$output =  '<a href="'.$link.'" title="'.$text.'" class="btn btn-'.$size.' btn-'.$color.' '.$custom_class.'" target="'.$target.'">';
			if($icon !== 'none') {
				$output .= '<i class="fa '.$icon.'"></i>';
			}
			$output .= $text;
		$output .= '</a>';

	   return $output;

	}
	add_shortcode('button', 'button_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Call to Action
/*-----------------------------------------------------------------------------------*/

if (!function_exists('cta_shortcode')) {
	function cta_shortcode($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'title' => 'Title goes here',
				'subtitle' => 'Subtitle goes here',
				'btn_txt' => 'Click Here',
				'btn_url' => '',
			  'btn_class' => '',
			  'centered' => '',
			  'fullwidth' => 'no',
			  'custom_bg_url' => '',
			  'overlay' => 'no',
			  'overlay_opacity' => '50',
			  'overlay_color' => 'dark',
			   
		), $atts));

		$cta_bg  = '';

		if($custom_bg_url != '') {
			$cta_bg = 'style="background-image:url('.$custom_bg_url.');" data-stellar-background-ratio="0.5"';
		}

		if($overlay == 'yes') {
			$overlay = 'cta__overlay';
		}

		if($centered == 'yes') {
			$centered = 'centered';
		}

		if($fullwidth == 'yes') {
			$fullwidth = 'cta__fullwidth';
		}

		$output = '<div class="call-to-action '.$centered.' '.$fullwidth.' '.$overlay.' cta__overlay-opacity-'.$overlay_opacity.' cta-overlay-color__'.$overlay_color.'" '.$cta_bg.'>';
			$output .= '<div class="cta-inner">';
				$output .= '<div class="cta-txt">';
					$output .= '<h2>' . $title . '</h2>';
					$output .= '<p>' . $subtitle . '</p>';
				$output .= '</div>';
				$output .= '<div class="cta-btn">';
					$output .= '<a href="'.$btn_url.'" class="btn btn-'.$btn_class.'">';
								$output .= $btn_txt;
							$output .= '</a>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

	  return $output;

	}
	add_shortcode('cta', 'cta_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Column Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('grid_column')) {
	function grid_column($atts, $content=null, $shortcodename ="")
	{	
		extract(shortcode_atts(array(
			'class' => ''
		), $atts));

		// add divs to the content
		$return = '<div class="'.$shortcodename.' '.$class.'">';
		$return .= do_shortcode($content);
		$return .= '</div>';

		return $return;
	}
	add_shortcode('col-md-1', 'grid_column');
	add_shortcode('col-md-2', 'grid_column');
	add_shortcode('col-md-3', 'grid_column');
	add_shortcode('col-md-4', 'grid_column');
	add_shortcode('col-md-5', 'grid_column');
	add_shortcode('col-md-6', 'grid_column');
	add_shortcode('col-md-7', 'grid_column');
	add_shortcode('col-md-8', 'grid_column');
	add_shortcode('col-md-9', 'grid_column');
	add_shortcode('col-md-10', 'grid_column');
	add_shortcode('col-md-11', 'grid_column');
	add_shortcode('col-md-12', 'grid_column');
}

// Row
if (!function_exists('shortcode_row')) {
	function shortcode_row($atts, $content = null ) {
		return '<div class="row">'.do_shortcode($content).'</div>';
	}

	add_shortcode('row', 'shortcode_row');
}

if (!function_exists('shortcode_row_inner')) {
	function shortcode_row_inner($atts, $content = null ) {
		return '<div class="row">'.do_shortcode($content).'</div>';
	}

	add_shortcode('row_inner', 'shortcode_row_inner');
}

// Clear
if (!function_exists('shortcode_clear')) {
	function shortcode_clear() {
		return '<div class="clearfix"></div>';
	}

	add_shortcode('clear', 'shortcode_clear');
}





/*-----------------------------------------------------------------------------------*/
/*	Font Awesome Shortcodes
/*-----------------------------------------------------------------------------------*/
function dfFontAwesome($atts) {
	extract(shortcode_atts(array(
		'type'  => '',
		'size' => '',
		'class' => '',

	), $atts));

	$classes  = ($type) ? $type. ' ' : 'fa-star';
	$classes .= ($size) ? $size.' ' : '';
	$classes .= ($class) ? ' '.$class : '';

	$theAwesomeFont = '<i class="fa '.esc_html($classes).'"></i>';

	return $theAwesomeFont;
}
  
add_shortcode('icon', 'dfFontAwesome');




/*-----------------------------------------------------------------------------------*/
/*	Entypo Shortcodes
/*-----------------------------------------------------------------------------------*/
function entypoFont($atts) {
	extract(shortcode_atts(array(
		'type'  => '',
		'class' => ''

	), $atts));

	$classes  = ($type) ? $type. ' ' : 'star';
	$classes .= ($class) ? ' '.$class : '';

	$theEntypoFont = '<i class="entypo '.esc_html($classes).'"></i>';

	return $theEntypoFont;
}
  
add_shortcode('entypo_icon', 'entypoFont');





/*-----------------------------------------------------------------------------------*/
/*	Icobox
/*-----------------------------------------------------------------------------------*/
if (!function_exists('icobox_shortcode')) {
	function icobox_shortcode($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'shape' => '',
				'color' => '',
				'centered' => '',
				'animated' => '',
				'inverse' => '',
				'halffill' => '',
				'size' => '',
				'icon' => '',
				'title' => '',
				'url' => '',
				'desc' => ''
	   ), $atts));

		if($centered == 'yes') {
			$centered = 'centered';
		}

		if($animated == 'yes') {
			$animated = 'icon-box-animated';
		}

		if($inverse == 'yes') {
			$inverse = 'icon-box-animated-inverse';
		}

		if($halffill == 'yes') {
			$halffill = 'filled';
		}


		if(substr($icon, 0, 2) == "fa") {
			$icon = 'fa '.$icon;
		} else {
			$icon = 'entypo '.$icon;
		}


		$output = '<div class="icon-box icon-box__color-'.$color.' '.$inverse.' '.$size.' '.$halffill.' '.$shape.' '.$centered.' '.$animated.'">';
			$output .= '<div class="icon">';
				if($url != '') {
					$output .= '<a href="'.$url.'">';
						$output .= '<i class="'.$icon.'"></i>';
					$output .= '</a>';
				} else {
					$output .= '<i class="'.$icon.'"></i>';
				}
			$output .= '</div>';
			$output .= '<div class="icon-box-body">';
				if($title != '') {
					if($url != '') {
						$output .= '<h4><a href="'.$url.'">';
							$output .= $title;
						$output .= '</a></h4>';
					} else {
						$output .= '<h4>';
							$output .= $title;
						$output .= '</h4>';
					}
				}
				$output .= $desc;
			$output .= '</div>';
			$output .= '<div class="clearfix"></div>';
		$output .= '</div>';

	  return $output;

	}
	add_shortcode('icobox', 'icobox_shortcode');
}






/*-----------------------------------------------------------------------------------*/
/*	Partners
/*-----------------------------------------------------------------------------------*/

if (!function_exists('partners_shortcode')) {
	function partners_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'cols' => ''
		), $atts));

		//Create unique ID for this carousel
		$unique_id = rand();

		$output = '<div class="partners-list partners-list__cols'.$cols.'">';
			$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
	}
	add_shortcode('partners', 'partners_shortcode');
}


if (!function_exists('img_item_shortcode')) {
	function img_item_shortcode($atts, $content = null) {

		$output = '<div class="partners-item hovered-img">';
			$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
	}
	add_shortcode('img_item', 'img_item_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Pricing Tables
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pricing_shortcode')) {
	function pricing_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'name' => '',
				'price' => '0',
				'currency' => '$',
				'price_txt' => 'per month',
				'link_txt' => 'Sign Up',
				'link_url' => '#',
				'active' => '',
				'type' => ''
		), $atts));

		$btn_class = '';

		if($active == "yes") {
			$active = "popular";
		}

		if($type == 'style1') {
			if($active == 'popular') {
				$btn_class = 'btn-primary';
			} else {
				$btn_class = 'btn-default';
			}
		} elseif ($type == 'style2') {
			if($active == 'popular') {
				$btn_class = 'btn-primary';
			} else {
				$btn_class = 'btn-default';
			}
		} elseif ($type == 'style3') {
			if($active == 'popular') {
				$btn_class = 'btn-default';
			} else {
				$btn_class = 'btn-default';
			}
		} else {
			if($active == 'popular') {
				$btn_class = 'btn-default';
			} else {
				$btn_class = 'btn-default';
			}
		}

		$output = '<div class="pricing-table pricing-table__'.$type.' '.$active.'">';
			$output .= '<header class="pricing-head">';

				if( $type == 'style2') {

					$output .= '<div class="circled">';
						$output .= '<div class="circled-inner">';
							$output .= '<span class="price"><sup>'.$currency.'</sup> '.$price.'</span>';
							if( $price_txt != "") {
								$output .= '<small>'.$price_txt.'</small>';
							}
						$output .= '</div>';
					$output .= '</div>';
					$output .= '<h3>'.$name.'</h3>';

				} elseif ( $type == 'style3') {

					$output .= '<div class="circled">';
						$output .= '<div class="circled-inner">';
							$output .= '<span class="price"><sup>'.$currency.'</sup> '.$price.'</span>';
							if( $price_txt != "") {
								$output .= '<small>'.$price_txt.'</small>';
							}
						$output .= '</div>';
					$output .= '</div>';
					$output .= '<h3>'.$name.'</h3>';
					
				} elseif ( $type == 'style4') {
					$output .= '<h3>'.$name.'</h3>';
					$output .= '<div class="pricing-head-inner">';
						$output .= '<span class="price"><sup>'.$currency.'</sup> '.$price.'</span>';
						if( $price_txt != "") {
							$output .= '<small>'.$price_txt.'</small>';
						}
					$output .= '</div>';
				} else {

					$output .= '<h3>'.$name.'</h3>';
					$output .= '<span class="price">';
						$output .= '<sup>';
						$output .= $currency;
						$output .= '</sup>';
						$output .= $price;
					$output .= '</span>';

				}
				
			$output .= '</header>';

			$output .= '<div class="pricing-body">';
				$output .= do_shortcode($content);
			$output .= '</div>';

			$output .= '<footer class="pricing-footer">';

				$output .= '<a class="btn '.$btn_class.'" href="'.$link_url.'">';
					$output .= $link_txt;
				$output .= '</a>';
				
			$output .= '</footer>';
		$output .= '</div>';

		return $output;

	}
	add_shortcode('pricing_table', 'pricing_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Data Table
/*-----------------------------------------------------------------------------------*/
function simple_table( $atts ) {
	extract( shortcode_atts( array(
		'class' => '',
		'cols' => '',
		'data' => '',
    ), $atts ) );
    $cols = explode(',',$cols);
    $data = explode(',',$data);
    $total = count($cols);
    $output = '<div class="table-responsive"><table class="table '.$class.'"><thead><tr>';
    foreach($cols as $col):
        $output .= '<td>'.$col.'</td>';
    endforeach;
    $output .= '</tr></thead><tbody><tr>';
    $counter = 1;
    foreach($data as $datum):
        $output .= '<td>'.$datum.'</td>';
        if($counter%$total==0):
            $output .= '</tr>';
        endif;
        $counter++;
    endforeach;
        $output .= '</tbody></table></div>';
    return $output;
}
add_shortcode( 'table', 'simple_table' );






/*-----------------------------------------------------------------------------------*/
/*	Progress Bar
/*-----------------------------------------------------------------------------------*/

if (!function_exists('bar_shortcode')) {
	function bar_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'progress'  => '30',
				'type'      => '',
				'label'     => '',
				'color'     => '',
				'label_pos' => ''
		), $atts));

		if($type == 'striped') {
			$type = 'progress-striped';
		} elseif($type == 'animated') {
			$type = 'progress-striped active';
		}

		$output = '<div class="progress '.$type.'">';
			$output .= '<div class="progress-bar progress-bar-'.$color.'" role="progressbar" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$progress.'%;">';
				if ( $label_pos != 'outside' ) {
					$output .= '<span class="progress-label">'.$label.'</span>';
					$output .= $progress.'%';
				}
			$output .= '</div>';
		$output .= '</div>';
		if ( $label_pos == 'outside' ) {
			$output .= '<div class="progress-outside-labels clearfix">';
				$output .= '<span class="pull-left">'.$label.'</span>';
				$output .= '<span class="pull-right">' . $progress . '%</span>';
			$output .= '</div>';
		}

		return $output;
	}
	add_shortcode('progress', 'bar_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Team member
/*-----------------------------------------------------------------------------------*/
if (!function_exists('member_shortcode')) {
	function member_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'name' => '',
				'img_url' => '',
				'page_url' => '',
				'position' => '',
				'facebook' => '',
				'twitter' => '',
				'google' => '',
				'linkedin' => '',
				'mail' => ''
		), $atts));

		$output = '<div class="team-item">';
			$output .= '<div class="team-item-inner">';
				$output .= '<figure class="team-thumb">';

					if($img_url != '' ) {
						$output .= '<img src="'.$img_url.'" alt="">';
					} else {
						$output .= '<img src="'.get_template_directory_uri().'/images/user-placeholder.gif" alt="" class="empty-thumb">';
					}

					$output .= '<div class="overlay"></div>';

					$output .= '<ul class="team-social list-unstyled">';
						if($facebook != '') {
							$output .= '<li>';
								$output .= '<a href="'.$facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';
							$output .= '</li>';
						}
						if($twitter != '') {
							$output .= '<li>';
								$output .= '<a href="'.$twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>';
							$output .= '</li>';
						}
						if($google != '') {
							$output .= '<li>';
								$output .= '<a href="'.$google.'" target="_blank"><i class="fa fa-google-plus"></i></a>';
							$output .= '</li>';
						}
						if($linkedin != '') {
							$output .= '<li>';
								$output .= '<a href="'.$linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a>';
							$output .= '</li>';
						}
						if($mail != '') {
							$output .= '<li>';
								$output .= '<a href="mailto:'.$mail.'"><i class="fa fa-envelope"></i></a>';
							$output .= '</li>';
						}
					$output .= '</ul>';
				$output .= '</figure>';

				$output .= '<header class="team-head">';
					if($page_url != '') {
						$output .= '<h5 class="team-name"><a href="'.$page_url.'">'.$name.'</a></h5>';
					} else {
						$output .= '<h5 class="team-name">'.$name.'</h5>';
					}
					$output .= '<span class="team-head-info">'.$position.'</span>';
				$output .= '</header>';
				$output .= '<div class="team-excerpt">';
					$output .= do_shortcode($content);
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode('member', 'member_shortcode');
}






/*-----------------------------------------------------------------------------------*/
/*	Testimonial
/*-----------------------------------------------------------------------------------*/
if (!function_exists('testi_shortcode')) {
	function testi_shortcode($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'color'    => '',
				'img_url'  => '',
				'img_pos'  => '',
				'name'     => '',
				'info'     => ''
	   ), $atts));
	    
		$output =  '<div class="testimonial testimonial-color__'.$color.' testimonial-img-position__'.$img_pos.'">';
			$output .= '<div class="testi-body">';
				$output .= '<blockquote>';
					$output .= do_shortcode($content);
				$output .= '</blockquote>';
			$output .= '</div>';
			$output .= '<div class="bq-author">';
				if($img_pos == 'left') {
					$output .= '<figure class="author-img">';
						$output .= '<img src="'.$img_url.'" alt="">';
					$output .= '</figure>';
				}
				$output .= '<h6>';
					$output .= $name;
				$output .= '</h6>';
				$output .= '<span class="bq-author-info">';
					$output .= $info;
				$output .= '</span>';
			$output .= '</div>';
		$output .= '</div>';

	   return $output;

	}
	add_shortcode('testimonial', 'testi_shortcode');
}






/*-----------------------------------------------------------------------------------*/
/*	Horizontal Rules
/*-----------------------------------------------------------------------------------*/

if (!function_exists('hr_shortcode')) {
	function hr_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'type'     => 'solid',
			'margin'   => 'default'
	    ), $atts));

		return '<hr class="hr-'.$type.' '.$margin.'">';
		
	}
	add_shortcode('hr', 'hr_shortcode');
}




/*-----------------------------------------------------------------------------------*/
/*	Spacer
/*-----------------------------------------------------------------------------------*/

if (!function_exists('spacer_shortcode')) {
	function spacer_shortcode($atts, $content = null) {
		extract(shortcode_atts(array(
			'size'   => 'default',
			'class'   => ''
	    ), $atts));

		$output = '<div class="spacer spacer-'.$size.' '.$class.'"></div>';
		return $output;
	}
	add_shortcode('spacer', 'spacer_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Tabs Shortcodes
/*-----------------------------------------------------------------------------------*/

$tabs_divs = '';

function tabs_group($atts, $content = null ) {
    global $tabs_divs;

    $tabs_divs = '';

    $output = '<div class="tabs"><ul class="nav nav-tabs">';
    $output.= do_shortcode($content);
    $output.= '</ul><div class="tab-content">'.$tabs_divs.'</div></div>';

    return $output;  
} 
add_shortcode('tab', 'tab');

function tab($atts, $content = null) {  
    global $tabs_divs;

    extract(shortcode_atts(array(  
        'id'    => '',
        'title' => '',
        'state' => '',
        'icon'  => ''
    ), $atts));  

    if(empty($id)) {
    	$id = 'side-tab'.rand(100,999);
    }


    if ($icon != "") {
  		if(substr($icon, 0, 2) == "fa") {
				$icon = '<i class="fa '.$icon.'"></i> ';
			} else {
				$icon = '<i class="entypo '.$icon.'"></i> ';
			}
  	}
    

    $state_link = '';
    if($state == 'open') {
    	$state = 'in active';
    	$state_link = 'active';
    }

    $output = '<li class="'.$state_link.'">';
      $output .= '<a href="#'.$id.'" data-toggle="tab">';
      	$output .= $icon;
      	$output .= $title;
      $output .= '</a>';
    $output .= '</li>';

    $tabs_divs .= '<div id="'.$id.'" class="tab-pane fade '.$state.'">';
    	$tabs_divs .= do_shortcode($content);
    $tabs_divs .= '</div>';

    return $output;
}
add_shortcode('tabs', 'tabs_group');







/*-----------------------------------------------------------------------------------*/
/*	Typograpy
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	List Styles
/*-----------------------------------------------------------------------------------*/

if (!function_exists('list_shortcode')) {
	function list_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'type'   => '',
			'color'   => ''
	    ), $atts));

		return '<div class="list list__'.$type.' list-color__'.$color.'">' . do_shortcode($content) . '</div>';
	  
	}
	add_shortcode('list', 'list_shortcode');
}


/*-----------------------------------------------------------------------------------*/
/*	Dropcaps
/*-----------------------------------------------------------------------------------*/

if (!function_exists('dropcap_shortcode')) {
	function dropcap_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'type' => ''
		), $atts));

		$output = '<span class="dropcap dropcap__'.$type.'">';
		$output .= do_shortcode($content);
		$output .= '</span>';

		return $output;
	}
	add_shortcode('dropcap', 'dropcap_shortcode');
}


/*-----------------------------------------------------------------------------------*/
/*	Blockquote
/*-----------------------------------------------------------------------------------*/

if (!function_exists('blockquote_shortcode')) {
	function blockquote_shortcode($atts, $content = null) {

		$output = '<blockquote>';
		$output .= do_shortcode($content);
		$output .= '</blockquote><!-- blockquote (end) -->';

		return $output;
	}
	add_shortcode('blockquote', 'blockquote_shortcode');
}


/*-----------------------------------------------------------------------------------*/
/*	Pullquote
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pullquote_shortcode')) {
	function pullquote_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'align' => 'left'
		), $atts));

		$output = '<div class="pullquote '.$align.'">';
			$output .= '<blockquote>';
			$output .= do_shortcode($content);
			$output .= '</blockquote>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode('pullquote', 'pullquote_shortcode');
}


/*-----------------------------------------------------------------------------------*/
/*	Title
/*-----------------------------------------------------------------------------------*/
if (!function_exists('title_shortcode')) {
	function title_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'type' => '',
				'subtitle' => ''
		), $atts));

		if ($type == 'bordered') {
			$type = 'title-bordered';
		} else {
			$type = 'with-subtitle';
		}

		$output = '<div class="'.$type.'">';
			$output .= '<div class="title-inner">';
				$output .= '<h2>';
					$output .= do_shortcode($content);
					if($subtitle != "") {
						$output .= '<small>'.$subtitle.'</small>';
					}
				$output .= '</h2>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode('title', 'title_shortcode');
}



/*-----------------------------------------------------------------------------------*/
/*	Box
/*-----------------------------------------------------------------------------------*/
if (!function_exists('box_shortcode')) {
	function box_shortcode($atts, $content = null) {

		$output = '<div class="well">';
		$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
	}

	add_shortcode('box', 'box_shortcode');
}


/*-----------------------------------------------------------------------------------*/
/*	Section
/*-----------------------------------------------------------------------------------*/
if (!function_exists('section_shortcode')) {
	function section_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'type'  => 'section',
				'bg_url' => '',
				'class' => '',
				'overlay' => 'no',
				'overlay_opacity' => '50',
				'overlay_color' => 'dark'
		), $atts));

		if ($type == 'section1') {
			$type = 'section-light';
		} else {
			$type = 'section';
		}

		$section_bg = "";
		if($bg_url != '') {
			$section_bg = 'style="background-image:url('.$bg_url.'); background-repeat: no-repeat; background-position: 50% 0; background-attachment: fixed; background-size: cover;" data-stellar-background-ratio="0.5"';
		}

		$output = '<div class="'.$type.' '.$class.' section-overlay__'.$overlay.' section-overlay-color__'.$overlay_color.' section-overlay_opacity-'.$overlay_opacity.'" '.$section_bg.'>';
			$output .= '<div class="section-inner">';
				$output .= do_shortcode($content);
			$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	add_shortcode('section', 'section_shortcode');
}



/*-----------------------------------------------------------------------------------*/
/*	Image Raw
/*-----------------------------------------------------------------------------------*/

if (!function_exists('image_raw')) {
	function image_raw( $atts, $content = null ) {

	   return '<div class="img-raw">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('img_raw', 'image_raw');
}


/*-----------------------------------------------------------------------------------*/
/*	Image Box
/*-----------------------------------------------------------------------------------*/

if (!function_exists('img_box')) {
	function img_box( $atts, $content = null ) {

	   return '<div class="img-box">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('img_box', 'img_box');
}


/*-----------------------------------------------------------------------------------*/
/*	Resume Summary
/*-----------------------------------------------------------------------------------*/
if (!function_exists('resume_summary')) {
	function resume_summary($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'id'    => '',
				'width' => '100%',
				'align' => 'left'
		), $atts));

		if ( ! $id ) {
			return;
		}

		// Check if Resume Manager is installed
		if (class_exists( 'WP_Resume_Manager' )) :

		ob_start();

		$args = array(
			'post_type'   => 'resume',
			'post_status' => 'publish',
			'p'           => $id
		);

		$resumes = new WP_Query( $args );

		if ( $resumes->have_posts() ) : ?>

			<?php while ( $resumes->have_posts() ) : $resumes->the_post(); ?>

				<div class="resume_summary_shortcode align<?php echo $align ?>" style="width: <?php echo $width ? $width : auto; ?>">

					<a href="<?php the_permalink(); ?>"><?php the_candidate_photo( 'portfolio-n' ); ?></a>

					<div class="resume_summary_content-holder">
						<div class="resume_summary_content">
						
							<h5 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
							<h6 class="resume_summary_title"><a href="<?php the_permalink(); ?>"><?php the_candidate_title(); ?></a></h6>
						</div>
						
						<footer class="resume_summary_footer">
							<ul class="meta">
								<?php if ( get_the_resume_category() ) : ?>
								<li class="category"><?php the_resume_category(); ?></li>
								<?php endif; ?>
								<li class="location"><?php the_candidate_location( false ); ?></li>
								<li class="date"><?php printf( __( 'Posted %s ago', 'petsitter' ), human_time_diff( get_post_time( 'U' ), current_time( 'timestamp' ) ) ); ?></li>
							</ul>
						</footer>
					</div>

				</div>

			<?php endwhile; ?>

		<?php endif;

		wp_reset_postdata();

		return ob_get_clean();

		endif;
	}

	add_shortcode('resume_summary', 'resume_summary');
}



/*-----------------------------------------------------------------------------------*/
/* Resumes/Jobs Slider
/*-----------------------------------------------------------------------------------*/

if (!function_exists('summaries_shortcode')) {
	function summaries_shortcode($atts, $content = null) {

		//Create unique ID for this carousel
		$unique_id = rand();

		$output = '<div class="owl-carousel owl-theme owl-featured-listings">';
			$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
	}
	add_shortcode('summaries', 'summaries_shortcode');
}


if (!function_exists('single_summary_shortcode')) {
	function single_summary_shortcode($atts, $content = null) {

		$output = '<div class="listing-box">';
			$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
	}
	add_shortcode('summary', 'single_summary_shortcode');
}



/*-----------------------------------------------------------------------------------*/
/*	Blog Posts (Recent Posts)
/*  @since 1.1.0
/*-----------------------------------------------------------------------------------*/

if (!function_exists('shortcode_posts')) {
	
	function shortcode_posts($atts, $content = null) {
		
		extract(shortcode_atts(array(										 
			'num' => '3',
			'words_num' => '15',
			'img_size' => 'small',
			'orient' => 'vertical',
			'cols' => '3cols',
			'link_txt' => 'Read More',
			'link_style' => 'secondary'
		), $atts));

		$col_class = 'col-md-4';

		if($orient == 'horizontal') {
			$orient = 'posts-list__horizontal';

			if ($cols == '2cols') {
				$col_class = 'col-md-6';
			} elseif ( $cols == '4cols') {
				$col_class = 'col-md-3';
			} elseif ( $cols == '3cols') {
				$col_class = 'col-md-4 col-sm-4';
			}

		} else {
			$orient = 'posts-list__vertical';
			$col_class = 'col-md-12';
		}

		$output = '<div class="row posts-list">';

		global $post;
		global $petsitter_string_limit_words;
		
		$args = array(
			'post_type' => 'post',
			'numberposts' => $num,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'suppress_filters' => 0
		);

		$latest = get_posts($args);
		
		foreach($latest as $k => $post) {
			// Unset not translated posts
			if ( function_exists( 'wpml_get_language_information' ) ) {
				global $sitepress;
				$check = wpml_get_language_information( $post->ID );
				$language_code = substr( $check['locale'], 0, 2 );
				if ( $language_code != $sitepress->get_current_language() ) unset( $latest[$k] );

				// Post ID is different in a second language Solution
				if ( function_exists( 'icl_object_id' ) ) $post = get_post( icl_object_id( $post->ID, 'post', true ) );
				}

				setup_postdata($post);
				$excerpt = get_the_excerpt();

				$output .= '<div class="'.$col_class.' item">';


				if ( has_post_thumbnail($post->ID) ){
					$thumb = get_post_thumbnail_id();
					$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
					$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $img_size);
					$output .= '<figure class="entry-thumb thumb__rollover"><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
					$output .= '<img src="'.$image[0].'" alt="" class="alignnone">';
					$output .= '</a></figure>';
				}
				$output .= '<span class="date">';
					$output .= get_the_time(get_option('date_format'));
				$output .= '</span>';
				$output .= '<h5 class="post-title"><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
						$output .= get_the_title($post->ID);
				$output .= '</a></h3>';

				$output .= '<div class="post-excerpt">';
					$output .= '<p>';
						$output .= petsitter_string_limit_words($excerpt,$words_num);
					$output .= '</p>';
				$output .= '</div>';

				$output .= '<footer class="post-footer">';
					$output .= '<a href="'.get_permalink($post->ID).'" class="btn btn-'.$link_style.'">';
						$output .= $link_txt . '<i class="fa fa-arrow-circle-o-right fa-right"></i>';
					$output .= '</a>';
				$output .= '</footer>';
				
			$output .= '</div>';
				
		}
				
		$output .= '</div>';
		wp_reset_query();
		return $output;
		
	}

	add_shortcode('posts', 'shortcode_posts');
}




/*-----------------------------------------------------------------------------------*/
/*	Portfolio
/*  @since 1.1.0
/*-----------------------------------------------------------------------------------*/

if (!function_exists('shortcode_portfolio')) {
	function shortcode_portfolio($atts, $content = null) {
			
			extract(shortcode_atts(array(
					'cat_slug' => '',
					'cols' => '4',							 
					'num' => '4'
			), $atts));


			$thumb_size = '';
			$item       = '';

			if($cols == 2) {
				$cols = "project-feed__2cols";
				$thumb_size = "portfolio-lg";
				$item       = "col-sm-6 col-md-6";
			} elseif($cols == 4) {
				$cols = "project-feed__4cols";
				$thumb_size = "portfolio-n";
				$item       = "col-sm-6 col-md-3";
			} else{
				$cols = "project-feed__3cols";
				$thumb_size = "portfolio-n";
				$item       = "col-sm-6 col-md-4";
			}

			$output = '<div class="project-feed row">';

			global $post;
			
			$args = array(
				'post_type' => 'portfolio',
				'numberposts' => $num,
				'orderby' => 'date',
				'portfolio_category' => $cat_slug,
				'order' => 'DESC',
				'suppress_filters' => 0
			);

			$latest = get_posts($args);
			
			foreach($latest as $k => $post) {
				// Unset not translated posts
				if ( function_exists( 'wpml_get_language_information' ) ) {
					global $sitepress;
					$check = wpml_get_language_information( $post->ID );
					$language_code = substr( $check['locale'], 0, 2 );
					if ( $language_code != $sitepress->get_current_language() ) unset( $latest[$k] );

					// Post ID is different in a second language Solution
					if ( function_exists( 'icl_object_id' ) ) $post = get_post( icl_object_id( $post->ID, 'portfolio', true ) );
					}

					setup_postdata($post);

					$thumb   = get_post_thumbnail_id();
					$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
					$short_info = get_post_meta(get_the_ID(), 'petsitter_short_info', true);

					$output .= '<div class="project-item '.$item.'">';
						$output .= '<div class="project-item-inner">';

							if ( has_post_thumbnail($post->ID) ){
								$output .= '<figure class="alignnone project-img">';
									$output .= get_the_post_thumbnail($post->ID, $thumb_size);

									$output .= '<div class="overlay">';
										$output .= '<a href="'.get_permalink($post->ID).'" class="dlink"><i class="fa fa-link"></i></a>';
										$output .= '<a href="'.$img_url.'" class="popup-link zoom"><i class="fa fa-search"></i></a>';
									$output .= '</div>';
								$output .= '</figure>';
							}

							$output .= '<div class="project-desc">';
								$output .= '<h4 class="title"><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
										$output .= get_the_title($post->ID);
								$output .= '</a></h4>';

								$output .= '<span class="desc">';
									if( $short_info != "") {
										$output .= $short_info;
									} else {
										$output .= get_the_time(get_option('date_format'));
									}
								$output .= '</span>';

							$output .= '</div>';

						$output .= '</div>';
					$output .= '</div>';
					
			}
					
			$output .= '</div>';
			wp_reset_query();
			return $output;
			
	}

	add_shortcode('portfolio', 'shortcode_portfolio');
}




/*-----------------------------------------------------------------------------------*/
/*	Counter
/*  @since 1.1.0
/*-----------------------------------------------------------------------------------*/
if (!function_exists('counter')) {
	function counter($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'type' => 'default',
				'num' => '100',
				'icon' => 'fa-task',
				'icon_color' => 'dark'
	   ), $atts));

		$output =  '<div class="counter-holder counter-'.$icon_color.'">';
			$output .= '<i class="fa fa-3x '.$icon.'"></i>';
			$output .= '<span class="counter-wrap">';
				$output .= '<span class="counter" data-to="'.$num.'" data-speed="1500" data-refresh-interval="50">0</span>';
			$output .= '</span>';
			$output .= '<div class="counter-info"><div class="counter-info-inner">';
				$output .= do_shortcode($content);
			$output .= '</div></div>';
		$output .= '</div>';

	  return $output;

	}
	add_shortcode('counter', 'counter');
}




/*-----------------------------------------------------------------------------------*/
/*	Circular Bar
/*  @since 1.1.0
/*-----------------------------------------------------------------------------------*/
if (!function_exists('circular_bar')) {
	function circular_bar($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'dimension' => '190',
				'text'      => '32%',
				'info'      => 'Your info',
				'width'     => '8',
				'fontsize'  => '28',
				'percent'   => '32',
				'fgcolor'   => '#a6ce39',
				// 'bgcolor'   => '#eee',
				'icon'      => 'fa-task'
	   ), $atts));

		$unique_id = rand();

		$output =  '<div id="circled-counter__'.$unique_id.'" class="circled-counter" ';
			$output .= 'data-dimension="'.$dimension.'" ';
			$output .= 'data-text="'.$text.'" ';
			$output .= 'data-info="'.$info.'" ';
			$output .= 'data-width="'.$width.'" ';
			$output .= 'data-fontsize="'.$fontsize.'" ';
			$output .= 'data-percent="'.$percent.'" ';
			$output .= 'data-fgcolor="'.$fgcolor.'" ';
			// $output .= 'data-bgcolor="'.$bgcolor.'" ';
			$output .= 'data-bgcolor="rgba(0,0,0,.05)" ';
			$output .= 'data-icon="'.$icon.'">';
		$output .= '</div>';

	  return $output;

	}
	add_shortcode('circular_bar', 'circular_bar');
}




/*-----------------------------------------------------------------------------------*/
/*	Jobs Counter
/*  @since 1.1.0
/*-----------------------------------------------------------------------------------*/
if (!function_exists('counter_stats')) {
	function counter_stats( $atts, $content ) {
		extract(shortcode_atts(
			array(
				'stat' => '',
				'icon' => 'fa-task',
				'icon_color' => 'dark',
				'title' => 'Your Title',
	  	), $atts));

		global $wpdb;

		if ( class_exists( 'WP_Job_Manager' ) ) {
			if ( $stat == 'jobs') {

				$stat = wp_count_posts( 'job_listing' )->publish;

			} elseif ( $stat == 'jobs_filled') {

				$stat = $wpdb->get_var(
					"SELECT COUNT(*)
					FROM $wpdb->postmeta
					WHERE meta_key = '_filled'
					AND meta_value = '1'"
				);

			} elseif ( $stat == 'resumes') {

				if ( class_exists( 'WP_Resume_Manager' ) ) {
					$stat = wp_count_posts( 'resume' )->publish;
				} else {
					$stat = 0;
				}

			} elseif ( $stat == 'users') {
				
				$users = count_users();
				$stat  = $users[ 'total_users' ];

			}
		}

		$output =  '<div class="counter-holder counter-'.$icon_color.'">';
			$output .= '<i class="fa fa-3x '.$icon.'"></i>';
			$output .= '<span class="counter-wrap">';
				$output .= '<span class="counter" data-to="'.$stat.'" data-speed="1500" data-refresh-interval="50">0</span>';
			$output .= '</span>';
			$output .= '<div class="counter-info"><div class="counter-info-inner">';
				$output .= $title;
			$output .= '</div></div>';
		$output .= '</div>';

	  return $output;

	}
	add_shortcode('counter_stats', 'counter_stats');
}




/*-----------------------------------------------------------------------------------*/
/*	Jobs Slider
/*  @since 1.1.0
/*-----------------------------------------------------------------------------------*/

if (!function_exists('jobs_slider_shortcode')) {
	function jobs_slider_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'num'      => '4',
				'featured' => null
		), $atts));

		// Check if WP Job Manager is installed
		if (class_exists( 'WP_Job_Manager' )) {

			if ( ! is_null( $featured ) ) {
				$featured = ( is_bool( $featured ) && $featured ) || in_array( $featured, array( '1', 'true', 'yes' ) ) ? true : false;
			}

			ob_start();

			$jobs = get_job_listings( apply_filters( 'job_manager_output_jobs_args', array(
				'posts_per_page'    => $num,
				'featured'          => $featured
			) ) );

			if ( $jobs->have_posts() ) : ?>

				<div class="owl-carousel owl-theme owl-featured-listings">

				<?php while ( $jobs->have_posts() ) : $jobs->the_post(); ?>

					<div class="listing-box">

						<div class="job_summary_shortcode">
							<?php get_job_manager_template( 'content-summary-job_listing.php' ); ?>
						</div>

					</div>

				<?php endwhile; ?>

				</div>

			<?php endif;

			wp_reset_postdata();

			return ob_get_clean();

		} else { ?>

		<div class="alert alert-warning">
			<?php _e('<strong>WP Job Manager</strong> plugin is missed. Please install and activate it.', 'petsitter'); ?>
		</div>

		<?php }

	}
	add_shortcode('jobs_slider', 'jobs_slider_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Jobs Feed
/*  @since 1.1.0
/*-----------------------------------------------------------------------------------*/

if (!function_exists('jobs_feed_shortcode')) {
	function jobs_feed_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'num'     => '4',
				'cols'    => '4',
				'orderby' => 'date',
				'featured' => null
		), $atts));

		if($cols == 2) {
			$cols = "col-md-6";
		} elseif($cols == 4) {
			$cols = "col-md-3 col-sm-6";
		} elseif($cols == 3) {
			$cols = "col-md-4";
		} else{
			$cols = "col-md-2";
		}

		// Check if Resume Manager is installed
		if (class_exists( 'WP_Job_Manager' )) {

			if ( ! is_null( $featured ) ) {
				$featured = ( is_bool( $featured ) && $featured ) || in_array( $featured, array( '1', 'true', 'yes' ) ) ? true : false;
			}

			ob_start();

			$args = array(
				'featured'       => $featured,
				'post_type'      => 'job_listing',
				'post_status'    => 'publish',
				'posts_per_page' => $num,
				'orderby'        => $orderby
			);

			$jobs = new WP_Query( $args );

			if ( $jobs->have_posts() ) : ?>

				<div class="row">

				<?php while ( $jobs->have_posts() ) : $jobs->the_post(); ?>

					<div class="<?php echo $cols; ?>">

						<div class="job_summary_shortcode">
							<?php get_job_manager_template( 'content-summary-job_listing.php' ); ?>
						</div>

						<div class="spacer-sm"></div>

					</div>

				<?php endwhile; ?>

				</div>

			<?php endif;

			wp_reset_postdata();

			return ob_get_clean();

		} else { ?>

		<div class="alert alert-warning">
			<?php _e('<strong>WP Job Manager</strong> add-on is missed. Please install and activate it.', 'petsitter'); ?>
		</div>

		<?php }

	}
	add_shortcode('jobs_feed', 'jobs_feed_shortcode');
}




/*-----------------------------------------------------------------------------------*/
/*	Jobs Carousel
/*  @since 1.4.0
/*-----------------------------------------------------------------------------------*/

if (!function_exists('jobs_carousel_shortcode')) {
	function jobs_carousel_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'num'        => '8',
				'cols'       => '4',
				'orderby'    => 'date',
				'featured'   => null,
				'categories' => '',
		), $atts));

		// Check if WP Jobm Manager is installed
		if (class_exists( 'WP_Job_Manager' )) {

			$categories      = is_array( $categories ) ? $categories : array_filter( array_map( 'trim', explode( ',', $categories ) ) );

			if ( ! is_null( $featured ) ) {
				$featured = ( is_bool( $featured ) && $featured ) || in_array( $featured, array( '1', 'true', 'yes' ) ) ? true : false;
			}

			ob_start();

			$args = array(
				'search_categories' => $categories,
				'featured'          => $featured,
				'post_type'         => 'job_listing',
				'post_status'       => 'publish',
				'posts_per_page'    => $num,
				'orderby'           => $orderby
			);

			$jobs = new WP_Query( $args );

			//Create unique ID for this carousel
			$carousel_id = rand();

			if ( $jobs->have_posts() ) : ?>

				<script>
					jQuery(function($){
						$("<?php echo '#jobs_carousel__' . esc_js($carousel_id); ?>").owlCarousel({
							navigation : true, // Show next and prev buttons
							slideSpeed : 300,
							paginationSpeed : 400,
							navigationText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
							pagination: false,

							items : <?php echo esc_js($cols); ?>, //4 items above 1000px browser width
							itemsDesktop : [1000,<?php echo esc_js($cols); ?>], //4 items between 1000px and 901px
							itemsDesktopSmall : [900,3], // 4 items betweem 900px and 601px
							itemsTablet: [600,2], //2 items between 600 and 0;
							itemsMobile : [480,1], // itemsMobile disabled - inherit from itemsTablet option

						});
					});
				</script>

				<div class="row">
					<div class="owl-carousel owl-theme owl-theme__nav-outside" id="jobs_carousel__<?php echo esc_attr($carousel_id); ?>">
					
					<?php while ( $jobs->have_posts() ) : $jobs->the_post(); ?>
					
						<div class="col-md-12">
					
							<div class="job_summary_shortcode">
								<?php get_job_manager_template( 'content-summary-job_listing.php' ); ?>
							</div>
					
							<div class="spacer-sm"></div>
					
						</div>
					
					<?php endwhile; ?>
					
					</div>
				</div>

			<?php endif;

			wp_reset_postdata();

			return ob_get_clean();

		} else { ?>

		<div class="alert alert-warning">
			<?php _e('<strong>WP Job Manager</strong> add-on is missed. Please install and activate it.', 'petsitter'); ?>
		</div>

		<?php }

	}
	add_shortcode('jobs_carousel', 'jobs_carousel_shortcode');
}




/*-----------------------------------------------------------------------------------*/
/*	Resumes Slider
/*  @since 1.1.0
/*-----------------------------------------------------------------------------------*/

if (!function_exists('resumes_slider_shortcode')) {
	function resumes_slider_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'num'      => '4',
				'featured' => null
		), $atts));

		// Check if Resume Manager installed
		if (class_exists( 'WP_Resume_Manager' )) {

			ob_start();

			$args = array(
				'post_type'   => 'resume',
				'post_status' => 'publish',
				'posts_per_page' => $num
			);

			$resumes = get_resumes( apply_filters( 'resume_manager_output_resumes_args', array(
				'posts_per_page'    => $num,
				'featured'          => $featured
			) ) );

			if ( $resumes->have_posts() ) : ?>

				<div class="owl-carousel owl-theme owl-featured-listings">

				<?php while ( $resumes->have_posts() ) : $resumes->the_post(); ?>

					<div class="listing-box">

						<div class="resume_summary_shortcode">

							<a href="<?php the_permalink(); ?>"><?php the_candidate_photo( 'portfolio-n' ); ?></a>

							<div class="resume_summary_content-holder">
								<div class="resume_summary_content">
								
									<h5 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
									<h6 class="resume_summary_title"><a href="<?php the_permalink(); ?>"><?php the_candidate_title(); ?></a></h6>
								</div>
								
								<footer class="resume_summary_footer">
									<ul class="meta">
										<?php if ( get_the_resume_category() ) : ?>
										<li class="category"><?php the_resume_category(); ?></li>
										<?php endif; ?>
										<li class="location"><?php the_candidate_location( false ); ?></li>
										<li class="date"><?php printf( __( 'Posted %s ago', 'petsitter' ), human_time_diff( get_post_time( 'U' ), current_time( 'timestamp' ) ) ); ?></li>
									</ul>
								</footer>
							</div>

						</div>

					</div>

				<?php endwhile; ?>

				</div>

			<?php endif;

			wp_reset_postdata();

			return ob_get_clean();

		} else { ?>

		<div class="alert alert-warning">
			<?php _e('<strong>Resume Manager</strong> add-on is missed. Please install and activate it.', 'petsitter'); ?>
		</div>

		<?php }

	}
	add_shortcode('resumes_slider', 'resumes_slider_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Resumes Feed
/*  @since 1.1.0
/*-----------------------------------------------------------------------------------*/

if (!function_exists('resumes_feed_shortcode')) {
	function resumes_feed_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'num'      => '4',
				'cols'     => '4',
				'orderby'  => 'date',
				'featured' => null
		), $atts));

		if($cols == 2) {
			$cols = "col-md-6";
		} elseif($cols == 4) {
			$cols = "col-md-3 col-sm-6";
		} elseif($cols == 3) {
			$cols = "col-md-4";
		} else{
			$cols = "col-md-2";
		}

		// Check if Resume Manager is installed
		if (class_exists( 'WP_Resume_Manager' )) {

			if ( ! is_null( $featured ) ) {
				$featured = ( is_bool( $featured ) && $featured ) || in_array( $featured, array( '1', 'true', 'yes' ) ) ? true : false;
			}

			ob_start();

			$args = array(
				'featured'       => $featured,
				'post_type'      => 'resume',
				'post_status'    => 'publish',
				'posts_per_page' => $num,
				'orderby'        => $orderby
			);

			$resumes = new WP_Query( $args );

			if ( $resumes->have_posts() ) : ?>

				<div class="row">

				<?php while ( $resumes->have_posts() ) : $resumes->the_post(); ?>

					<div class="<?php echo $cols; ?>">

						<div class="resume_summary_shortcode">

							<a href="<?php the_permalink(); ?>"><?php the_candidate_photo( 'portfolio-n' ); ?></a>

							<div class="resume_summary_content-holder">
								<div class="resume_summary_content">
								
									<h5 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
									<h6 class="resume_summary_title"><a href="<?php the_permalink(); ?>"><?php the_candidate_title(); ?></a></h6>
								</div>
								
								<footer class="resume_summary_footer">
									<ul class="meta">
										<?php if ( get_the_resume_category() ) : ?>
										<li class="category"><?php the_resume_category(); ?></li>
										<?php endif; ?>
										<li class="location"><?php the_candidate_location( false ); ?></li>
										<li class="date"><?php printf( __( 'Posted %s ago', 'petsitter' ), human_time_diff( get_post_time( 'U' ), current_time( 'timestamp' ) ) ); ?></li>
									</ul>
								</footer>
							</div>

						</div>

						<div class="spacer-sm"></div>

					</div>

				<?php endwhile; ?>

				</div>

			<?php endif;

			wp_reset_postdata();

			return ob_get_clean();

		} else { ?>

		<div class="alert alert-warning">
			<?php _e('<strong>Resume Manager</strong> add-on is missed. Please install and activate it.', 'petsitter'); ?>
		</div>

		<?php }

	}
	add_shortcode('resumes_feed', 'resumes_feed_shortcode');
}



/*-----------------------------------------------------------------------------------*/
/*	Resumes Carousel
/*  @since 1.4.0
/*-----------------------------------------------------------------------------------*/

if (!function_exists('resumes_carousel_shortcode')) {
	function resumes_carousel_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'num'        => '8',
				'cols'       => '4',
				'orderby'    => 'date',
				'categories' => '',
				'featured'   => null
		), $atts));

		$categories = array_filter( array_map( 'trim', explode( ',', $categories ) ) );

		// Check if Resume Manager is installed
		if (class_exists( 'WP_Resume_Manager' )) {

			if ( ! is_null( $featured ) ) {
				$featured = ( is_bool( $featured ) && $featured ) || in_array( $featured, array( '1', 'true', 'yes' ) ) ? true : false;
			}

			ob_start();

			$args = array(
				'search_categories' => $categories,
				'featured'          => $featured,
				'post_type'         => 'resume',
				'post_status'       => 'publish',
				'posts_per_page'    => $num,
				'orderby'           => $orderby
			);

			$resumes = new WP_Query( $args );

			//Create unique ID for this carousel
			$carousel_id = rand();

			if ( $resumes->have_posts() ) : ?>

				<script>
					jQuery(function($){
						$("<?php echo '#resumes_carousel__' . esc_js($carousel_id); ?>").owlCarousel({
							navigation : true, // Show next and prev buttons
							slideSpeed : 300,
							paginationSpeed : 400,
							navigationText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
							pagination: false,

							items : <?php echo esc_js($cols); ?>, //4 items above 1000px browser width
							itemsDesktop : [1000,<?php echo esc_js($cols); ?>], //4 items between 1000px and 901px
							itemsDesktopSmall : [900,3], // 4 items betweem 900px and 601px
							itemsTablet: [600,2], //2 items between 600 and 0;
							itemsMobile : [480,1], // itemsMobile disabled - inherit from itemsTablet option

						});
					});
				</script>

				<div class="row">
					<div class="owl-carousel owl-theme owl-theme__nav-outside" id="resumes_carousel__<?php echo esc_attr($carousel_id); ?>">
					
					<?php while ( $resumes->have_posts() ) : $resumes->the_post(); ?>
					
						<div class="col-md-12">
					
							<div class="resume_summary_shortcode">

								<a href="<?php the_permalink(); ?>"><?php the_candidate_photo( 'portfolio-n' ); ?></a>

								<div class="resume_summary_content-holder">
									<div class="resume_summary_content">
									
										<h5 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
										<h6 class="resume_summary_title"><a href="<?php the_permalink(); ?>"><?php the_candidate_title(); ?></a></h6>
									</div>
									
									<footer class="resume_summary_footer">
										<ul class="meta">
											<?php if ( get_the_resume_category() ) : ?>
											<li class="category"><?php the_resume_category(); ?></li>
											<?php endif; ?>
											<li class="location"><?php the_candidate_location( false ); ?></li>
											<li class="date"><?php printf( __( 'Posted %s ago', 'petsitter' ), human_time_diff( get_post_time( 'U' ), current_time( 'timestamp' ) ) ); ?></li>
										</ul>
									</footer>
								</div>

							</div>
					
							<div class="spacer-sm"></div>
					
						</div>
					
					<?php endwhile; ?>
					
					</div>
				</div>

			<?php endif;

			wp_reset_postdata();

			return ob_get_clean();

		} else { ?>

		<div class="alert alert-warning">
			<?php _e('<strong>Resume Manager</strong> add-on is missed. Please install and activate it.', 'petsitter'); ?>
		</div>

		<?php }

	}
	add_shortcode('resumes_carousel', 'resumes_carousel_shortcode');
}
?>