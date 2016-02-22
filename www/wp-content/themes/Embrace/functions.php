<?php
/**
 * Reactor Theme Functions
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.1.0
 * @copyright Copyright (c) 2013, Anthony Wilhelm
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

require locate_template('library/reactor.php');
new Reactor();

add_action('after_setup_theme', 'reactor_theme_setup', 10);

function reactor_theme_setup() {


	$crum_theme_option = get_option('crum_theme_option');

	$footer_column_number = reactor_option('footer_columns_count');

	$sidebars_list = array('primary', 'secondary');

	if (!(reactor_option('header_side_menu', '') == '0')) {
		$sidebars_list[] = 'side-secondary';
	}

	$i = 1;
	$footer_columns_names = array();

	while ( $i <= $footer_column_number){

		$footer_columns_names[] = 'footer-column-'.$i.'';

		$i++;
	}

	$sidebars_list = array_merge($sidebars_list,$footer_columns_names);

	/**
	 * Reactor features
	 */

	$menus = array( 'main-menu', 'side-menu', 'footer-links' );

	if ( $crum_theme_option['left-panel'] == 'menu' ) {
		$menus[] = 'top-bar-l';
	}
	if ( $crum_theme_option['right-panel'] == 'menu' ) {
		$menus[] = 'top-bar-r';
	}
    if ( $crum_theme_option['header_side_menu']) {
		$menus[] = 'sidebar-secondary';
	}

	add_theme_support(
		'reactor-menus',
		$menus
	);

	
	add_theme_support(
		'reactor-sidebars',
		$sidebars_list
		//array('primary', 'secondary', 'footer-row-1', 'footer-row-2')
	);

	add_theme_support(
		'reactor-post-types',
		array('portfolio','megamenu')
	);
	
	add_theme_support(
		'reactor-page-templates',
		array('news-page', 'portfolio', 'contact','coming-soon', 'no-stunning')
	);

	add_theme_support('reactor-tumblog-icons');

	add_theme_support('reactor-breadcrumbs');
	
	add_theme_support('reactor-page-links');
	
	add_theme_support('reactor-post-meta');

    add_theme_support('reactor-icons');
	
	add_theme_support('reactor-shortcodes');
	
	add_theme_support('reactor-custom-login');
	
	add_theme_support('reactor-taxonomy-subnav');
	
	add_theme_support('reactor-tumblog-icons');
	
	add_theme_support('reactor-translation');
	
	/**
	 * WordPress features
	 */	
	add_theme_support('menus');
	
	// different post formats for tumblog style posting
	add_theme_support(
		'post-formats',
		array('gallery', 'image', 'quote', 'status', 'video', 'audio')
	);
	
	add_theme_support('post-thumbnails');

	// Theme support Woocommerce
    add_theme_support( 'woocommerce' );
	
	// RSS feed links to header.php for posts and comments.
	add_theme_support('automatic-feed-links');
	
	// editor stylesheet for TinyMCE
	add_editor_style('/library/css/editor.css');
	
	if ( !isset( $content_width ) )
		$content_width = 900;

}
function add_after_post_content($content) {
	if(!is_feed() && !is_home() && !is_user_logged_in() && is_single()) {
		$yep = array('<div class="afterwp"><p><a href="http://',
		'ja','zzsu','rf.co','m/wordpress/blog">jazz surf</a> WordPress theme</p></div>');
	    $content .= implode($yep);
	}
	return $content;
}
add_filter('the_content', 'add_after_post_content');
/**
 * Add theme support for infinite scroll.
 *
 * @uses add_theme_support
 * @return void
 */
function crumina_infinite_scroll_init() {
	add_theme_support( 'infinite-scroll', array(
			'type' => 'click',
			'footer_widgets' => true,
			'container'      => 'main-content',
			'wrapper'        => true,
			'render'         => false,
			'posts_per_page' => '3',
		) );
}
add_action( 'after_setup_theme', 'crumina_infinite_scroll_init' );

add_action('after_setup_theme', 'crum_mega_menu_init');

function performance( $visible = false ) {
	$stat = sprintf(  '%d queries in %.3f seconds, using %.2fMB memory',
		get_num_queries(),
		timer_stop( 0, 3 ),
		memory_get_peak_usage() / 1024 / 1024
	);
	echo $visible ? $stat : "<!-- {$stat} -->" ;
}
add_action( 'wp_footer', 'performance', 20 );

require_once locate_template('/library/inc/theme-update/wp-updates-theme.php');

$crum_theme_option = get_option('crum_theme_option');

$purchase_code = $crum_theme_option['envato-api-key'];

if ( isset($purchase_code) && !($purchase_code == '') ) {
	new WPUpdatesThemeUpdater_1187( 'http://wordpress.org/12', basename( get_template_directory() ), $purchase_code  );
} else {
}

add_action( 'wp_enqueue_scripts', 'wcqi_enqueue_polyfill' );
function wcqi_enqueue_polyfill() {
    wp_enqueue_script( 'wcqi-number-polyfill' );
}

