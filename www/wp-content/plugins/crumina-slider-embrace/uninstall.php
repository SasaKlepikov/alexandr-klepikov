<?php
/**
 * Uninstall Crumina Page Slider
 *
 * Used to uninstall this plugin and remove any options
 * and transients from the database. Fired when the plugin
 * is uninstalled. Developers can add code to this file that
 * will run when the user uninstalls Crumina Page Slider.
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
