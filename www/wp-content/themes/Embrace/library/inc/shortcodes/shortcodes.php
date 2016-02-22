<?php
/**
 * Reactor Shortcodes
 * lots of Foundation elements in shortcode form
 *
 * @package Reactor
 * @author  Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since   1.0.0
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * Table of Contents
 *
 * 1. Alerts
 * 2. Buttons
 * 3. Columns
 * 4. Flex Video
 * 5. Gallery ( custom WP shortcode )
 * 6. Glyph Icons
 * 7. Labels
 * 8. Panels
 * 9. Price Tables
 * 10. Price Table Items
 * 11. Progress Bars
 * 12. Reveal Modals
 * 13. Section Groups
 * 14. Sections
 * 15. Slider
 * 16. Tooltips
 * 17. Sign In
 */

/**
 * 1. Alerts
 *
 * @since 1.0.0
 */
function reactor_add_alerts( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'type'  => '', // standard, success, alert, secondary
				'shape' => '', // radius, round
				'close' => 'true', // add X to close alert
				'class' => ''
			), $atts
		)
	);

	$class_array[] = ( $shape ) ? $shape : '';
	$class_array[] = ( $type ) ? $type : '';
	$class_array[] = ( $class ) ? $class : '';
	$class_array   = array_filter( $class_array );
	$classes       = implode( ' ', $class_array );

	switch ( $type ) {
		case 'warning':
			$icon = '<i class="crum-icon crum-warning"></i>';
			break;
		case 'alert':
			$icon = '<i class="crum-icon crum-spam"></i>';
			break;
		case 'success':
			$icon = '<i class="crum-icon crum-checkmark2"></i>';
			break;
		default:
			$icon = '';
	}

	$output = '<div data-alert class="alert-box ' . $classes . '">';
	$output .= $icon;
	$output .= do_shortcode( $content );
	$output .= ( 'false' != $close ) ? '<a class="close" href="">&times;</a>' : '';
	$output .= '</div>';

	return $output;
}

/**
 * 3. Columns
 *
 * @since 1.0.0
 */
function reactor_add_columns( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'first_last' => '',
				'large'      => '',
				'small'      => ''
			), $atts
		)
	);

	switch ( $large ) {
		case '12'   :
			$large = 'large-12';
			break;
		case '11'   :
			$large = 'large-11';
			break;
		case '10'   :
			$large = 'large-10';
			break;
		case '9'    :
			$large = 'large-9';
			break;
		case '8'    :
			$large = 'large-8';
			break;
		case '7'    :
			$large = 'large-7';
			break;
		case '6'    :
			$large = 'large-6';
			break;
		case '5'    :
			$large = 'large-5';
			break;
		case '4'    :
			$large = 'large-4';
			break;
		case '3'    :
			$large = 'large-3';
			break;
		case '2'    :
			$large = 'large-2';
			break;
		case '1'    :
			$large = 'large-1';
			break;
	}

	switch ( $small ) {
		case '12'   :
			$small = ' small-12';
			break;
		case '11'   :
			$small = ' small-11';
			break;
		case '10'   :
			$small = ' small-10';
			break;
		case '9'    :
			$small = ' small-9';
			break;
		case '8'    :
			$small = ' small-8';
			break;
		case '7'    :
			$small = ' small-7';
			break;
		case '6'    :
			$small = ' small-6';
			break;
		case '5'    :
			$small = ' small-5';
			break;
		case '4'    :
			$small = ' small-4';
			break;
		case '3'    :
			$small = ' small-3';
			break;
		case '2'    :
			$small = ' small-2';
			break;
		case '1'    :
			$small = ' small-1';
			break;
	}

	$output = '';
	$output .= ( $first_last == 'first' ) ? '<div class="row">' : '';
	$output .= '<div class="' . $large . $small . ' columns">';
	$output .= do_shortcode( $content );
	$output .= '</div>';
	$output .= ( $first_last == 'last' ) ? '</div>' : '';

	return $output;
}


/**
 * 4. Flex Videos
 *
 * @since 1.0.0
 */
function reactor_add_flex_video( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'widescreen' => 'true',
				'vimeo'      => 'false'
			), $atts
		)
	);

	$class_array   = array();
	$class_array[] = ( $widescreen == 'true' ) ? ' widescreen' : '';
	$class_array[] = ( $vimeo == 'true' ) ? ' vimeo' : '';
	$class_array   = array_filter( $class_array );
	$classes       = implode( ' ', $class_array );

	$output = '<div class="flex-video' . $classes . '">';
	$output .= $content;
	$output .= '</div>';

	return $output;
}

/**
 * 12. Reveal Modals
 *
 * @since 1.0.0
 */
