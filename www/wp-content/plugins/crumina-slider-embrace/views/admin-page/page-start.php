<?php 
/**
 * Crumina Page Slider Generator Admin Page Output
 *
 * This file is responsible for generating the admin 
 * page output for the google fonts settings page. It
 * should only be included from within a function.
 * 
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */

/**
 * Check User Permissions and Theme Support
 * 
 * Checks if the user has the required privileges. It will 
 * die if these conditions are not met.
 *
 * @link http://codex.wordpress.org/Function_Reference/current_user_can 			current_user_can()
 * @link http://codex.wordpress.org/Function_Reference/current_theme_supports		current_theme_supports()
 * @link http://codex.wordpress.org/Function_Reference/wp_die 				    	wp_die()
 *
 * @since 1.0
 * @version  1.0
 * 
 */
	if ( ! current_user_can('edit_theme_options') )
		wp_die( __( 'Cheatin&#8217; uh?' ) );

?>
<div class="wrap">