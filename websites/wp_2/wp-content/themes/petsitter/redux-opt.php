<style type="text/css">
/* CSS Generated from theme options */
<?php
	global $petsitter_data;

	$theme_options_styles = '';

	$layout_border_radius = $petsitter_data['petsitter__layout-border-radius'];
	if ( $layout_border_radius != '0' ) {
		$theme_options_styles .= '
		@media (min-width: 768px) {
			.site-wrapper.site-wrapper__boxed {
				border-radius: ' . $layout_border_radius . 'px;
			}
			.header-top {
				border-radius: ' . $layout_border_radius . 'px ' . $layout_border_radius . 'px 0 0;
			}
			.footer-copyright {
				border-radius: 0 0 ' . $layout_border_radius . 'px ' . $layout_border_radius . 'px;
			}
		}';
	}

	$typography_top_bar = $petsitter_data['petsitter__typography-top-bar'];
	if ( $typography_top_bar != '0' ) {
		$theme_options_styles .= '
		@media (min-width: 992px) {
			.header-top ul {
				font-size: ' . $typography_top_bar['font-size'] . ';
				font-family: ' . $typography_top_bar['font-family'] . ';
				font-weight: ' . $typography_top_bar['font-weight'] . ';
				text-transform: ' . $typography_top_bar['text-transform'] . ';
			}

			.header-top ul > li > a {
				color: ' . $typography_top_bar['color'] . ';
			}
		}';
	}

	if( $theme_options_styles ){
		// ensure consistent line endings
		$s = str_replace("\r\n", "\n", $theme_options_styles);
		$s = str_replace("\r", "\n", $s);
		// Don't allow out-of-control blank lines
		$s = preg_replace("/\n{2,}/", "\n\n", $s);
		echo $s;
	}

?>
</style>