function reactor_add_reveal_modals( $atts, $content = null ) {
	global $post;
	extract(
		shortcode_atts(
			array(
				'button' => 'false', // whether or not the link is a button
				'text'   => 'Click here', // text for link or button
				'size'   => '' // tiny, small, medium, large, xlarge
			), $atts
		)
	);

	$unique_id = $post->ID . '-' . rand( 1000, 9999 );
	$class     = ( $button == 'true' ) ? 'class="button"' : '';
	$output    = '<a href="#" ' . $class . ' data-reveal-id="' . $unique_id . '">' . $text . '</a>';

	$reveal_output = '<div id="' . $unique_id . '" class="reveal-modal ' . $size . ' shortcode-modal" data-reveal>';
	$reveal_output .= do_shortcode( $content );
	$reveal_output .= '<a class="close-reveal-modal">&#215;</a>';
	$reveal_output .= '</div>';

	$GLOBALS['reveal_content'][] = $reveal_output;

	return $output;
}

add_action( 'wp_footer', 'reveal_footer_content' );
function reveal_footer_content() {
	if ( ! empty( $GLOBALS['reveal_content'] ) ) {
		echo "\n" . '<!-- [reveal_modal] shortcode output -->';

		foreach ( $GLOBALS['reveal_content'] as $output ) {
			echo "\n" . $output;
		}

		echo "\n" . '<!-- / end [reveal_modal] output -->' . "\n";
	}
}


/**
 * 8. Panels
 *
 * @since 1.0.0
 */
function reactor_add_panels( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'shape'   => '', // square, radius
				'callout' => 'false', // true for a brighter panel
				'class'   => ''
			), $atts
		)
	);

	$class_array   = array();
	$class_array[] = ( $shape ) ? $shape : '';
	$class_array[] = ( $callout == 'true' ) ? 'callout' : '';
	$class_array[] = ( $class ) ? $class : '';
	$class_array   = array_filter( $class_array );
	$classes       = implode( ' ', $class_array );

	$output = '<div class="' . $classes . ' panel">';
	$output .= do_shortcode( $content );
	$output .= '</div>';

	return $output;
}

/**
 * 16. Tooltips
 *
 * @since 1.0.0
 */
function reactor_add_tooltips( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'position' => '', // bottom ( deftault ), top, right, left
				'width'    => '', // set the width
				'class'    => '',
				'text'     => 'Add some tooltip text' // add text to the tooltip
			), $atts
		)
	);

	$class_array   = array();
	$class_array[] = ( $position ) ? 'tip-' . $position : '';
	$class_array[] = ( $class ) ? $class : '';
	$class_array   = array_filter( $class_array );
	$classes       = implode( ' ', $class_array );

	$output = '<span data-tooltip class="has-tip ' . $classes . '"';
	if ( $width ) {
		$output .= ' data-width="' . $width . '"';
	}
	$output .= ' title="' . $text . '">';
	$output .= do_shortcode( $content );
	$output .= '</span>';

	return $output;
}

/**
 * 16. Login form
 *
 * @since 1.0.0
 */


#-----------------------------------------------------------------#
# JS Composer Elements
#-----------------------------------------------------------------#

// Dropcaps

function crum_dropcap( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'style' => '',
			), $atts
		)
	);

	$output = '<div class="dropcap ' . $style . '">' . $content . '</div>';

	return $output;
}

//toggle panel - accordion chosen
function crum_shortcode_toggles( $atts, $content = null ) {
	extract( shortcode_atts( array( "accordion" => 'false' ), $atts ) );

	( $accordion == 'true' ) ? $accordion_class = 'open-first' : $accordion_class = null;

	return '<dl class="accordion ' . $accordion_class . '" data-accordion ">' . do_shortcode( $content ) . '</dl>';
}


//toggle
function crum_shortcode_toggle( $atts, $content = null ) {
	extract( shortcode_atts( array( "title" => 'Title' ), $atts ) );

	return '<dd>
    <a href="#">' . $title . '</a>
    <div  class="content">' . do_shortcode( $content ) . '</div>
  </dd>';
}

//milestone
function crum_shortcode_milestone( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				"subject"         => '',
				'symbol'          => '',
				'symbol_position' => 'after',
				'number'          => '0',
				'color'           => 'Default'
			), $atts
		)
	);

	if ( ! empty( $symbol ) ) {
		$symbol_markup = 'data-symbol="' . $symbol . '" data-symbol-pos="' . $symbol_position . '"';
	} else {
		$symbol_markup = null;
	}

	$number_markup  = '<div class="number" style="color:' . $color . '"><span>' . $number . '</span></div>';
	$subject_markup = '<h6 class="subject">' . $subject . '</h6>';

	return '<div class="crum-milestone" ' . $symbol_markup . '> ' . $number_markup . ' ' . $subject_markup . ' </div>';
}

