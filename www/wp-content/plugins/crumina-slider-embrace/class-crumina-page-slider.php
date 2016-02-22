<?php
/**
 * Class: Crumina_Page_Slider
 *
 * The purpose of this class is to provide information
 * about the file structure of this plugin, allowing
 * the plugin folder name to be changed if necessary.
 * It also contains the activation and deactivation
 * functions that are triggered when the Crumina Page
 * Slider is activated/deactivated.
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */
if ( ! class_exists( 'Crumina_Page_Slider' ) ) :
	class Crumina_Page_Slider {
		
		/**
		 * Plugin version, used for cache-busting of style and script file references.
		 * 
		 * @var      string
		 * @since 	 1.0
		 */
		const VERSION = '1.0';

		/**
		 * Instance of this class.
		 * 
		 * @var      object
		 * @since    1.0
		 *
		 */
		protected static $instance = null;

		/**
		 * Translation handle
		 * 
		 * @var      string
		 * @since    1.0
		 *
		 */
		public $plugin_slug = 'crumina-page-slider';

		/**
		 * Constructor Function
		 * 
		 * Initialize the class and register all
		 * actions and filters.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		function __construct() {

			$this->plugin_slug = 'crumina-page-slider';
			$this->register_actions();		
			$this->register_filters();
		}

		/**
		 * Return an instance of this class.
		 * 
		 * @return    object    A single instance of this class.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Register Custom Actions
		 *
		 * Add any custom actions in this function.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function register_actions() {
		}
		
		/**
		 * Register Custom Filters
		 *
		 * Add any custom filters in this function.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function register_filters() {
		}		

		/**
		 * Get CSS Directory URL
		 *
		 * Static function that returns the complete url of
		 * the css directory location. Returns the path without
		 * the trailing slash.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_css_url() {
			return plugins_url( 'assets/css', __FILE__ );
		}

		/**
		 * Get CSS Directory Path
		 *
		 * Static function that returns the complete path of
		 * the css directory location. Returns the path without
		 * the trailing slash.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_css_path() {
			return plugin_dir_path( __FILE__ ) . 'assets/css';
		}

		/**
		 * Get JavaScript Directory URL
		 *
		 * Static function that returns the complete url of
		 * the js directory location. Returns the path without
		 * the trailing slash.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_js_url() {
			return plugins_url( 'assets/js', __FILE__ );
		}

		/**
		 * Get JavaScript Directory Path
		 *
		 * Static function that returns the complete path of
		 * the js directory location. Returns the path without
		 * the trailing slash.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_js_path() {
			return plugin_dir_path( __FILE__ ) . 'assets/js';
		}

		/**
		 * Get Image Directory URL
		 *
		 * Static function that returns the complete url of
		 * the js directory location. Returns the url without
		 * the trailing slash.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_images_url() {
			return plugins_url( 'assets/images', __FILE__ );
		}

		/**
		 * Get Image Directory Path
		 *
		 * Static function that returns the complete path of
		 * the js directory location. Returns the path without
		 * the trailing slash.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_images_path() {
			return plugin_dir_path( __FILE__ ) . 'assets/images';
		}

		/**
		 * Get Includes Directory URL
		 *
		 * Static function that returns the complete url of
		 * the includes directory location. Returns the path without
		 * the trailing slash.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_includes_url() {
			return plugins_url( 'includes', __FILE__ );
		}

		/**
		 * Get Includes Directory Path
		 *
		 * Static function that returns the complete url of
		 * the includes directory location. Returns the path without
		 * the trailing slash.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_includes_path() {
			return plugin_dir_path( __FILE__ ) . 'includes' ;
		}

		/**
		 * Get Views Directory URL
		 *
		 * Static function that returns the complete url of
		 * the views directory location. Returns the path without
		 * the trailing slash.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_views_url() {
			return plugins_url( 'views', __FILE__ );
		}

		/**
		 * Get Views Directory Path
		 *
		 * Static function that returns the complete url of
		 * the views directory location. Returns the path without
		 * the trailing slash.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_views_path() {
			return plugin_dir_path( __FILE__ ) . 'views' ;
		}

		/**
		 * Get Template Directory URL
		 *
		 * Static function that returns the complete url of
		 * the templates directory location. Returns the path 
		 * without the trailing slash.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_template_directory_url() {
			return plugins_url( 'views/templates', __FILE__ );
		}

		/**
		 * Get Template Directory Path
		 *
		 * Static function that returns the complete url of
		 * the templates directory location. Returns the path 
		 * without the trailing slash.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_template_directory_path() {
			return plugin_dir_path( __FILE__ ) . 'views/templates' ;
		}

		/**
		 * Activation Event
		 * 
		 * Fired when the plugin is activated.
		 *
		 * @param    boolean    $network_wide    True if WPMU superadmin uses
		 *                                       "Network Activate" action, false if
		 *                                       WPMU is disabled or plugin is
		 *                                       activated on an individual blog.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function activate( $network_wide ) {

			if ( function_exists( 'is_multisite' ) && is_multisite() ) {

				if ( $network_wide  ) {

					// Get all blog ids
					$blog_ids = self::get_blog_ids();

					foreach ( $blog_ids as $blog_id ) {
						switch_to_blog( $blog_id );
						self::single_activate();
					}

					restore_current_blog();

				} else {
					self::single_activate();
				}

			} else {
				self::single_activate();
			}
		}

		/**
		 * Deactivation Event
		 * 
		 * Fired when the plugin is deactivated.
		 * 
		 * @param    boolean    $network_wide    True if WPMU superadmin uses
		 *                                       "Network Deactivate" action, false if
		 *                                       WPMU is disabled or plugin is
		 *                                       deactivated on an individual blog.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function deactivate( $network_wide ) {

			if ( function_exists( 'is_multisite' ) && is_multisite() ) {

				if ( $network_wide ) {

					// Get all blog ids
					$blog_ids = self::get_blog_ids();

					foreach ( $blog_ids as $blog_id ) {

						switch_to_blog( $blog_id );
						self::single_deactivate();

					}

					restore_current_blog();

				} else {
					self::single_deactivate();
				}

			} else {
				self::single_deactivate();
			}
		}

		/**
		 * WMPU Activation Event
		 * 
		 * Fired when a new site is activated with a WPMU environment.
		 *
		 * @param    int    $blog_id    ID of the new blog.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function activate_new_site( $blog_id ) {

			if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
				return;
			}

			switch_to_blog( $blog_id );
			self::single_activate();
			restore_current_blog();
		}

		/**
		 * Get Blog Ids
		 * 
		 * Get all blog ids of blogs in the current network that are:
		 * - not archived
		 * - not spam
		 * - not deleted
		 *
		 * @return   array|false    The blog ids, false if no matches.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		private static function get_blog_ids() {

			global $wpdb;

			// get an array of blog ids
			$sql = "SELECT blog_id FROM $wpdb->blogs
				WHERE archived = '0' AND spam = '0'
				AND deleted = '0'";

			return $wpdb->get_col( $sql );
		}

		/**
		 * Define Activation Functionality
		 * 
		 * Anything in this function is fired for each blog 
		 * when the plugin is activated.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		private static function single_activate() {
		}

		/**
		 * Define Deactivation Functionality
		 * 
		 * Anything in this function is fired for each blog 
		 * when the plugin is deactivated.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		private static function single_deactivate() {

		}

		/**
		 * Convert Array to Object
		 *
		 * Utility function used throughout this plugin
		 * that converts arrays to objects. Note:
		 * This is a recursive function.
		 * 
		 * @param  array 	$array - Array to convert
		 * @return object   $obj   - Object equivalent
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function array_to_object( $array ) {
			$obj = new stdClass;
			foreach( $array as $k => $v ) {
				if( strlen( $k ) ) {
					if( is_array( $v ) ) {
						$obj->{$k} = self::array_to_object( $v ); //RECURSION
					} else {
						$obj->{$k} = $v;
					}
				}
			}
			return $obj;
		}

	}
endif;