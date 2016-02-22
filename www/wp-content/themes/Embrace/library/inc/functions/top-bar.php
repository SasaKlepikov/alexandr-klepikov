<?php
/**
 * Top Bar Function
 * output code for the Foundation top bar structure
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

if ( !function_exists('reactor_top_bar') ) {
	function reactor_top_bar( $args = '' ) {

		$defaults = array(
			'menu_name'  => 'Menu',
			'left_menu'  => 'reactor_top_bar_l',
			'right_menu' => 'reactor_top_bar_r',
			'social' 	 => true,
			'search' 	 => true,
			'fixed'      => false,
			'contained'  => true,
			'sticky'     => false,
		);
		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'reactor_top_bar_args', $args );


		/* call functions to create right and left menus in the top bar. defaults to the registered menus for top bar */
		$left_menu = ( ( $args['left_menu'] && is_callable( $args['left_menu'] ) ) ) ? call_user_func( $args['left_menu'], (array) $args ) : '';
		$right_menu = ( ( $args['right_menu'] && is_callable( $args['right_menu'] ) ) ) ? call_user_func( $args['right_menu'], (array) $args ) : '';
		$reactor_topbar_social = ( ( $args['reactor_topbar_social'] && is_callable( $args['reactor_topbar_social'] ) ) ) ? call_user_func( $args['reactor_topbar_social'], (array) $args ) : '';
		$search = ( ( $args['search'] && is_callable( $args['search'] ) ) ) ? call_user_func( $args['search'], (array) $args ) : '';

		// assemble classes for top bar
		$classes = array(); $output = '';
		$classes[] = ( $args['fixed'] ) ? 'fixed' : '';
		$classes[] = ( $args['contained'] ) ? 'contain-to-grid' : '';
		$classes[] = ( $args['sticky'] ) ? 'sticky' : '';
		$classes = array_filter( $classes );
		$classes = implode( ' ', array_map( 'esc_attr', $classes ) );

		// start top bar output
		$output .= '<div class="top-bar-container ' . $classes . '">';
		$output .= '<nav class="top-bar"  data-topbar><div class="row"><div class="large-12 columns">';
		$output .= $reactor_topbar_social;
		$output .= '<section class="top-bar-section">';
		$output .= $left_menu;
		$output .= $search;
		$output .= $right_menu;


		$output .= '</section>';
		$output .= '</div></div></nav>';
		$output .= '</div>';

		echo apply_filters('reactor_top_bar', $output, $args);
	}
}

/**
 * Function to use search form in top bar
 * this chould be used as the callback for top bar menus
 *
 * @since 1.0.0
 */
if(!function_exists('reactor_topbar_search')) {
	function reactor_topbar_search( $args = '' ) {

		$defaults = array(
			'side' => 'right',
		);
		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'reactor_top_bar_args', $args );

		$output  = '<ul class="' . $args['side'] . '"><li class="has-form search-form">';
		$output  .= '<a href="#"><i class="crumicon-search"></i></a>';
		$output .= '<form role="search" method="get" id="panel-searchform" action="' . home_url() . '"><div class="row collapse show-for-small-only">';
		$output .= '<div class="large-12 small-12 columns">';
		$output .= '<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__('Search', 'crum') . '" />';
		$output .= '<input class="button prefix hide" type="submit" id="searchsubmit" value="" />';
		$output .= '<a class="close" href="#"><i class="crumicon-cross"></i></a>';
		$output .= '</div>';
		$output .= '</div></form>';
		$output .= '</li></ul>';

		return apply_filters('reactor_search_form', $output);
	}
}


/**
 * Function to use Social icons in top bar
 * this chould be used as the callback for top bar logo
 *
 * @since 1.0.0
 */
if(!function_exists('reactor_topbar_social')) {
	function reactor_topbar_social( $args = '' ) {

		$defaults = array(
			'side' => 'left',
		);
		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'reactor_top_bar_args', $args );


		global $crum_theme_option;

		$social_networks = array(
			"fb"  => "Facebook",
			"gp"  => "Google +",
			"tw"  => "Twitter",
			"in"  => "Instagram",
			"vi"  => "Vimeo",
			"lf"  => "Last FM",
			"dr"  => "Dribble",
			"vk"  => "Vkontakte",
			"yt"  => "YouTube",
			"ms"  => "Microsoft",
			"de"  => "Devianart",
			"li"  => "LinkedIN",
			"500"  => "500 px",
			"pt"  => "Pinterest",
			"wp"  => "Wordpress",
			"be"  => "Behance",
			"fli" => "Flickr",
			"rss" => "RSS",
		);
		$social_icons    = array(
			"fb"  => "soc-facebook",
			"gp"  => "soc-google",
			"tw"  => "soc-twitter",
			"in"  => "soc-instagram",
			"vi"  => "soc-vimeo",
			"lf"  => "soc-lastfm",
			"dr"  => "soc-dribbble",
			"vk"  => "soc-vkontakte",
			"yt"  => "soc-youtube",
			"ms"  => "soc-windows",
			"de"  => "soc-deviantart",
			"li"  => "soc-linkedin",
			"500" => "soc-500px",
			"pt"  => "soc-pinterest",
			"wp"  => "soc-wordpress",
			"be"  => "soc-behance",
			"fli" => "soc-flickr",
			"rss" => "soc-rss",
		);

		$output = '<span class="'.$args['side'].' soc-icons-wrap">';

		foreach ( $social_networks as $short => $original ) {
			$link = $crum_theme_option[$short . "_link"];
			$icon = $social_icons[$short];
			if ( $link != '' && $link != 'http://' ) {
				$output .= '<span><a href="' . $link . '" class="soc-icon ' . $icon . '" title="' . $original . '"></a></span>';
			}
		}
		$output .= '</span>';



		return apply_filters( 'reactor_topbar_social', $output );

	}
}