//image with animation
function crum_shortcode_image_with_animation( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				"animation" => 'Fade In',
				"delay"     => '0',
				"image_url" => '',
				'alt'       => ''
			), $atts
		)
	);

	$parsed_animation = str_replace( " ", "-", $animation );
	( ! empty( $alt ) ) ? $alt_tag = $alt : $alt_tag = null;

	if ( strpos( $image_url, "http://" ) === false ) {
		$image_src = wp_get_attachment_image_src( $image_url, 'full' );
		$image_url = $image_src[0];
	}

	return '<img class="img-with-animation" data-delay="' . $delay . '" data-animation="' . strtolower( $parsed_animation ) . '" src="' . $image_url . '" alt="' . $alt_tag . '" />';
}

//Call to action button
function crum_button( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'link'       => '',
				'title'      => __( 'Text on the button', "crum" ),
				'color'      => '',
				'icon'       => '',
				'size'       => '',
				'style'      => '',
				'full_width' => '',
				'el_class'   => ''
			), $atts
		)
	);

	$class = 'button';
	//parse link
	$link     = ( $link == '||' ) ? '' : $link;
	$link_1 = $link;
	$link     = vc_build_link( $link );
	$a_href   = $link['url'];
	$a_title  = $link['title'];
	$a_target = $link['target'];

	if (($a_href == '') && !($link['http'] == '')){
		$a_href = $link_1;
	}

	$inline_style = ( $color != '' ) ? ' style="background: ' . $color . ';"' : '';
	$class .= ( $size != '' ) ? ' ' . $size : '';
	$class .= ( $style != '' ) ? ' ' . $style : '';
	$class .= ( $full_width != '' ) ? ' expand ' : '';

	$icon = ( $icon != '' ) ? '<i class="' . $icon . '"></i> ' : '';

	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . $class );

	return '<a class="' . esc_attr( trim( $css_class ) ) . ' ' . $el_class . '" href="' . $a_href . '" title="' . esc_attr( $a_title ) . '" target="' . $a_target . '" ' . $inline_style . '>' . $icon . $title . '</a>';
}


//Call to action button
function crum_cta_button( $atts, $content = null ) {
	extract(
		shortcode_atts(
			array(
				'h2'           => '',
				'h4'           => '',
				'position'     => '',
				'el_width'     => '',
				'style'        => '',
				'txt_align'    => '',
				'accent_color' => '',
				'link'         => '',
				'title'        => __( 'Text on the button', "crum" ),
				'color'        => '',
				'icon'         => '',
				'size'         => '',
				'btn_style'    => '',
				'el_class'     => '',
			), $atts
		)
	);

	$class = "vc_call_to_action wpb_content_element";
	$link  = ( $link == '||' ) ? '' : $link;

	$class .= ( $position != '' ) ? ' vc_cta_btn_pos_' . $position : '';
	$class .= ( $el_width != '' ) ? ' vc_el_width_' . $el_width : '';
	$class .= ( $color != '' ) ? ' vc_cta_' . $color : '';
	$class .= ( $style != '' ) ? ' vc_cta_' . $style : '';
	$class .= ( $txt_align != '' ) ? ' vc_txt_align_' . $txt_align : '';

	$inline_css = ( $accent_color != '' ) ? ' style="background-color: ' . $accent_color . '; border-color: ' . $accent_color . ';"' : '';

	$class .= $el_class;
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class );

	$html = '<div' . $inline_css . ' class="' . esc_attr( trim( $css_class ) ) . '">';

	if ( $link != '' && $position != 'bottom' ) {
		$html .= do_shortcode( '[button link="' . $link . '" title="' . $title . '" color="' . $color . '" icon="' . $icon . '" size="' . $size . '" style="' . $btn_style . '" el_class=" vc_cta_btn"]' );
	}

	if ( $h2 != '' || $h4 != '' ):
		$html .= '<hgroup>';
		if ( $h2 != '' ): $html .= '<h2 class="wpb_heading">' . $h2 . '</h2>'; endif;
		if ( $h4 != '' ): $html .= '<h5 class="wpb_heading">' . $h4 . '</h5>'; endif;
		$html .= '</hgroup>';
	endif;
	$html .= wpb_js_remove_wpautop( $content, true );
	if ( $link != '' && $position == 'bottom' ) {
		$html .= do_shortcode( '[button link="' . $link . '" title="' . $title . '" color="' . $color . '" icon="' . $icon . '" size="' . $size . '" style="' . $btn_style . '" el_class=" vc_cta_btn"]' );
	}
	$html .= '</div>';

	return $html;
}

