<?php
/**
 * Class: CPS_Transients
 *
 * Uses the WordPress Transients API in order to
 * store the page slider as WP_Query can be an 
 * expensive function to run. Transients are now
 * managed automatically in the background. Transients
 * get refreshed when the user:
 *     
 *     - Creates a page/post.
 *     - Deletes a page/post.
 *     - Deletes/Edits a page slider.
 *     - Deletes all page slider.
 *     - Deletes/Edits a category or taxonomy
 *
 * @package   CPS_Transients
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */
if ( ! class_exists( 'CPS_Transients' ) ) :
	class CPS_Transients {
		
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
			
			$actions = array(
				'post_submitbox_misc_actions',
				'add_attachment',
				'add_category',
				'create_category',
				'delete_attachment',
				'delete_category',
				'wp_trash_post',
				'untrash_post',
				'before_delete_post',
				'delete_post',
				'edit_attachment',
				'edit_category',
				'edit_post',
				'publish_page',
				'publish_post',
				'publish_future_post',
				'save_post',
				'crumina-trigger-transient-refresh'
			);

			/**
			 * Apply filters so theme developers can add or
			 * remove actions to trigger transient refresh.
			 *
			 */
			$actions = apply_filters( 'crumina-page-slider-transient-actions', $actions );

			foreach ( $actions as $action ) {
				add_action( $action, array( $this, 'delete_all_transients' ) );
			}
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
		 * Delete All Transients
		 *
		 * Add any custom filters in this function.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function delete_all_transients() {

			$args = array(
				'post_type'      => 'crumina_page_slider',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
			);

			// Delete all transients
			$custom_posts = get_posts($args);
			if ( $custom_posts ) {
				foreach ( $custom_posts as $post ) :
					delete_transient( "crumina-page-slider-" . $post->ID );
				endforeach;
			}
			// Reset post data
			wp_reset_postdata();
			// Delete css transients

			delete_transient( 'crumina-page-slider-styles' );
			

		}
	}
endif;