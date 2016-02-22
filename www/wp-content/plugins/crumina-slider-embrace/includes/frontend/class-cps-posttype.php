<?php
/**
 * Class: CPS_Posttype
 *
 * This file initialises the admin functionality for this plugin.
 * It initalises a posttype that acts as a data structure for
 * the crumina page sliders. It also has useful static helper 
 * functions each custom page slider. 
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */
if ( ! class_exists( 'CPS_Posttype' ) ) :
	class CPS_Posttype {
		/**
		 * Instance of this class.
		 * 
		 * @var      object
		 * @since    1.0
		 *
		 */
		protected static $instance = null;

		/**
		 * Slug of the plugin screen.
		 * 
		 * @var      string
		 * @since    1.0
		 *
		 */
		protected $plugin_screen_hook_suffix = 'crumina-page-slider';

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
			add_action( 'init', array( $this, 'register_crumina_page_slider_posttype' ) );
		}

		/**
		 * Register Crumina Page Slider Posttype
		 * 
		 * Register the page slider posttype in the same fashion that
		 * WordPress registers nav-menus internally. This will be used
		 * to store any page slider instances. Created when the 'init' 
		 * action is fired.
		 *
		 * Custom Filters:
		 *     - crumina_page_slider_posttype_name
		 *     - crumina_page_slider_posttype_singular_name
		 *
		 *
		 * @link 	http://codex.wordpress.org/Function_Reference/register_post_type 	register_post_type()
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function register_crumina_page_slider_posttype() {
			register_post_type( 'crumina_page_slider', array(
				'labels' => array(
					'name'          => apply_filters( 'crumina_page_slider_posttype_name', __( 'Crumina Page Sliders', 'crumina-page-slider' ) ),
					'singular_name' => apply_filters( 'crumina_page_slider_posttype_singular_name', __( 'Crumina Page Slider', 'crumina-page-slider' ) )
				),
				'public'           => false,
				'hierarchical'     => false,
				'rewrite'          => false,
				'delete_with_user' => false,
				'query_var'        => false 
			) );			
		}

		/**
		 * Add Custom Page Slider
		 * 
		 * Create a post for the 'crumina_page_slider' posttype which 
		 * will use the custom post meta WordPress functionality to store 
		 * all of the necessary attributes for each crumina page slider. 
		 * Note: The slider_id is different to the actual post id for each 
		 * crumina page slider instance.
		 *
		 * Custom Filters:
		 *     - crumina_default_description_limit
		 *     - crumina_page_slider_options
		 *
		 * @todo Add in shortcode functionality
		 * 
		 * @param  string 	$slider_name   		- The name for this page slider instance.
		 * @param  boolean 	$show_title   		- Show/Hide title for this slider.
		 * @param  boolean 	$show_icon   		- Show/Hide icons for this slider.
		 * @param  boolean 	$show_category  	- Show/Hide category name for this slider.
		 * @param  boolean 	$show_description  	- Show/Hide the description for this slider.
		 * @param  int 		$description_limit  - Number of words limit for each description.
		 * @param  string  	$template_name		- Reference to the template name assigned to this slider.
		 * @param  array  	$template_options	- An array of template options unique to this page slider.
		 * 
		 * @return $post  The ID of the post if the post is successfully added to the database or 0 on failure.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function add_page_slider( $slider_name, $show_title = false, $show_icon = false, $show_category = false, $link_to_post = false, $show_description = false, $description_limit = false, $template_name = '', $template_options = array(), $attachments = array() ) {

			// Generate ID and make sure its unique
			$slider_count  = rand( 1, 100 );
			$slider_id     = 'crumina-page-slider-' . $slider_count;

			// Generate an array of existing page slider ids and names
			$existing_slider_ids   = array();
			$existing_slider_names = array();
			$slider_id_exists      = true;
			$slider_name_exists    = true;			

			$params = array(
				'post_type'      => 'crumina_page_slider',
				'posts_per_page' => -1
			);
			$query = new WP_Query( $params );

			while( $query->have_posts() ) {
				$query->the_post();
				$existing_slider_ids[]   = get_post_meta( get_the_ID(), '_slider_id', true );
				$existing_slider_names[] = get_the_title();
			}

			// Make sure the ID doesn't already exist
			while ( $slider_id_exists ) {
				if ( in_array( $slider_id, $existing_slider_ids ) ) {
					$slider_count++;
					$slider_id = "crumina-page-slider-{$slider_count}";
				} else {
					$slider_id_exists = false;
				}
			}

			// Strip any unallowed characters from the post title
			$slider_name = str_replace( array( '#', "'", '"', '&', "{", "}" ), '', $slider_name );

			// Give the post a title if it is an empty string
			if ( '' == $slider_name ) {
				$slider_name = __( 'Page Slider', 'crumina-page-slider' );
			}

			// Make sure that the name doesn't already exist
			$name_count    = 1;
			$original_name = $slider_name;

			while ( $slider_name_exists ) {
				if ( in_array( $slider_name, $existing_slider_names ) ) {
					$name_count++;
					$slider_name = "{$original_name} {$name_count}";
				} else {
					$slider_name_exists = false;
				}		
			}

			// Remove the save_post action to prevent capabilities error
			// as wp_insert_post triggers this action when called
			$hook_name = 'save_post';
			global $wp_filter;
			$save_post_functions   = $wp_filter[$hook_name];
			$wp_filter[$hook_name] = array();

			$postarr = array(
				'post_type'   => 'crumina_page_slider',
				'post_title'  => $slider_name,
				'post_status' => 'publish' 
			); 
			$post = wp_insert_post( $postarr );

			// Update slider post id
			update_post_meta( $post, '_slider_id', $slider_id );

			// Update the post meta to hold the custom page slider properties
			update_post_meta( $post, '_cps_show_title', $show_title );
			update_post_meta( $post, '_cps_show_icon', $show_icon );
			update_post_meta( $post, '_cps_show_category', $show_category );
			update_post_meta( $post, '_cps_show_description', $show_description );
			update_post_meta( $post, '_cps_show_link', $link_to_post );

			// Set description limit
			if ( ! $description_limit ) {
				update_post_meta( $post, '_cps_description_limit', (int) apply_filters( 'crumina_default_description_limit', 30 ) );
			} else {
				update_post_meta( $post, '_cps_description_limit', (int) $description_limit );
			}

			// Set template data
			update_post_meta( $post, '_cps_template_name', $template_name );
			update_post_meta( $post, '_cps_template_options', (array) apply_filters( 'crumina_page_slider_options', $template_options ) );

			// Add attachments
			update_post_meta( $post, '_cps_attachments', $attachments );

			// Add shortcode reference
			$shortcode_count  = (int) get_option( 'cps_shortcode_count', 0 );
			$new_shortcode_id = $shortcode_count + 1;

			// Update post meta and plugin option
			update_post_meta( $post, '_cps_shortcode_id', (int) $new_shortcode_id );
			update_option( 'cps_shortcode_count', (int) $new_shortcode_id );

			// Restore all save post functions
			$wp_filter[$hook_name] = $save_post_functions;
			wp_reset_query();
			return $post;
		}

		/**
		 * Update Custom Page Slider
		 * 
		 * Updates an existing page slider instance with the values 
		 * passed into the parameter. If a page slider instance is
		 * not found a new page slider instance would be created.
		 *
		 * Custom Filters:
		 *     - crumina_default_description_limit
		 *     - crumina_page_slider_options
		 *
		 * @todo Add in shortcode functionality
		 * 
		 * @param  string 	$slider_id   		- The ID for the page slider to update. Note: This is NOT the post id but the slider_id meta value.
		 * @param  string 	$slider_name   		- The name for this page slider instance.
		 * @param  boolean 	$show_title   		- Show/Hide title for this slider.
		 * @param  boolean 	$show_icon   		- Show/Hide icons for this slider.
		 * @param  boolean 	$show_category  	- Show/Hide category name for this slider.
		 * @param  boolean 	$show_description  	- Show/Hide the description for this slider.
		 * @param  int 		$description_limit  - Number of words limit for each description.
		 * @param  string  	$template_name		- Reference to the template name assigned to this slider.
		 * @param  array  	$template_options	- An array of template options unique to this page slider.
		 * 
		 * @return $post  The ID of the post if the post is successfully added to the database or 0 on failure.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function update_page_slider( $slider_id, $slider_name, $show_title = false, $show_icon = false, $show_category = false, $link_to_post = false, $show_description = false, $description_limit = false, $template_name = '', $template_options = array(), $attachments = array() ) {

			$params = array(
				'post_type'  => 'crumina_page_slider',
				'meta_key'   => '_slider_id',
				'meta_value' => $slider_id
			);

			$query = new WP_Query( $params );

			/**
			 * Remove the save_post action to prevent any capabilities 
			 * error as wp_insert_post triggers this action when called
			 */
			$hook_name = 'save_post';
			global $wp_filter;
			$save_post_functions     = $wp_filter[ $hook_name ];
			$wp_filter[ $hook_name ] = array();

			// Strip any unallowed characters from the post title
			$slider_name = str_replace( array( '#', "'", '"', '&', "}", "{" ), '', $slider_name );

			// Give the post a title if it is an empty string
			if ( '' == $slider_name ) {
				$slider_name = __( 'Page Slider', 'crumina-page-slider' );
			}

			if ( $query->found_posts > 0 ) {
				$query->the_post();
				$post_id = get_the_ID();

				// Make sure no other page slider has the same name
				if ( self::page_slider_exists( $slider_name, $slider_id ) ) {
					$slider_name_exists = true;
					$name_count         = 1;
					$original_name      = $slider_name;

					while ( $slider_name_exists ) {

						// Create new name
						$slider_name = "{$original_name} {$name_count}";

						// Check if the new name exists already
						if ( self::page_slider_exists( $slider_name, $slider_id ) ) {
							$name_count++;
						} else {
							$slider_name_exists = false;
						}
					}
				}

				// Update the post object
				$post_arr = array(
					'ID'         => $post_id,
					'post_title' => $slider_name
				);
				wp_update_post( $post_arr );

			} else {
				$new_post = self::add_page_slider( $slider_name );
				$post_id  = $new_post;
			}

			// Reset the query globals
			wp_reset_postdata();

			/**
			 * Update other post meta properties to hold
			 * the crumina page slider instance properties.
			 */
			// Update the post meta to hold the custom page slider properties
			update_post_meta( $post_id, '_cps_show_title', $show_title );
			update_post_meta( $post_id, '_cps_show_icon', $show_icon );
			update_post_meta( $post_id, '_cps_show_category', $show_category );
			update_post_meta( $post_id, '_cps_show_description', $show_description );
			update_post_meta( $post_id, '_cps_show_link', $link_to_post );

			// Set description limit
			if ( ! $description_limit ) {
				update_post_meta( $post_id, '_cps_description_limit', (int) apply_filters( 'crumina_default_description_limit', 30 ) );
			} else {
				update_post_meta( $post_id, '_cps_description_limit', (int) $description_limit );
			}

			// Set template data
			update_post_meta( $post_id, '_cps_template_name', $template_name );
			update_post_meta( $post_id, '_cps_template_options', (array) apply_filters( 'crumina_page_slider_options', $template_options ) );

			// Add attachments		
			update_post_meta( $post_id, '_cps_attachments', (array) apply_filters( 'crumina_page_slider_attachments', $attachments ) );

			/**
			 * Restore the save_post action so any functions
			 * that are hooked to it will execute as intended.
			 */	
			$wp_filter[ $hook_name ] = $save_post_functions;	

			return $post_id;
			wp_reset_query();

		}

		/**
		 * Page Slider Name Exists
		 *
		 * Takes the page slider name to check and the slider id to 
		 * exclude and returns true if there are any other page slider
		 * instances that have this name. (Boolean Function)
		 * 
		 * @param  string $name           			- The page slider name we wish to check
		 * @param  string $exclude_slider_id   		- The page slider id to exclude in the search
		 * 
		 * @return boolean $slider_name_exists 		- true if there is another page slider instance that has a matching $name
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function page_slider_exists( $name, $exclude_slider_id ) {
			$slider_name_exists = false;

			$params = array(
				'post_type'      => 'crumina_page_slider',
				'posts_per_page' => -1
			);
			$query = new WP_Query( $params );
			
			// Check if the page slider name exists
			while ( $query->have_posts() ) {

				$query->the_post();
				$slider_id = get_post_meta( get_the_ID(), '_slider_id', true );

				if ( $slider_id ) {
					if ( $slider_id != $exclude_slider_id ) {
						if ( $name == get_the_title() ) {
							$slider_name_exists = true;
						}
					}
				}
			}

			wp_reset_postdata();

			return $slider_name_exists;		
		}

		/**
		 * Get Crumina Page Slider
		 *
		 * Takes the slider id as a parameter and returns the
		 * post object if it's '_slider_id' meta value matches 
		 * the slider id passed in the parameter. Returns false
		 * if no matches have been found.
		 * 
		 * @param  string $slider_id 	- The ID of the page slider we wish to check
		 * @return object post 			- Post object if found otherwise false
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_page_slider( $slider_id ) {
			$params = array(
				'post_type'  => 'crumina_page_slider',
				'meta_key'   => '_slider_id',
				'meta_value' => $slider_id
			);
			$query = new WP_Query( $params );

			if( $query->have_posts() ) {
				$query->the_post();
				return get_post( get_the_ID() );
			} else {
				return false;
			}
			wp_reset_query();
		}

		/**
		 * Get WP_Query Object based on meta key
		 *
		 * Returns the actual WP_Query object instead of
		 * just the posts. Allows us to go through each
		 * post at a later stage (e.g. frontend shortcodes)
		 * 
		 * @param  string $meta_key [description]
		 * @param  string $value    [description]
		 * @return object WP_Query  - or false if no query
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_page_slider_query_by_meta( $meta_key, $value ) {
			
			// Make sure no empty strings have been passed in the parameter
			if ( $meta_key && $value ) {
				$params = array(
					'post_type'      => 'crumina_page_slider',
					'meta_key'       => $meta_key,
					'meta_value'     => $value,
					'posts_per_page' => -1,
					'post_status'    => 'publish',
				);

				$query = new WP_Query( $params );

				if ( $query->have_posts() ) {
					return $query;
				} else {
					return false;
				}
				
			} else {
				return false;
			}
			wp_reset_query();
		}

		/**
		 * Get All Crumina Page Slider Posts
		 *
		 * Returns all of the 'crumina_page_slider' posttypes objects
		 * in alphabetical order by default. This function will return 
		 * false if there are no 'crumina_page_slider' posts in the 
		 * database.
		 *
		 * @param string $orderby 	- Attribute to order posts by
		 * @param string $order 	- Either ASC or DESC
		 * 
		 * @return array $query if post exists and 
		 *         boolean if there are no posts.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function get_all_page_sliders( $orderby = 'title', $order = 'ASC' ) {
			$params = array(
				'post_type'      => 'crumina_page_slider',
				'posts_per_page' => -1,
				'orderby'        => $orderby,
				'order'          => $order,
				'post_status'    => 'publish',

			);
			
			$query = new WP_Query( $params );

			if( $query->have_posts() ) {
				return $query;
			} else {
				return false;
			}

			wp_reset_query();

		}

		/**
		 * Delete Page Slider Instance
		 *
		 * Looks for a crumina page slider instance with the id 
		 * that is passed as a string in the parameter and deletes 
		 * it. Returns false if no matches have been found. 
		 * 
		 * @param  string  $slider_id    The id of the slider we want to delete. Note: This is NOT the post id but the slider_id meta value.
		 * 
		 * @return boolean $deleted       True if the slider has been located and deleted, false otherwise.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function delete_page_slider( $slider_id ) {
			$params = array(
					'post_type'      => 'crumina_page_slider',
					'posts_per_page' => -1,
					'meta_key'       => '_slider_id',
					'meta_value'     => $slider_id
				);
			
			$query   = new WP_Query( $params );
			$deleted = false;

			// If no posts are found set deleted to true as it doesn't exist
			if ( 0 == $query->found_posts ) {
				$deleted = true;
			}
			
			// Delete the post if it exists
			while ( $query->have_posts() ) {
				$query->the_post();
				wp_delete_post( get_the_ID(), true );
				$deleted = true;
			}

			// Reset postdata as we have used the_post()
			wp_reset_query();

			return $deleted;
		}

		/**
		 * Delete All Page Sliders
		 * 
		 * A function used to delete all posts in the 'crumina_page_slider'
		 * custom posttype, which will remove all crumina page sliders
		 * created by the user.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function delete_all_page_sliders() {
			$params = array(
					'post_type'      => 'crumina_page_slider',
					'posts_per_page' => -1
				);

			$query  = new WP_Query( $params );
			
			while ( $query->have_posts() ) {
				$query->the_post();
				wp_delete_post( get_the_ID(), true );
			}

			// Reset postdata as we have used the_post()
			wp_reset_query();
		}

	}
endif;