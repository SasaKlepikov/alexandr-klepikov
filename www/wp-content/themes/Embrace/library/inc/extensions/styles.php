<?php
/**
 * Styles
 * WordPress will add these style sheets to the theme header
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/wp_register_style
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 * @see wp_register_style
 * @see wp_enqueue_style
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * Reactor Styles
 *
 * @since 1.0.0
 */


if ( class_exists( 'woocommerce' ) ) {
	if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
		add_filter( 'woocommerce_enqueue_styles', '__return_false' );
	}
	else {
		define( 'WOOCOMMERCE_USE_CSS', false );
	}
}


add_action('wp_enqueue_scripts', 'reactor_register_styles', 1);
add_action('wp_enqueue_scripts', 'reactor_enqueue_styles', 5);
add_action('wp_enqueue_scripts', 'crum_replace_woocommerce_css',99);
add_action('wp_enqueue_scripts', 'crum_theme_styles',99 );
//add_action('wp_enqueue_scripts', 'reactor_ie_styles', 99);
add_action('wp_enqueue_scripts', 'reactor_responsive', 99);



function reactor_register_styles() {
	// register styles
	wp_register_style('foundation', get_template_directory_uri() . '/library/css/foundation.css', array(), false, 'all');
	wp_register_style('app', get_template_directory_uri() . '/library/css/style.css', array(), false, 'all');
	wp_register_style('app-vc', get_template_directory_uri() . '/library/css/style-vc.css', array(), false, 'all');
    wp_register_style('woocommerce-css', get_template_directory_uri() . '/library/css/woocommerce.css', array(), false, 'all');
	wp_register_style('style', get_stylesheet_directory_uri() . '/style.css', array(), false, 'all');
	wp_register_style('responsive', get_template_directory_uri() . '/library/css/responsive.css', array(), false, 'all');

    wp_register_style('source-sans-pro', '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic&subset=latin,latin-ext');
    wp_register_style('museo-font', get_template_directory_uri() . '/library/fonts/museo-font.css', array(), false, 'all');
	wp_register_style('magnificPopup', get_template_directory_uri() . '/library/css/magnific-popup.css', array(), false, 'all');
	wp_register_style( 'tooltipster_css', get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/css/tooltipster.css', array(), false, 'all' );

	$crum_theme_option    = get_option( 'crum_theme_option' );
	$custom_typography_h1 = $crum_theme_option['headings-font-h1'];
	$custom_typography_h2 = $crum_theme_option['headings-font-h2'];
	$custom_typography_h3 = $crum_theme_option['headings-font-h3'];
	$custom_typography_h4 = $crum_theme_option['headings-font-h4'];
	$custom_typography_h5 = $crum_theme_option['headings-font-h5'];
	$custom_typography_h6 = $crum_theme_option['headings-font-h6'];

	if ( isset( $custom_typography_h1['font-family'] ) && ! ( empty( $custom_typography_h1['font-family'] ) ) && ( 'true' === $custom_typography_h1['google'] ) ) {
		if ( isset($custom_typography_h1['subsets']) && !(empty($custom_typography_h1['subsets'])) ) {
			$typography_selected_styles = $custom_typography_h1['subsets'];
		} else {
			$typography_selected_styles = 'latin,greek,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic';
		}
		$enqueue_fonts              = $custom_typography_h1['font-family'] . '&subset=' . $typography_selected_styles;
		wp_enqueue_style( 'custom_typography_h1-fonts', esc_url( add_query_arg( 'family', urlencode( $enqueue_fonts ), '//fonts.googleapis.com/css' ) ), array(), null );
	}

	if ( isset( $custom_typography_h2['font-family'] ) && ! ( empty( $custom_typography_h2['font-family'] ) ) && ( 'true' === $custom_typography_h2['google'] ) ) {
		$typography_selected_styles = 'latin,greek,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic';
		$enqueue_fonts              = $custom_typography_h2['font-family'] . '&subset=' . $typography_selected_styles;
		wp_enqueue_style( 'custom_typography_h2-fonts', esc_url( add_query_arg( 'family', urlencode( $enqueue_fonts ), '//fonts.googleapis.com/css' ) ), array(), null );
	}

	if ( isset( $custom_typography_h3['font-family'] ) && ! ( empty( $custom_typography_h3['font-family'] ) ) && ( 'true' === $custom_typography_h3['google'] ) ) {
		$typography_selected_styles = 'latin,greek,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic';
		$enqueue_fonts              = $custom_typography_h3['font-family'] . '&subset=' . $typography_selected_styles;
		wp_enqueue_style( 'custom_typography_h3-fonts', esc_url( add_query_arg( 'family', urlencode( $enqueue_fonts ), '//fonts.googleapis.com/css' ) ), array(), null );
	}

	if ( isset( $custom_typography_h4['font-family'] ) && ! ( empty( $custom_typography_h4['font-family'] ) ) && ( 'true' === $custom_typography_h4['google'] ) ) {
		$typography_selected_styles = 'latin,greek,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic';
		$enqueue_fonts              = $custom_typography_h4['font-family'] . '&subset=' . $typography_selected_styles;
		wp_enqueue_style( 'custom_typography_h4-fonts', esc_url( add_query_arg( 'family', urlencode( $enqueue_fonts ), '//fonts.googleapis.com/css' ) ), array(), null );
	}

	if ( isset( $custom_typography_h5['font-family'] ) && ! ( empty( $custom_typography_h5['font-family'] ) ) && ( 'true' === $custom_typography_h5['google'] ) ) {
		$typography_selected_styles = 'latin,greek,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic';
		$enqueue_fonts              = $custom_typography_h5['font-family'] . '&subset=' . $typography_selected_styles;
		wp_enqueue_style( 'custom_typography_h5-fonts', esc_url( add_query_arg( 'family', urlencode( $enqueue_fonts ), '//fonts.googleapis.com/css' ) ), array(), null );
	}

	if ( isset( $custom_typography_h6['font-family'] ) && ! ( empty( $custom_typography_h6['font-family'] ) ) && ( 'true' === $custom_typography_h6['google'] ) ) {
		$typography_selected_styles = 'latin,greek,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic';
		$enqueue_fonts              = $custom_typography_h6['font-family'] . '&subset=' . $typography_selected_styles;
		wp_enqueue_style( 'custom_typography_h6-fonts', esc_url( add_query_arg( 'family', urlencode( $enqueue_fonts ), '//fonts.googleapis.com/css' ) ), array(), null );
	}

}

function reactor_enqueue_styles() {
	if ( !is_admin() ) { 
		// enqueue styles
		wp_enqueue_style('foundation');
		wp_enqueue_style('app');
		wp_enqueue_style('app-vc');
        wp_enqueue_style( 'source-sans-pro');
        wp_enqueue_style( 'museo-font');
		wp_enqueue_style( 'magnificPopup');

        // add style.css with child themes
		if ( is_child_theme() ) {
			wp_enqueue_style('style');
		}
	}
}

function reactor_responsive() {
	$responsive_mode = reactor_option('responsive_mode');

	if ( $responsive_mode == '1' ) {
		wp_enqueue_style( 'responsive' );
	}
}

function crum_replace_woocommerce_css() {

	/*turn-off woocommerce css*/
    if ( class_exists('woocommerce')  ) {
		wp_enqueue_style('woocommerce-css');
    }

}

/**
 * IE Styles
 * IE8 doesn't work well with Foundation 4
 * So we need to patch it up a bit
 * 
 * @since 1.0.0
 */

function reactor_ie_styles() {
	
	// load css for IE8
	wp_enqueue_style('ie8-style', get_template_directory_uri() . '/library/css/ie8.css');
	global $wp_styles;
	$wp_styles->add_data('ie8-style', 'conditional', 'lte IE 8');
	
}

if(!(function_exists('adjustBrightness'))) {
	function adjustBrightness( $hex, $steps ) {
		// Steps should be between -255 and 255. Negative = darker, positive = lighter
		$steps = max( - 255, min( 255, $steps ) );

		// Format the hex color string
		$hex = str_replace( '#', '', $hex );
		if ( strlen( $hex ) == 3 ) {
			$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
		}

		// Get decimal values
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );

		// Adjust number of steps and keep it inside 0 to 255
		$r = max( 0, min( 255, $r + $steps ) );
		$g = max( 0, min( 255, $g + $steps ) );
		$b = max( 0, min( 255, $b + $steps ) );

		$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
		$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
		$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

		return '#' . $r_hex . $g_hex . $b_hex;
	}
}

