<?php 
/**
 * Create Nonce Fields for Security
 *
 * This ensures that the request to modify sliders
 * was an intentional request from the user. Used in
 * the Ajax Reequest for validation.     
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */
wp_nonce_field( 'crumina_delete_slider_instance', 'crumina_slider_delete_slider_instance_nonce' );
wp_nonce_field( 'crumina_edit_slider_instance', 'crumina_slider_edit_slider_instance_nonce' );
wp_nonce_field( 'crumina_slider_quick_search', 'crumina_slider_quick_search_nonce' );
wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );

