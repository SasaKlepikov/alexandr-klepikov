<?php
/**
 * Class: CPS_Ajax
 *
 * This class contains all of the admin ajax functionality
 * that is used by this plugin.
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */
if ( ! class_exists( 'CPS_Ajax' ) ) :
	class CPS_Ajax {
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
			add_action( 'wp_ajax_crumina_add_slider_item', array( $this, 'add_slider_item' ) );
			add_action( 'wp_ajax_crumina_create_slider_instance', array( $this, 'create_page_slider_instance' ) );
			add_action( 'wp_ajax_crumina_update_slider_instance', array( $this, 'update_page_slider_instance' ) );
			add_action( 'wp_ajax_crumina_delete_slider_instance', array( $this, 'delete_page_slider_instance' ) );
			add_action( 'wp_ajax_crumina_delete_all_slider_instances', array( $this, 'delete_all_page_slider_instances' ) );
			add_action( 'wp_ajax_crumina_slider_quick_search', array( $this, 'quick_search' ) );
			add_action( 'wp_ajax_crumina_slider_get_metabox', array( $this, 'get_metabox' ) );
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
		 * Add Item/Page Attachement to Page Slider - Ajax Function
		 *
		 * Checks WordPress nonce and upon successful validation
		 * creates the html markup for a new item to add to the
		 * current page slider that is loaded.
		 *
		 * @link 	http://codex.wordpress.org/Function_Reference/check_ajax_referer 		check_ajax_referer()
		 * @link 	http://codex.wordpress.org/Function_Reference/current_user_can 			current_user_can()
		 * @link 	http://codex.wordpress.org/Function_Reference/wp_die 					wp_die()
		 * @link 	http://codex.wordpress.org/Function_Reference/get_post 					get_post()
		 * @link 	http://codex.wordpress.org/Function_Reference/apply_filters 			apply_filters()
		 * @link 	http://codex.wordpress.org/Function_Reference/add_action 				add_action()
		 *
		 * @uses  class CPS_Walker_Sidebar_Edit
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function add_slider_item() {
			
			// Make sure user has the required access level
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_die( -1 );
			}

			// Check admin nonce for security
			check_ajax_referer( 'crumina_edit_slider_instance', 'crumina_slider_edit_slider_instance_nonce' );

			/**
			 * Include Nav Menu File
			 * 
			 * As this function uses some of the utility functions 
			 * contained in this file.
			 * 
			 */
			require_once ABSPATH . 'wp-admin/includes/nav-menu.php';

			/**
			 * Variables to store menu output
			 * @var mixed
			 */
			$output          = '';
			$menu_items      = array();
			$menu_items_data = array();
			$item_ids        = array();

			/**
			 * Get Slider Menu Item Data:
			 * 
			 * Loops through the menu items that have been submitted
			 * in this request.
			 * 
			 */
			foreach ( (array) $_POST['menu-item'] as $menu_item_data ) {
				if ( ! empty( $menu_item_data['menu-item-type'] ) && ! empty( $menu_item_data['menu-item-object-id'] ) ) {
					$menu_item_type = $menu_item_data['menu-item-type'];

					switch ( $menu_item_type ) {
						case 'post_type':
							$item_ids[] = array( 
								'type' => 'post_type', 
								'id'   => $menu_item_data['menu-item-object-id'],
								'data' => $menu_item_data,
							);
							break;
						
						case 'taxonomy':
							$item_ids[] = array( 
								'type'   => 'taxonomy', 
								'id'     => $menu_item_data['menu-item-object-id'],
								'data' => $menu_item_data,
							);
							break;
					}

					$menu_items_data[] = $menu_item_data;
				}
			}
			
			// Die if error
			if ( is_wp_error( $item_ids ) ) {
				wp_die();
			}			

			/**
			 * Generate Menu Items
			 *
			 * Determine the type of object we are working with
			 * and build an object that contains its properties.
			 * By building the object manually we avoid a trip
			 * to the database which results in a huge performance
			 * boost and a minimal database footprint.
			 * 
			 */
			foreach ( (array) $item_ids as $menu_item_id ) {
				switch ( $menu_item_id['type'] ) {
					case 'post_type':
						$current_post  = get_post( $menu_item_id['id'] );
						$post_type_obj = get_post_type_object( $current_post->post_type );

						
						// Manually build object (huge performance boost)
						if ( $post_type_obj ) {
							$menu_item                   = new stdClass();
							$menu_item                   = $current_post;
							$menu_item->ID               = $current_post->ID;
							$menu_item->db_id            = $current_post->ID;
							$menu_item->object           = $post_type_obj->name;
							$menu_item->type_label       = $post_type_obj->labels->singular_name;
							$menu_item->object_id        = $current_post->ID;
							$menu_item->menu_item_parent = 0;
							$menu_item->type             = 'post_type';
							$menu_item->post_title       = $current_post->post_title;
							$menu_item->label            = $current_post->post_title;
							$menu_item->url              = get_permalink( $current_post->ID );
							$menu_item->post_status      = 'draft';

							// Add to menu items
							$menu_items[]    = $menu_item;
						}
						break;

					case 'taxonomy':
						$tax_obj  = get_taxonomy( $menu_item_id['data']['menu-item-object'] );
						$tax_term = get_term_by( 'name', $menu_item_id['data']['menu-item-title'], $tax_obj->name );

						if ( $tax_obj && $tax_term ) {
							$menu_item                   = new stdClass();
							$menu_item->ID               = $menu_item_id['id'];
							$menu_item->db_id            = $menu_item_id['id'];
							$menu_item->object           = $tax_obj->name;
							$menu_item->type_label       = $tax_obj->labels->singular_name;
							$menu_item->object_id        = $menu_item_id['id'];
							$menu_item->menu_order       = 0;
							$menu_item->menu_item_parent = 0;
							$menu_item->type             = 'taxonomy';
							$menu_item->title            = $tax_term->name;
							$menu_item->label            = $tax_term->name;
							$menu_item->url              = get_term_link( (int) $menu_item_id['id'], $tax_obj->name );
							$menu_item->post_status      = 'draft';

							// Add to menu items
							$menu_items[]    = $menu_item;
						}
						break;
				}
			}

			// Define Walker
			$walker_class_name = apply_filters( 'crumina_edit_slider_walker', 'CPS_Walker_Slider_Edit', $menu_items );

			// Die if walker doesn't exist
			if ( ! class_exists( $walker_class_name ) ) {
				wp_die();
			}

			if ( ! empty( $menu_items ) ) {
				$args = array(
					'after'       => '',
					'before'      => '',
					'link_after'  => '',
					'link_before' => '',
					'pending'     => true,
					'walker'      => new $walker_class_name,
				);

				$output .= walk_nav_menu_tree( $menu_items, 0, (object) $args );
				echo $output;
			}

			// Return to client
			wp_die();
		}

		/**
		 * Create Page Slider Instance - Ajax Function
		 * 
		 * Checks WordPress nonce and upon successful validation
		 * creates a new page slider instance. This function then 
		 * constructs a new ajax response and sends it back to the
		 * client.
		 *
		 * @uses CPS_Posttype::update_page_slider()
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function create_page_slider_instance() {
			
			// Make sure user has the required access level
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_die( -1 );
			}

			// Check admin nonce for security
			check_ajax_referer( 'crumina_edit_slider_instance', 'crumina_slider_edit_slider_instance_nonce' );

			// Refresh transients
			do_action( 'crumina-trigger-transient-refresh' );		

			// Get Slider Name
			if( isset( $_POST['slider_name'] ) ) {
				$slider_name =  $_POST['slider_name'];
			} else {
				$slider_name = __( 'Page Slider', 'crumina-page-slider' );
			}

			// Create a new page slider instance and get the associated ID
			$new_slider    = CPS_Posttype::update_page_slider( '0', $slider_name );
			$new_slider_id = get_post_meta( $new_slider, '_slider_id', true );

			// Create array to hold additional xml data
			$supplimental_data = array(
				'new_slider_id'     => $new_slider_id
			);

			$data = array(
				'what'         => 'new_slider',
				'id'           => 1,
				'data'         => '',
				'supplemental' => $supplimental_data
			);

			// Create a new WP_Ajax_Response obj and send the request
			$x = new WP_Ajax_Response( $data );
			$x->send();

			wp_die();
		}

		/**
		 * Save/Update Page Slider Instance - Ajax Function
		 * 
		 * Checks WordPress nonce and upon successful validation
		 * updates an existing page slider instance. This function 
		 * then  constructs a new ajax response and sends it back 
		 * to the client.
		 *
		 * @uses CPS_Posttype::update_page_slider()
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */		
		public function update_page_slider_instance() {
			
			// Make sure user has the required access level
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_die( -1 );
			}

			// Check admin nonce for security
			check_ajax_referer( 'crumina_edit_slider_instance', 'crumina_slider_edit_slider_instance_nonce' );

			// Refresh transients
			do_action( 'crumina-trigger-transient-refresh' );

			$slider_id      = isset( $_POST[ 'slider-id' ] ) ? (string) $_POST[ 'slider-id' ] : (string) '0';
			$slider_name    = isset( $_POST[ 'slider-name' ] ) ? (string) $_POST[ 'slider-name' ] : __( 'Page Slider', 'crumina-page-slider' );


			// Get slider properties
			$show_title        = ( isset( $_POST['show-title'] ) 		&& 'true' ==  $_POST['show-title'] ) 		? true 	: false ;
			$show_icon         = ( isset( $_POST['show-icons'] ) 		&& 'true' ==  $_POST['show-icons'] ) 		? true 	: false ;
			$show_category     = ( isset( $_POST['show-categories'] ) 	&& 'true' ==  $_POST['show-categories'] ) 	? true 	: false ;
			$link_to_post      = ( isset( $_POST['show-link'] ) 		&& 'true' ==  $_POST['show-link'] ) 		? true 	: false ;
			$show_description  = ( isset( $_POST['show-description'] ) 	&& 'true' ==  $_POST['show-description'] ) 	? true 	: false ;
			
			// Description limit
			$description_limit = ( ! empty( $_POST['description-limit'] ) ) ? (int) $_POST['description-limit'] : apply_filters( 'crumina_default_description_limit', 30 );
			
			// Template options
			$template_name     = isset( $_POST['template-name'] ) ? (string) $_POST['template-name'] : '';
			$template_options  = array();

			if ( isset( $_POST['template-options'] ) ) {
				foreach ( $_POST['template-options'] as $name => $value ) {
					$template_options[ $name ] = $value;
				}
			}

			$attachments = array();


			if ( isset( $_POST['attachments'] ) ) {

				// Build the page sluder data array
				foreach ( (array) $_POST['attachments'] as  $page_slider_item_data ) {
					
					// Array index position should have been set on the admin screen
					$i = (int) $page_slider_item_data[ 'menu-item-position' ];
					$attachments[] = $page_slider_item_data;
				}
			}

			// Update Page Slider
			$page_sider = CPS_Posttype::update_page_slider(
				$slider_id,
				$slider_name, 
				$show_title, 
				$show_icon, 
				$show_category, 
				$link_to_post, 
				$show_description, 
				$description_limit, 
				$template_name, 
				$template_options, 
				$attachments 
			);

			// Create array to hold additional xml data
			$supplimental_data = array(
				'slider_name'     => get_the_title( $page_sider ),
			);

			$data = array(
				'what'         => 'slider',
				'id'           => 1,
				'data'         => '',
				'supplemental' => $supplimental_data
			);	

			// Create a new WP_Ajax_Response obj and send the request
			$x = new WP_Ajax_Response( $data );
			$x->send();		

			wp_die();
		}
		
		/**
		 * Delete Page Slider Instance - Ajax Function
		 * 
		 * Checks WordPress nonce and upon successful validation
		 * it deletes the page slider instance from the database.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/check_ajax_referer 		check_ajax_referer()
		 * @link http://codex.wordpress.org/Function_Reference/current_user_can 		current_user_can()
		 * @link http://codex.wordpress.org/Function_Reference/wp_die 					wp_die()
		 * @link http://codex.wordpress.org/Function_Reference/add_action 				add_action()
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */	
		public function delete_page_slider_instance() {
			
			// Make sure user has the required access level
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_die( -1 );
			}

			// Check admin nonce for security
			check_ajax_referer( 'crumina_delete_slider_instance', 'crumina_slider_delete_slider_instance_nonce' );	

			if ( isset( $_POST['sliderId'] ) ) {
				// Refresh transients
				do_action( 'crumina-trigger-transient-refresh' );
				CPS_Posttype::delete_page_slider( $_POST['sliderId'] );
			}

			wp_die();
		}

		/**
		 * Delete All Page Slider Instances - Ajax Function
		 * 
		 * Checks WordPress nonce and upon successful validation
		 * it deletes all page slider instances from the database.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/check_ajax_referer 		check_ajax_referer()
		 * @link http://codex.wordpress.org/Function_Reference/current_user_can 		current_user_can()
		 * @link http://codex.wordpress.org/Function_Reference/wp_die 					wp_die()
		 * @link http://codex.wordpress.org/Function_Reference/add_action 				add_action()
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */	
		public function delete_all_page_slider_instances() {

			// Make sure user has the required access level
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_die( -1 );
			}

			// Check admin nonce for security
			check_ajax_referer( 'crumina_delete_slider_instance', 'crumina_slider_delete_slider_instance_nonce' );	

			// Refresh transients
			do_action( 'crumina-trigger-transient-refresh' );
			
			CPS_Posttype::delete_all_page_sliders();

			wp_die();
		}

		/**
		 * Quick Search 
		 *
		 * AJAX function that performs a search query based on
		 * the user input that has been posted and returns a 
		 * search results response.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/current_user_can 		current_user_can()
		 * @link http://codex.wordpress.org/Function_Reference/wp_die 					wp_die()
		 * @link http://codex.wordpress.org/Function_Reference/add_action 				add_action()
		 *
		 * @uses Crumina_Page_Slider_Admin::quick_search()
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function quick_search() {
		
			// Make sure user has the required access level
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_die( -1 );
			}

			// Generate Quick Search Output
			Crumina_Page_Slider_Admin::quick_search( $_POST );

			wp_die();
		}

		/**
		 * AJAX Metabox Pagination
		 *
		 * Gets metabox information passed via AJAX and generates
		 * the approriate metabox markup to replace on the clients
		 * browser. Allows the user to paginate through each metabox
		 * without refreshing the page. This function echos back the
		 * html markup to the client admin page.
		 * 
		 * @link http://codex.wordpress.org/Function_Reference/current_user_can 		current_user_can()
		 * @link http://codex.wordpress.org/Function_Reference/wp_die 					wp_die()
		 * @link http://codex.wordpress.org/Function_Reference/get_post_types 			get_post_types()
		 * @link http://codex.wordpress.org/Function_Reference/get_taxonomies 			get_taxonomies()
		 * @link http://codex.wordpress.org/Function_Reference/add_action 				add_action()
		 *
		 * @uses Crumina_Page_Slider_Admin::post_type_meta_box_output()
		 * @uses Crumina_Page_Slider_Admin::taxonomy_meta_box_output()
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function get_metabox() {
			// Make sure user has the required access level
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_die( -1 );
			}

			if ( isset( $_POST['item-type'] ) && 'post_type' == $_POST['item-type'] ) {

				$type     = 'posttype';
				$callback = array( 'Crumina_Page_Slider_Admin', 'post_type_meta_box_output' );
				$items    = (array) get_post_types( array( 'show_in_nav_menus' => true ), 'object' );

			} elseif ( isset( $_POST['item-type'] ) && 'taxonomy' == $_POST['item-type'] ) {

				$type     = 'taxonomy';
				$callback = array( 'Crumina_Page_Slider_Admin', 'taxonomy_meta_box_output' );
				$items    = (array) get_taxonomies( array( 'show_ui' => true ), 'object' );

			} 

			if ( ! empty( $_POST['item-object'] ) && isset( $items[$_POST['item-object']] ) ) {

				$item = apply_filters( 'crumina_slider_meta_box_object', $items[ $_POST['item-object'] ] );
				ob_start();
				call_user_func_array($callback, array(
					null,
					array(
						'id'       => 'crumina-add-' . $item->name,
						'title'    => $item->labels->name,
						'callback' => $callback,
						'args'     => $item,
					)
				));

				$markup = ob_get_clean();

				// Generate Replacement ID
				$replace_id = $type . '-' . $item->name;

				// Add suffix if custom posts in category metabox
				if ( isset( $_POST['custom-item-type'] ) ) {
					if ( 'category_posts' == $_POST['custom-item-type'] ) {
						$replace_id .= '-custom-category';
					}
				}

				// Return JSON data
				echo json_encode(array(
					'replace-id' => $replace_id,
					'markup'     => $markup,
				));
			}	

			// Die
			wp_die();
		}

	}
endif;