function crum_theme_styles() {
	wp_enqueue_style('crum', get_template_directory_uri() . '/library/css/style.css', array(), false, 'all');

	$crum_theme_option = get_option('crum_theme_option');

	$main_site_color = isset($crum_theme_option['main_site_color']) ? $crum_theme_option['main_site_color'] : '';
	$secondary_site_color = isset($crum_theme_option['secondary_site_color']) ? $crum_theme_option['secondary_site_color'] : '';

	$link_color_regular = isset($crum_theme_option['link-color']['regular']) ? $crum_theme_option['link-color']['regular'] : '';
	$link_color_hover  = isset($crum_theme_option['link-color']['hover']) ? $crum_theme_option['link-color']['hover'] : '';
	$link_color_active = isset($crum_theme_option['link-color']['active']) ? $crum_theme_option['link-color']['active'] : '';

	$css_code = isset($crum_theme_option['css-code']) ? $crum_theme_option['css-code'] : '';

	$custom_css  = '';

	if($link_color_regular)
		$custom_css .= 'a{color:'.$link_color_regular.'}';
	if($link_color_hover)
		$custom_css .= 'a:hover{color:'.$link_color_hover.'}';
	if($link_color_active)
		$custom_css .= 'a:active{color:'.$link_color_active.'}';

	if($main_site_color) {
		$custom_css .= '.minicart-wrap:hover, .top-bar-section ul li.search-form:hover>a,
		.woocommerce .products .wrap-other a:hover, .category-submenu dd a:hover,
		article.post .entry-meta a:hover, .mini-news .entry-meta a:hover, .pagination li .page-numbers:hover, article.post .comments-link a:hover,
		#footer #linkTop:hover, h2 a:hover, .subheader a:hover, h4 a:hover, .bock-recent-posts .entry-meta a:hover, .widget_recent_comments ul > li a,
		 #footer a:hover, #buddypress div.item-list-tabs ul li a:hover, #latest-update a:hover,
		 .entry-title a:hover, a,

		.page-numbers li a.page-numbers, #content .bbp-body .topic .bbp-topic-freshness .bbp-topic-meta .bbp-topic-freshness-author a, a, .accordion dd.active > a,
		.highlight .pricing-title h3, .highlight-reason, .crumina-testimonials .testimonials-slider .titles li .selected h3, .latest_tweets_slider i,
		#buddypress div#item-nav div.item-list-tabs ul li a span, .bbp-author-name, .ult_price_body .ult_price .ult_price_figure, .ult_price_body .ult_price .ult_price_term,
		.product .ms-lightbox,

		.woocommerce .products .amount, .woocommerce .star-rating, .woocommerce-page .star-rating, .woocommerce div.product .price, .product .cart .button,
		.cta-button .button, .woocommerce .products .wrap-other a:hover, .product_list_widget li a:hover,
		.product-categories a:hover, .single-product .entry-summary .price

		{color:'.$main_site_color.'} ';

		$custom_css .= '.style_4 .aio-icon-box:hover .aio-icon {color:'.$main_site_color.' !important} ';

		$custom_css .= '.menu-primary-navigation>li.showhide, .soc-icons-wrap a:hover,
		.price_slider_amount .button:hover, ul.pagination li.current a:hover,
		.product .cart .button:hover, .button:hover, #wp-submit:hover, .cta-button .button:hover, button:hover,
		.ajax-pagination a:hover, .ajax-pagination a.loading, #buddypress div.generic-button a:hover,
		.button:hover, .button:focus, .button:hover, .button:focus, #submit:hover, #submit:focus, #wp-submit:hover, #wp-submit:focus,
		.nav-buttons a:focus, .nav-buttons a:hover,

		 ul.pagination li.current a, #content #buddypress ul.button-nav li.current a,
		.button, .filter-button.active, #cd-cart-trigger .count, .small-format .entry-thumb .overlay, button, .button, #submit, #wp-submit,
		.ult_pricing_table_wrap.ult_design_1 .ult_pricing_heading, .ult_info_table.ult_design_1 .ult_pricing_heading,
		.ult_pricing_table_wrap.ult_design_2 .ult_price_body_block, .ult_info_table.ult_design_2 .ult_price_body_block,
		.ult_pricing_table_wrap.ult_design_3 .ult_price_body_block, .ult_info_table.ult_design_3 .ult_price_body_block,
		.ult_pricing_table_wrap.ult_design_4 .ult_pricing_heading, .ult_info_table.ult_design_4 .ult_pricing_heading,
		.ult_pricing_table_wrap.ult_design_6 .ult_price_body_block, .ult_info_table.ult_design_6 .ult_price_body_block,
		.ult_pricing_table_wrap.ult_design_7 .ult_price_body_block, .ult_info_table.ult_design_7 .ult_price_body_block,
		.ult_pricing_table_wrap.ult_design_8 .ult_price_body_block, .ult_info_table.ult_design_8 .ult_price_body_block,
		.ult_pricing_table_wrap.ult_design_9 .ult_price_body_block, .ult_info_table.ult_design_9 .ult_price_body_block,

		.woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-range,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle, .onsale,
		 .bookmarks .data, button, .button, #wp-submit, #submit, .countdown .circle, #content .timeline-separator-text .sep-text,
		  #content .timeline-wrapper .timeline-dot, #content .timeline-feature-item .timeline-dot, .cd-timeline-img i,
		  .pagination .page-numbers.current, #buddypress div.item-list-tabs ul li.current a, #buddypress a.button, .project-description .vc_btn,
		  .read-more-button .button, .contact-form-div .button, #subscribe input.button,

		 .block-title:before, .widget .widget-title:before, header.title-portfolio:before, article.post .entry-header:before,
		.title-block.underlined .line:before,

		#main-wrapper .crumina-slider-wrap .active .click-section

		{background-color:'.$main_site_color.'} ';

		$custom_css .= '#content a.aio-icon-box-link:hover .aio-icon {background-color:'.$main_site_color.' !important} ';
		$custom_css .= 'a.aio-icon-box-link:hover .aio-icon {border-color:'.$main_site_color.' !important} ';
		$custom_css .= '#buddypress input[type=submit], #buddypress #whats-new-options #aw-whats-new-submit {background-color:'.$main_site_color.' !important} ';

		$custom_css .= '.category-submenu , ul.foot-tw-direction-nav>li>a:hover,  .price_slider_amount .button:hover,
		.tagcloud a:hover, .gridlist-toggle i:hover, .nav-buttons .nav-next a:hover, .nav-buttons .nav-previous a:hover, .entry-thumbnail .links a:hover,
		a.aio-icon-box-link:hover .aio-icon, .crumina-testimonials .testimonials-nav:hover, .flex-direction-nav a:hover, .inner-footer .tagcloud a:hover,
		.filter-button.active, .ajax-pagination a:hover, .ajax-pagination a.loading, .pagination .page-numbers.current, .pagination .content-nav a:hover,

		.woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle, .aio-icon,
		.gridlist-toggle .active i,  .pagination li .page-numbers.current, .product .cart .button, .crumina-testimonials .testimonials-slider .titles li .selected img,

		.crumina-timeline-horizontal .timeline-horizontal .timeline-titles li a.selected .dot:before, .contact-form-div form input:focus, .contact-form-div form textarea:focus,
		#submit:hover, #review_form_wrapper #respond .form-submit #submit:focus, #wp-submit:hover, #wp-submit:focus

		{border-color:'.$main_site_color.'} ';
        $custom_css .= '.style_4 .aio-icon-box:hover .aio-icon{border-color:'.$main_site_color.'!important} ';
        $custom_css .= 'dl dd.active a, .tabs dd.active a{border-bottom-color:'.$main_site_color.'!important} ';
		$custom_css .= '#buddypress div#item-nav div.item-list-tabs ul li.current a{border-bottom: 1px solid '.adjustBrightness($main_site_color, -26).';}';

		$custom_css .= '.ult_pricing_table_wrap.ult_design_6 .ult_price_body_block .oval, .ult_info_table.ult_design_6 .ult_price_body_block .oval {box-shadow: 0 5px 5px '.adjustBrightness($main_site_color, -26).';}';

		$custom_css .= '.ult_pricing_table_wrap.ult_design_7 .ult_price_body_block {box-shadow: inset 0 5px 5px '.adjustBrightness($main_site_color, -26).';}';
		$custom_css .= '.ult_pricing_table_wrap.ult_design_7 .ult_price_body_block .additional-square, .ult_info_table.ult_design_7 .ult_price_body_block .additional-square {box-shadow: 3px 3px 3px '.adjustBrightness($main_site_color, -26).';}';
		$custom_css .= '.ult_pricing_table_wrap.ult_design_8 .ult_price_body_block {box-shadow: 5px 0 0 0 '.$main_site_color.', -5px 0 0 0 '.$main_site_color.';}';
		$custom_css .= '.ult_pricing_table_wrap.ult_design_9 .ult_price_body_block {box-shadow: 5px 0 0 0 '.$main_site_color.', -5px 0 0 0 '.$main_site_color.';}';


	}

	if($secondary_site_color) {
		$custom_css .= '.vc_progress_bar .vc_label_units, .single-product .star-rating span, .woocommerce .star-rating:before, .woocommerce-page .star-rating:before,
		.woocommerce .star-rating span, .woocommerce-page .star-rating span

		{color:'.$secondary_site_color.'} ';

		$custom_css .= '.style_5 .aio-icon-box:hover .aio-icon {color:'.$secondary_site_color.' !important} ';

		$custom_css .= '#cd-cart-trigger:hover .count, .vc_progress_bar .vc_bar_wrapper, .vc_progress_bar .vc_bar, .ult_pricing_table_wrap .aio-icon, .ult_info_table .aio-icon,
		.woocommerce div.product form.cart .single_add_to_cart_button, .woocommerce #content div.product form.cart .single_add_to_cart_button,
		.woocommerce-page div.product form.cart .single_add_to_cart_button, .woocommerce-page #content div.product form.cart .single_add_to_cart_button,
		.crum_cd_4.ult_countdown .ult_countdown-section:last-child .ult_countdown-amount

		{background-color:'.$secondary_site_color.'} ';

		$custom_css .= '.woocommerce div.product form.cart .single_add_to_cart_button, .woocommerce #content div.product form.cart .single_add_to_cart_button,
		.woocommerce-page div.product form.cart .single_add_to_cart_button, .woocommerce-page #content div.product form.cart .single_add_to_cart_button

		{border-color:'.$secondary_site_color.'} ';

	}

	/*
		 * Content
		 */
	if (isset($crum_theme_option["wrapper_bg_color"]) && !($crum_theme_option["wrapper_bg_color"] == '')){
		$custom_css .=  '#primary,#stunning-header,#main-wrapper{ background-color: '.$crum_theme_option["wrapper_bg_color"].'}  ';
	}
	if (isset($crum_theme_option["wrapper_bg_image"]) && !($crum_theme_option["wrapper_bg_image"] == '')){
		$custom_css .=  '#primary,#main-wrapper{ background-image: url("'.$crum_theme_option["wrapper_bg_image"]['url'].' " ); background-position: 0 center !important }  ';
	}
	if (isset($crum_theme_option["wrapper_background_fixed"]) && !($crum_theme_option["wrapper_background_fixed"] == '')){
		$custom_css .=  '#main-wrapper{ background-attachment :fixed}  ';
	}
	if (isset($crum_theme_option["wrapper_custom_repeat"]) && !($crum_theme_option["wrapper_custom_repeat"] == '')){
		$custom_css .=  '#primary,#main-wrapper{ background-repeat: '.$crum_theme_option["wrapper_custom_repeat"].'}  ';
	}

	/*
	 * Top Panel
	 * */

	$top_panel_bg_color = reactor_option('top_panel_bg_color','');
	$top_panel_text_color = reactor_option('top_panel_text_color','');

	if (isset($top_panel_bg_color) && !($top_panel_bg_color == '')){
		$custom_css .= '.contain-to-grid .top-bar{background:'.$top_panel_bg_color.'}';
	}

	if (isset($top_panel_text_color) && !($top_panel_text_color == '')){
		$custom_css .= '.top-bar-section a, .top-bar-section span{color:'.$top_panel_text_color.'}';
		$custom_css .= '.top-bar-section > ul > .divider{border-right: 1px solid '.$top_panel_text_color.'}';
		$custom_css .= '.top-bar{color:'.$top_panel_text_color.'}';
	}

	/*
	 * Mobile menu
	 */

	$mobile_menu_bg = reactor_option('mobile_menu_bg_color');
	$mobile_menu_text = reactor_option('mobile_menu_text_color');

	if(isset($mobile_menu_bg) && !($mobile_menu_bg == '')){
		$custom_css .= '@media(max-width:768px){';
		$custom_css .= '.menu-primary-navigation > li.showhide{background: '.$mobile_menu_bg.'}';
		$custom_css .= '.menu-primary-navigation > li a {background-color: '.$mobile_menu_bg.'}';
		$custom_css .= '.menu-primary-navigation > li:hover > a {background-color: '.adjustBrightness($mobile_menu_bg, 26).' !important}';
		$custom_css .= '}';
	}

	if (isset($mobile_menu_text) && !($mobile_menu_text == '')){
		$custom_css .= '@media(max-width:768px){';
		$custom_css .= '.menu-primary-navigation > li.showhide{ color: '.$mobile_menu_text.'}';
		$custom_css .= '.menu-primary-navigation > li.showhide .icon em { background-color: '.$mobile_menu_text.' }';
		$custom_css .= '.menu-primary-navigation > li a{ color:'.$mobile_menu_text.' }';
		$custom_css .= '.menu-primary-navigation ul.dropdown li a{ color: '.$mobile_menu_text.' }';
		$custom_css .= '.menu-primary-navigation ul.dropdown li:hover > a{ color: '.adjustBrightness($mobile_menu_text,26).' }';
		$custom_css .= '}';
	}

	/*
	* Body
	*/

	$boxed_body      = reactor_option( 'switch-boxed', '' );
	$meta_boxed_body = reactor_option( '', '', '_page_boxed_layout' );
	if ( isset( $meta_boxed_body ) && ! ( $meta_boxed_body == 'default' ) && ! ( $meta_boxed_body == '' ) ) {
		if ( $meta_boxed_body == 'on' ) {
			$boxed_body = '1';
		} elseif ( $meta_boxed_body == 'off' ) {
			$boxed_body = '0';
		}
	}

	if ( $boxed_body == '1' ) {

		$body_bg_image  = reactor_option( "body_background_image" );
		$body_bg_color  = reactor_option( "body_background_color" );
		$body_bg_fixed  = reactor_option( "body_background_fixed" );
		$body_bg_repeat = reactor_option( "body_custom_repeat" );

		$custom_boxed_bg_image  = reactor_option( '', '', '_page_boxed_bg_image' );
		$custom_boxed_bg_color  = reactor_option( '', '', '_page_boxed_bg_color' );
		$custom_boxed_bg_fixed  = reactor_option( '', '', '_page_boxed_bg_fixed' );
		$custom_boxed_bg_repeat = reactor_option( '', '', '_page_boxed_bg_repeat' );


		if ( isset( $custom_boxed_bg_image ) && ! ( $custom_boxed_bg_image == '' ) ) {
			$body_bg_image['url'] = $custom_boxed_bg_image;
		}

		if ( isset( $custom_boxed_bg_color ) && ! ( $custom_boxed_bg_color == '' ) ) {
			$body_bg_color = $custom_boxed_bg_color;
			$body_bg_image = '';
		}

		if ( isset( $custom_boxed_bg_fixed ) && ! ( $custom_boxed_bg_fixed == '' ) && ! ( $custom_boxed_bg_fixed == 'default' ) ) {
			$body_bg_fixed = $custom_boxed_bg_fixed;
		}

		if ( isset( $custom_boxed_bg_repeat ) && ! ( $custom_boxed_bg_repeat == '' && ! ( $custom_boxed_bg_repeat == 'default' ) ) ) {
			$body_bg_repeat = $custom_boxed_bg_repeat;
		}


		if ( isset( $body_bg_image ) && ! ( $body_bg_image == '' ) ) {
			$custom_css .= 'body{ background-image: url("' . $body_bg_image['url'] . ' " ); background-position: 0 center }  ';
		}
		if ( isset( $body_bg_color ) && ! ( $body_bg_color == '' ) ) {
			$custom_css .= 'body{ background-color: ' . $body_bg_color . '}  ';
		}
		if ( isset( $body_bg_fixed ) && ! ( $body_bg_fixed == '0' ) ) {
			$custom_css .= 'body{ background-attachment :fixed}  ';
		}
		if ( isset( $body_bg_repeat ) && ! ( $body_bg_repeat == '' ) ) {
			$custom_css .= 'body{ background-repeat: ' . $body_bg_repeat . '}  ';
		}
	}

	/*
		 * Footer
		 */

	if (isset($crum_theme_option["footer_bg_image"]) && !($crum_theme_option["footer_bg_image"] == '')){
		$custom_css .=  '#footer{ background-image: url("'.$crum_theme_option["footer_bg_image"]['url'].' " ); background-position: 0 center }  ';
	}
	if (isset($crum_theme_option["footer_bg_color"]) && !($crum_theme_option["footer_bg_color"] == '')){
		$custom_css .=  '#footer{ background-color: '.$crum_theme_option["footer_bg_color"].'}  ';
	}
	if (isset($crum_theme_option["footer_custom_repeat"]) && !($crum_theme_option["footer_custom_repeat"] == '')){
		$custom_css .=  '#footer{ background-repeat: '.$crum_theme_option["footer_custom_repeat"].'}  ';
	}
	if (isset($crum_theme_option["footer_font_color"]) && !($crum_theme_option["footer_font_color"] == '')){
		$custom_css .=  '.inner-footer p, .site-info p,
		.inner-footer p, .inner-footer span, .inner-footer .widget ul > li a, .inner-footer .widget ul > li a,
		.inner-footer .widget ul > li:before, .inner-footer .widget ol > li a, #recentcomments .recentcomments,
		.inner-footer .widget ol > li:before, #footer .inner-footer p a, .inner-footer span a, .inner-footer #searchform i,
		#searchform input[type="text"], .site-info .inline-list li > a, .inner-footer #wp-calendar caption,
		.inner-footer .textwidget{ color: '.$crum_theme_option["footer_font_color"].'}  ';
	}
	if (isset($crum_theme_option["footer_font_color"]) && !($crum_theme_option["footer_font_color"] == '')){
		$custom_css .=  '#footer a:hover { color: '.$crum_theme_option["footer_font_color"].'}  ';
	}


	if (isset($crum_theme_option["footer_font_color"]) && !($crum_theme_option["footer_font_color"] == '')){
		$custom_css .=  '.inner-footer a { color: '.$crum_theme_option["footer_font_color"].'}  ';
		$custom_css .=  '.inner-footer .widget-title { color: '.$crum_theme_option["footer_font_color"].' !important}  ';
		$custom_css .=  '.inner-footer .tagcloud a, .inner-footer input[type="text"] {border-color: '.$crum_theme_option["footer_font_color"].' !important}  ';
		$custom_css .=  '.inner-footer .widget_crum_widget_tabs > dl > dd.active a {border-bottom-color: '.$crum_theme_option["footer_font_color"].' !important}  ';
	}

	/*
		 * Sub-footer
		 */

	if (isset($crum_theme_option["footer_bg_image"]) && !($crum_theme_option["footer_bg_image"] == '')){
		$custom_css .=  '.site-info{ background: none; }  ';
	}

	if (isset($crum_theme_option["footer_custom_repeat"]) && !($crum_theme_option["footer_custom_repeat"] == '')){
		$custom_css .=  '.site-info{ background-repeat: '.$crum_theme_option["footer_custom_repeat"].'}  ';
	}
	if (isset($crum_theme_option["footer_font_color"]) && !($crum_theme_option["footer_font_color"] == '')){
		$custom_css .=  '.site-info{ color: '.$crum_theme_option["footer_font_color"].'}  ';
	}
	if (isset($crum_theme_option["footer_font_color"]) && !($crum_theme_option["footer_font_color"] == '')){
		$custom_css .=  '.site-info a{ color: '.$crum_theme_option["footer_font_color"].'}  ';
	}

	$custom_css .= crum_typography_option('headings-font-h1','h1');
	$custom_css .= crum_typography_option('headings-font-h2','h2');
	$custom_css .= crum_typography_option('headings-font-h3','h3');
	$custom_css .= crum_typography_option('headings-font-h4','h4');
	$custom_css .= crum_typography_option('headings-font-h5','h5');
	$custom_css .= crum_typography_option('headings-font-h6','h6');


	$custom_css  .= $css_code;
	wp_add_inline_style('crum', $custom_css );
}

function crum_convert_hex_to_rgb($hex) 
{
    $hex = str_replace("#", "", $hex);

    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    $rgb = array($r, $g, $b);
    return implode(",", $rgb);
}