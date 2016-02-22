<?php
/**
 * Plugin Name: Crumina Page Slider
 * Description: A simple and easy way to add page/post sliders to your WordPress theme.
 * Version: 1.1
 * Author: Crumina Team
 * Author URI: http://crumina.net
 * Text Domain: crumina-page-slider
 * License: GPL2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * 
 */

/**
 * Crumina Page Slider Initialisation
 *
 * This file is responsible for enabling the crumina
 * page slider. It load all of the classes and methods
 * required for this plugin to function.
 * 
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Include Class Files
 *
 * Loads required classes for this plugin to function.
 *
 * Codex functions used:
 * {@link http://codex.wordpress.org/Function_Reference/plugin_dir_path} 	plugin_dir_path()
 *
 * @since 1.0
 * @version 1.0
 * 
 */
require_once( plugin_dir_path( __FILE__ ) . 'class-crumina-page-slider.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/frontend/class-cps-templates.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/frontend/class-mr-image-resize.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/frontend/class-cps-posttype.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/frontend/class-cps-frontend.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/admin/class-cps-transients.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/admin/class-cps-walker-slider-edit.php' ); 
require_once( plugin_dir_path( __FILE__ ) . 'includes/admin/class-cps-walker-slider-checklist.php' ); 
require_once( plugin_dir_path( __FILE__ ) . 'includes/admin/class-crumina-page-slider-admin.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/admin/class-cps-admin-controller.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/admin/class-cps-ajax.php' );


/**
 * Load Plugin Text Domain
 *
 * Required in order to make this plugin translatable.
 *
 * Codex functions used: 
 * {@link http://codex.wordpress.org/Function_Reference/load_plugin_textdomain} 	load_plugin_textdomain()
 * {@link http://codex.wordpress.org/Function_Reference/plugin_basename} 			plugin_basename()
 * {@link http://codex.wordpress.org/Function_Reference/add_action} 				add_action()
 *
 * @since 1.0
 * @version 1.0
 * 
 */
function crumina_page_slider_text_domain() {
	load_plugin_textdomain( 'crumina-page-slider', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'crumina_page_slider_text_domain' );

if(!function_exists('theme_thumb')):
function theme_thumb($url, $width, $height = 0, $crop){
	return mr_image_resize( $url, $width, $height, $crop, $align = '', false );
}
endif;
/**
 * Initialise Class Instances
 *
 * Creates new class instances when the 'plugins-loaded'
 * action is fired. Only runs admin specific functionality
 * when the user is in the admin area for performance.
 *
 * Codex functions used: 
 * {@link http://codex.wordpress.org/Function_Reference/add_action} 	add_action()
 *
 * @since 1.0
 * @version 1.0
 * 
 */
add_action( 'plugins_loaded', array( 'Crumina_Page_Slider', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'CPS_Templates', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'CPS_Posttype', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'CPS_Transients', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'CPS_Frontend', 'get_instance' ) );

if ( is_admin() ) {
	add_action( 'plugins_loaded', array( 'Crumina_Page_Slider_Admin', 'get_instance' ) );
	add_action( 'plugins_loaded', array( 'CPS_Ajax', 'get_instance' ) );
}
	

/**
 * Register Activation/Deactivation Hooks
 * 
 * Register hooks that are fired when the plugin is 
 * activated or deactivated. When the plugin is deleted, 
 * the uninstall.php file is loaded.
 *
 * Codex functions used: 
 * {@link http://codex.wordpress.org/Function_Reference/register_activation_hook} 		register_activation_hook()
 * {@link http://codex.wordpress.org/Function_Reference/register_deactivation_hook} 	register_deactivation_hook()
 * 
 * @since 1.0
 * @version 1.0
 * 
 */
register_activation_hook( __FILE__, array( 'Crumina_Page_Slider', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Crumina_Page_Slider', 'deactivate' ) );