<?php
/**
 * Customize Login
 * Portfolio, Slider and custom taxonomies
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @link http://wp.smashingmagazine.com/2012/05/17/customize-wordpress-admin-easily/
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * 1. Change logo on login page
 * 2. Custom logo link url
 * 3. Logo title attribute text
 * 4. Change the order of admin menu items
 */

/**
 * 1. Change logo on login page
 *
 * @since 1.0.0
 */
function reactor_login_logo() {
	if ( reactor_option('login_logo') ) {
		$logo_path = reactor_option('login_logo' );
		if ( !($logo_path['url'] == '') ) {
			echo '<style type="text/css">
			.login h1 a {
			 width:300px !important;
			background-image:url(' . $logo_path['url'] . ') !important;
			background-size: contain !important;
	}
		</style>';

		}}
}
add_action('login_head', 'reactor_login_logo');

/**
 * 2. Custom logo link url
 *
 * @since 1.0.0
 */
function reactor_login_logo_url() {
	if ( reactor_option('login_logo_url') ) {
		return reactor_option('login_logo_url'); 
	}
}
add_filter('login_headerurl', 'reactor_login_logo_url');

/**
 * 3. Logo title attribute text
 *
 * @since 1.0.0
 */
function reactor_login_logo_title() {
	if ( reactor_option('login_logo_title') ) {
		return reactor_option('login_logo_title'); 
	}
}
add_filter('login_headertitle', 'reactor_login_logo_title');


function crum_custom_login_bg(){
	if(reactor_option('custom_login_bg')){
		$bg_path = reactor_option('custom_login_bg');
		echo '<style type="text/css">';
		echo 'body.login {background: url('. $bg_path['url'] .') !important; background-size: 100% 100% !important}';
		echo '</style>';
	}
	}

add_filter('login_head', 'crum_custom_login_bg');