//Woocommerce products flexslider

function crum_woo_flexslider( $atts, $content = null ) {

	$id = '';

	extract(
		shortcode_atts(
			array(
				'id' => '', /* some unique id */
			), $atts
		)
	);

	/* If there's no content, just return back what we got. */
	if ( is_null( $content ) )
		return $content;

	$output = '<div id="' . $id . '"><span class="extra-links"></span>';
	$output .= $content;
	$output .= '</div>';

	$output .= '<script type="text/javascript">
            jQuery(document).ready(function () {

                jQuery("#' . $id . ' div.woocommerce").flexslider({
                    selector: "ul.products > li",
                    animation: "slide",
                    direction: "horizontal",
                    itemWidth: 280,                     //{NEW} Integer: Box-model width of individual carousel items, including horizontal borders and padding.
                    itemMargin: 20,                     //{NEW} Integer: Margin between carousel items.
                    minItems: 2,                        //{NEW} Integer: Minimum number of carousel items that should be visible. Items will resize fluidly when below this.
                    maxItems: 4,
                    controlsContainer: ".extra-links",
                    slideshow: false,
                    controlNav: false,            //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    directionNav: true,           //Boolean: Create navigation for previous/next navigation? (true/false)
                    prevText: "",                 //String: Set the text for the "previous" directionNav item
                    nextText: ""
                });

            });
        </script>';

	return $output;
}

function crum_wp_url_shortcode(){
$output = '<a href=" http://wordpress.org/" title=" Wordpress">Wordpress</a>';
	return $output;
}

function crum_site_url_shortcode(){
	$output = '<a href=" '. home_url() .'" title=" '.get_bloginfo('name').'">'. get_bloginfo('name').'</a>';
	return $output;
}

function crum_theme_url_shortcode(){
	if (function_exists('wp_get_theme')){
		$theme_data = wp_get_theme();
		$theme_uri = $theme_data->get('ThemeURI');
        $theme_name = $theme_data->get('Name');
	}
	$output = '<a href=" '. $theme_uri .'" title="'.$theme_name.'">'.$theme_name.'</a>';
	return $output;
}

function crum_login_url_shortcode(){
	$output = '<a href=" '. wp_login_url( home_url() ) .'" title=" Login">Login</a>';
	return $output;
}

function crum_logout_url_shortcode(){
	$output = '<a href=" '. wp_logout_url( home_url() ) .'" title=" Logout">Logout</a>';
	return $output;
}

function crum_site_title_shortcode(){
	$output = get_bloginfo('name');
	return $output;
}

function crum_site_tagline_shortcode(){
	$output = get_bloginfo('description');
	return $output;
}

function crum_current_year_shortcode(){
	$output = date("Y");
	return $output;
}

function register_shortcodes() {
	add_shortcode( 'alert', 'reactor_add_alerts' );
	add_shortcode( 'column', 'reactor_add_columns' );
	add_shortcode( 'flex_video', 'reactor_add_flex_video' );
	add_shortcode( 'panel', 'reactor_add_panels' );
	add_shortcode( 'reveal_modal', 'reactor_add_reveal_modals' );
	add_shortcode( 'tooltip', 'reactor_add_tooltips' );
	add_shortcode( 'dropcap', 'crum_dropcap' );
	add_shortcode( 'toggles', 'crum_shortcode_toggles' );
	add_shortcode( 'toggle', 'crum_shortcode_toggle' );
	add_shortcode( 'milestone', 'crum_shortcode_milestone' );
	add_shortcode( 'image_with_animation', 'crum_shortcode_image_with_animation' );
	add_shortcode( 'button', 'crum_button' );
	add_shortcode( 'cta_button', 'crum_cta_button' );
	add_shortcode( 'woocommerce_flexslider', 'crum_woo_flexslider' );

	//Pie chart with icon
	add_shortcode( 'crum_pie_icon', 'crum_icon_pie_chart' );

	//Theme standard shortcodes
	add_shortcode('wp-url','crum_wp_url_shortcode');
	add_shortcode('site-url','crum_site_url_shortcode');
	add_shortcode('theme-url','crum_theme_url_shortcode');
	add_shortcode('login-url','crum_login_url_shortcode');
	add_shortcode('logout-url','crum_logout_url_shortcode');
	add_shortcode('site-title','crum_site_title_shortcode');
	add_shortcode('site-tagline','crum_site_tagline_shortcode');
	add_shortcode('current-year','crum_current_year_shortcode');

}

add_action( 'init', 'register_shortcodes' );




