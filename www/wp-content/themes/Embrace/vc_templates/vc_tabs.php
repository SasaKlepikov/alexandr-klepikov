<?php
$output = $title = $vertical = $el_class = $module_animation = '';
extract(shortcode_atts(array(
    'title' => '',
    'interval' => 0,
    'el_class' => '',
	'vertical' => 'no',
	'module_animation' => '',
), $atts));

$el_class = $this->getExtraClass($el_class);

$element = 'wpb_tabs';

// Extract tab titles
preg_match_all( '/vc_tab title="([^\"]+)"(\stab_id\=\"([^\"]+)\")(\sicon\=\"([^\"]+)\"){0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();
$v_class= ($vertical == 'yes') ? 'vertical' : '';


/**
 * vc_tabs
 *
 */


if ( isset($matches[0]) ) { $tab_titles = $matches[0]; }
$tabs_nav = '';
$tabs_nav .= '<dl class="tabs ' . $v_class .'" data-tab>';
$tabs_count = 1;
foreach ( $tab_titles as $tab ) {

	$have_icon = strpos($tab[0],'icon');

	if ( $have_icon ) {
		preg_match( '/title="([^\"]+)"(\stab_id\=\"([^\"]+)\")(\sicon\=\"([^\"]+)\"){0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
	} else {
		preg_match( '/title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
	}

	if(isset($tab_matches[1][0])) {
			$active_tab = ( $tabs_count == 1 ) ? 'active' : '';
			$tabs_nav .= '<dd class="' . $active_tab . '">';
			$tabs_nav .= '<a href="#tab-' . ( isset( $tab_matches[3][0] ) ? $tab_matches[3][0] : sanitize_title( $tab_matches[1][0] ) ) . '">';
			if ( isset($tab_matches[5][0]) && !($tab_matches[5][0] == '') ) {
				$tabs_nav .= '<i class=" ' . $tab_matches[5][0] . ' ">';
				$tabs_nav .= '</i>';
			}
			$tabs_nav .=  $tab_matches[1][0];
			$tabs_nav .= '</a>';
			$tabs_nav .= '</dd>';
    }
	$tabs_count ++;
}
$tabs_nav .= '</dl>'."\n";

$animate = $animation_data = '';

if ( ! ($module_animation == '')){
	$animate = ' cr-animate-gen';
	$animation_data = 'data-animate-type = "'.$module_animation.'" ';
}

$output .= "\n\t".'<div class="tabs_block '. $el_class . ''.$animate.'" '.$animation_data.'>';
$output .= "\n\t\t\t".$tabs_nav;
$output .= "\n\t".'<div class="tabs-content ' . $v_class . '">';
$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
$output .= "\n\t".'</div> ';
$output .= "\n\t".'</div> '.$this->endBlockComment($element);

echo $output;