/**
 * Function to use Text in top bar
 * this chould be used as the callback for top bar menu
 *
 * @since 1.0.0
 */

if(!function_exists('reactor_topbar_text_left')) {
	function reactor_topbar_text_left($args = '') {

		$defaults = array(
			'side' => 'left',
		);
		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'reactor_top_bar_args', $args );


		global $crum_theme_option;

		$output ='';
		$left_text = ( isset ( $crum_theme_option['left-panel-text'] ) ) ? $crum_theme_option['left-panel-text'] : false;

		if($left_text){
			$output = '<span class="top-text '.$args['side'].'">';
			$output .= $left_text;
			$output .= '</span>';
		}

		return apply_filters( 'reactor_topbar_text_left', $output );

	}
}
if(!function_exists('reactor_topbar_text_right')) {
	function reactor_topbar_text_right($args = '') {

		$defaults = array(
			'side' => 'right',
		);
		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'reactor_top_bar_args', $args );

		global $crum_theme_option;

		$output ='';
		$right_text = ( isset ( $crum_theme_option['right-panel-text'] ) ) ? $crum_theme_option['right-panel-text'] : false;

		if($right_text){
			$output = '<span class="top-text '.$args['side'].'">';
			$output .= $right_text;
			$output .= '</span>';
		}

		return apply_filters( 'reactor_topbar_text_right', $output );

	}
}


/**
 * Function to use Woocommerce cart in top panel
 * this chould be used as the callback for top bar menu
 *
 * @since 1.0.0
 */


if ( ! function_exists( 'reactor_minicart_l' ) ) {
	function reactor_minicart_l( $args = '' ) {

		if ( class_exists( 'Woocommerce' ) ) {

			global $woocommerce;

			$defaults = array(
				'side' => 'left',
			);
			$args     = wp_parse_args( $args, $defaults );
			$args     = apply_filters( 'reactor_top_bar_args', $args );

			$output = '<span class="minicart-wrap ' . $args['side'] . '"><i class="embrace-shopping_bag2"></i><a class="cart-contents" href="' . $woocommerce->cart->get_cart_url() . '" title="' . __( 'View your shopping cart', 'crum' ) . '">' . sprintf( _n( '%d item', '%d items', $woocommerce->cart->cart_contents_count, 'crum' ), $woocommerce->cart->cart_contents_count ) . ' - ' . $woocommerce->cart->get_cart_total() . '</a></span>';

			return apply_filters( 'reactor_minicart_l', $output );
		}
	}
}
if ( ! function_exists( 'reactor_minicart_r' ) ) {
	function reactor_minicart_r( $args = '' ) {
		if ( class_exists( 'Woocommerce' ) ) {

			global $woocommerce;

			$defaults = array(
				'side' => 'right',
			);
			$args     = wp_parse_args( $args, $defaults );
			$args     = apply_filters( 'reactor_top_bar_args', $args );

			$output = '<span class="minicart-wrap ' . $args['side'] . '"><i class="crum-icon  crum-cart"></i><a class="cart-contents" href="' . $woocommerce->cart->get_cart_url() . '" title="' . __( 'View your shopping cart', 'crum' ) . '">' . sprintf( _n( '%d item', '%d items', $woocommerce->cart->cart_contents_count, 'crum' ), $woocommerce->cart->cart_contents_count ) . ' - ' . $woocommerce->cart->get_cart_total() . '</a></span>';

			return apply_filters( 'reactor_minicart_r', $output );
		}
	}
}

if ( ! function_exists( 'reactor_toplang_r' ) ) {
	function reactor_toplang_r( $args = '' ) {

		if ( function_exists( 'icl_get_languages' ) ) {

			$defaults = array(
				'side' => 'right',
			);
			$args     = wp_parse_args( $args, $defaults );
			$args     = apply_filters( 'reactor_top_bar_args', $args );

			$output = '<div class="lang-sel ' . $args['side'] . '">' . reactor_language_selector() . '</div>';

		}

		return apply_filters( 'reactor_toplang_r', $output );
	}
}

if ( ! function_exists( 'reactor_toplang_l' ) ) {
	function reactor_toplang_l( $args = '' ) {
		if ( function_exists( 'icl_get_languages' ) ) {

			$defaults = array(
				'side' => 'left',
			);
			$args     = wp_parse_args( $args, $defaults );
			$args     = apply_filters( 'reactor_top_bar_args', $args );

			$output = '<div class="lang-sel ' . $args['side'] . '">' . reactor_language_selector() . '</div>';

			return apply_filters( 'reactor_toplang_l', $output );
		}
	}
}





function reactor_language_selector() {

	$html = '<a href="#"><i class="crum-icon crum-earth"></i><strong> '. __( 'Change your language:', 'crum' ) .'</strong>'.  ICL_LANGUAGE_NAME_EN .'</a>';
	$html .= '<ul>';
	if ( function_exists( 'pll_the_languages' ) ) {
		$html .= pll_the_languages();
	}
	elseif ( function_exists( 'icl_get_languages' ) ) {
		$languages = icl_get_languages( 'skip_missing=0&orderby=code' );
		if ( ! empty( $languages ) ) {
			foreach ( $languages as $l ) {
				$html .= '<li>';
				$html .= '<a href="' . $l['url'] . '">';
				$html .=  '<img src="' . $l['country_flag_url'] . '" height="12" alt="' . $l['language_code'] . '" width="18" /> ';
				$html .=  $l['translated_name'];
				$html .=  '</a>';
				$html .=  '</li>';
			}
		}
	}
	$html .= '</ul>';

	return $html;
}
