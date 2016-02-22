<?php
/**
 * Class: Crumina_Page_Slider_Admin
 *
 * This controller class is used to build the admin page
 * output. It includes the necessary views contained in 
 * the views/admin-page directory.
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */
if ( ! class_exists( 'Crumina_Page_Slider_Admin' ) ) :
	class Crumina_Page_Slider_Admin {
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
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function register_actions() {
			// Load admin style sheet and JavaScript.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

			// Add the options page and menu item.
			add_action( 'admin_head', array( $this, 'admin_head_styles' ) );
			add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
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
			// Add an action link pointing to the options page.
			$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
			add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );
		}

		/**
		 * Enqueue Admin Styles
		 * 
		 * Register and enqueue admin-specific stylesheets.
		 *
		 * @return    null    Return early if no settings page is registered.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function enqueue_admin_styles() {
			
			if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
				return;
			}

			$screen = get_current_screen();

			// Load styles only on the admin page
			if ( $this->plugin_screen_hook_suffix == $screen->id ) {

				wp_enqueue_style( 'wp-color-picker' );

				wp_deregister_style( $this->plugin_slug .'-admin-styles' );
				wp_register_style( 
					$this->plugin_slug .'-admin-styles', 
					Crumina_Page_Slider::get_css_url() . '/admin/admin.css', 
					array(), 
					Crumina_Page_Slider::VERSION
				);
				wp_enqueue_style( $this->plugin_slug .'-admin-styles' );
			}

		}

		/**
		 * Enqueue Admin Scripts
		 * 
		 * Register and enqueue admin-specific JavaScript.
		 *
		 * @return    null    Return early if no settings page is registered.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function enqueue_admin_scripts() {
			
			if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
				return;
			}

			$screen = get_current_screen();

			// Load styles only on the admin page
			if ( $this->plugin_screen_hook_suffix == $screen->id ) {
				
				// Load jQuery and jQuery UI
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'utils' );
				wp_enqueue_script( 'jquery-ui-core' );
				wp_enqueue_script( 'jquery-effects-core' );
				wp_enqueue_script( 'jquery-effects-fade' );
				wp_enqueue_script( 'jquery-ui-sortable' );
				wp_enqueue_script( 'jquery-ui-autocomplete' );
				wp_enqueue_script( 'jquery-ui-position' );
				wp_enqueue_script( 'jquery-ui-widget' );
				wp_enqueue_script( 'jquery-ui-mouse' );
				wp_enqueue_script( 'jquery-ui-draggable' );
				wp_enqueue_script( 'jquery-ui-droppable' );
				wp_enqueue_script( 'jquery-ui-spinner' );
				wp_enqueue_script( 'wp-color-picker' );
				wp_enqueue_script( 'iris' );

				// Load PostBox
				wp_enqueue_script( 'postbox' );
				
				if ( wp_is_mobile() ) {
					wp_enqueue_script( 'jquery-touch-punch' );
				}

				// Load admin page js
				wp_deregister_script( $this->plugin_slug . '-admin-script' );
				wp_register_script( 
					$this->plugin_slug . '-admin-script', 
					Crumina_Page_Slider::get_js_url() . '/admin/admin.js',  
					array( 'jquery','jquery-ui-core', 'jquery-ui-widget' ), 
					Crumina_Page_Slider::VERSION 
				);
				wp_enqueue_script( $this->plugin_slug . '-admin-script' );	

				// Load metabox accordion plugin
				wp_deregister_script( $this->plugin_slug . '-accordion-sidebar' );
				wp_register_script( 
					$this->plugin_slug . '-accordion-sidebar', 
					Crumina_Page_Slider::get_js_url() . '/admin/accordion-sidebar.js',  
					array( 'jquery' ), 
					Crumina_Page_Slider::VERSION 
				);
				wp_enqueue_script( $this->plugin_slug . '-accordion-sidebar' );				
				
				// Load in js l10n for javascript translations
				wp_localize_script( $this->plugin_slug . '-admin-script', 'cruminal10n', $this->getL10n() );

			}
		}

		/**
		 * Get L10n Translation Object
		 *
		 * This array is enqueues as a javascript object on
		 * the admin page. This allows the plugin to remain
		 * fully translatable.
		 * 
		 * @return array $l10n - Array of strings to be used as a js translation object
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function getL10n() {
			$l10n = array(
				'ajax_url'                  => admin_url( 'admin-ajax.php' ),
				'confirmation'              => __( 'This page is asking you to confirm that you want to leave - data you have entered may not be saved.', 'crumina-page-slider' ),
				'deleteAllWarning'          => __( "Warning! You are about to permanently delete all page sliders. 'Cancel' to stop, 'OK' to delete.", 'crumina-page-slider' ),
				'deleteWarning'             => __( "You are about to permanently delete this page slider. 'Cancel' to stop, 'OK' to delete.", 'crumina-page-slider' ),
				'leavePage'                 => __( 'Leave Page', 'crumina-page-slider' ) ,
				'stayOnPage'                => __( 'Stay on Page', 'crumina-page-slider' ) ,
				'noResultsFound'            => __( 'No Results Found.', 'crumina-page-slider' ),
				'oneThemeLocationNoSliders' => __( 'No Sliders', 'crumina-page-slider')
			);
			return $l10n;
		}
		
		/**
		 * Edit Admin Styles
		 *
		 * Used to show/hide certain options in the admin
		 * area, and change the appearence of certain ui
		 * elements for the events calendar plugin.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function admin_head_styles() {
			?>
			<style type="text/css">
				#adminmenu .menu-icon-generic.toplevel_page_crumina-page-slider div.wp-menu-image:before{
					content: "\f479";
					font: 400 20px/1 dashicons!important;
				}
			</style>
			<?php
		}

		/**
		 * Add Admin Menu 
		 * 
		 * Register the administration menu for this plugin 
		 * into the WordPress Dashboard menu.
		 *
		 * @link http://codex.wordpress.org/Administration_Menus	Administration Menus
		 * @link http://codex.wordpress.org/Roles_and_Capabilities 	Roles and Capabilities
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function add_plugin_admin_menu() {

			/**
			 * Add a settings page for this plugin to the Settings menu.
			 *
			 * NOTE: Alternative menu locations are available via WordPress 
			 * administration menu functions.
			 *
			 * {@link http://codex.wordpress.org/Administration_Menus} 		Administration Menus
			 * {@link http://codex.wordpress.org/Roles_and_Capabilities}	Roles and Capabilities
			 *    
			 */
			$this->plugin_screen_hook_suffix = add_menu_page(
				__( 'Page Sliders', $this->plugin_slug ),
				__( 'Page Sliders', $this->plugin_slug ),
				'edit_theme_options',
				$this->plugin_slug,
				array( $this, 'display_plugin_admin_page' )
			);

			/**
			 * Manually add submenu pages to the top level
			 * Page Sliders menu created in the admin area.
			 *  
			 */
			add_submenu_page(
				$this->plugin_slug, 
				__( 'Edit Page Sliders', $this->plugin_slug ),
				__( 'Edit Page Sliders', $this->plugin_slug ),
				'edit_theme_options', 
				$this->plugin_slug
			);

			add_submenu_page(
				$this->plugin_slug, 
				__( 'Add New', $this->plugin_slug ),
				__( 'Add New', $this->plugin_slug ),
				'edit_theme_options',
				'admin.php?page=' . $this->plugin_slug . '&action=create'
			);

			add_submenu_page(
				$this->plugin_slug, 
				__( 'Manage Page Sliders', $this->plugin_slug ),
				__( 'Manage Page Sliders', $this->plugin_slug ),
				'edit_theme_options', 
				'admin.php?page=' . $this->plugin_slug . '&screen=manage_sliders'
			);

			/**
			 * Set up the custom sidebar metaboxes. Requires
			 * WordPress Nav Menu functionality.http://localhost/development/wp-admin/admin.php?page=crumina-page-slider
			 * 
			 */
			$this->setup_metaboxes();

			/**
			 * Use the retrieved $this->plugin_screen_hook_suffix to hook the function that enqueues our 
			 * contextual help tabs. This hook invokes the function only on our plugin administration screen,
			 * see: http://codex.wordpress.org/Administration_Menus#Page_Hook_Suffix
			 */
			add_action( 'load-' . $this->plugin_screen_hook_suffix, array( $this, 'add_help_tabs' ) );
			add_action( 'load-' . $this->plugin_screen_hook_suffix, array( $this, 'add_screen_option' ) );
		}

		/**
		 * Setup Sidebar Metaboxes
		 * 
		 * Creates a new array item in the global $wp_meta_boxes and
		 * then modify this data so that it is ready for the admin
		 * page.
		 *
		 * @uses global $wp_meta_boxes
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */	
		public function setup_metaboxes() {
			global $wp_meta_boxes;

			$this->setup_post_type_meta_boxes();
			$this->setup_taxonomy_meta_boxes();
		}

		/**
		 * Retrieve All Post Type Metaboxes
		 *
		 * Gets all posttypes that are currently registered
		 * with the currently active WordPress theme and 
		 * registers metaboxes for each posttype for use on
		 * the Page Slider Admin Page.
		 *
		 * Custom Filters:
		 *     - crumina_sidebar_meta_box_object
		 *
		 *
		 * @link 	http://codex.wordpress.org/Function_Reference/get_post_types 	get_post_types()
		 * @link 	http://codex.wordpress.org/Function_Reference/apply_filters 	apply_filters()
		 * @link 	http://codex.wordpress.org/Function_Reference/add_meta_box 		add_meta_box()
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function setup_post_type_meta_boxes() {
			$post_types      = get_post_types( array( 'show_in_nav_menus' => true ), 'object' );
			$admin_page_name = 'toplevel_page_crumina-page-slider';

			// Return early if there are no post types defined
			if ( ! $post_types ) {
				return;
			}

			// Add metabox for each posttype
			foreach ( $post_types as $post_type ) {
				/**
				 * Filter allows developers to remove metaboxes 
				 * for certain post types if desired.
				 */
				$post_type = apply_filters( 'crumina_sidebar_meta_box_object', $post_type );
				
				// Add if valid posttype
				if ( $post_type ) {
					$id = $post_type->name;
					add_meta_box( 
						"crumina-add-{$id}",
						$post_type->labels->name, 					
						'Crumina_Page_Slider_Admin::post_type_meta_box_output', 
						$admin_page_name, 
						'side', 
						'default', 
						$post_type 
					);
				}
			}
		}

		/**
		 * Displays a Metabox for a Post Type Sidebar item.
		 *
		 * This function outputs the sidebar checklist metabox
		 * that is used on the admin page.
		 * 
		 * @link 	http://codex.wordpress.org/Function_Reference/apply_filters 				apply_filters()
		 * @link 	http://codex.wordpress.org/Function_Reference/get_post_type_object			get_post_type_object()
		 * @link 	http://codex.wordpress.org/Function_Reference/paginate_links				paginate_links()
		 * @link 	http://codex.wordpress.org/Function_Reference/add_query_arg					add_query_arg()
		 * @link 	http://codex.wordpress.org/Function_Reference/is_post_type_hierarchical		is_post_type_hierarchical()
		 * @link 	http://codex.wordpress.org/Function_Reference/esc_attr						esc_attr()
		 * @link 	http://codex.wordpress.org/Function_Reference/get_post						get_post()
		 * @link 	http://codex.wordpress.org/Function_Reference/get_posts						get_posts()
		 * @link 	http://codex.wordpress.org/Function_Reference/submit_button					submit_button()
		 * @link 	http://codex.wordpress.org/Function_Reference/is_wp_error					is_wp_error()
		 * @link 	http://codex.wordpress.org/Function_Reference/get_option					get_option()
		 *
		 * @uses  class CPS_Walker_Slider_Checklist
		 * 
		 * @global $_nav_menu_placeholder
		 * @global $nav_menu_selected_id
		 * @param string $object Not used.
		 * @param string $post_type The post type object.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function post_type_meta_box_output( $object, $post_type ) {

			global $_nav_menu_placeholder, $nav_menu_selected_id;
			$post_type_name = $post_type['args']->name;

			// paginate browsing for large numbers of post objects
			$per_page = 50;
			$pagenum  = isset( $_REQUEST[$post_type_name . '-tab'] ) && isset( $_REQUEST['paged'] ) ? absint( $_REQUEST['paged'] ) : 1;
			$offset   = 0 < $pagenum ? $per_page * ( $pagenum - 1 ) : 0;

			$args = array(
				'offset'                 => $offset,
				'order'                  => 'ASC',
				'orderby'                => 'title',
				'posts_per_page'         => $per_page,
				'post_type'              => $post_type_name,
				'suppress_filters'       => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false
			);

			if ( isset( $post_type['args']->_default_query ) ) {
				$args = array_merge($args, (array) $post_type['args']->_default_query );
			}

			// @todo transient caching of these results with proper invalidation on updating of a post of this type
			$get_posts = new WP_Query;
			$posts     = $get_posts->query( $args );

			// Reset postdata as we have used the_post()

			if ( ! $get_posts->post_count ) {
				echo '<p>' . __( 'No items.', 'crumina-page-slider' ) . '</p>';
				return;
			}

			$post_type_object = get_post_type_object( $post_type_name );
			$num_pages        = $get_posts->max_num_pages;

			$page_links = paginate_links( array(
				'base' => add_query_arg(
					array(
						$post_type_name . '-tab' => 'all',
						'paged'                  => '%#%',
						'item-type'              => 'post_type',
						'item-object'            => $post_type_name,
					)
				),
				'format'    => '',
				'prev_text' => __('&laquo;'),
				'next_text' => __('&raquo;'),
				'total'     => $num_pages,
				'current'   => $pagenum
			));

			if ( !$posts )
				$error = '<li id="error">'. $post_type['args']->labels->not_found .'</li>';

			$db_fields = false;
			if ( is_post_type_hierarchical( $post_type_name ) ) {
				$db_fields = array( 'parent' => 'post_parent', 'id' => 'ID' );
			}

			// Define our own custom walker
			$walker = new CPS_Walker_Slider_Checklist( $db_fields );

			$current_tab = 'most-recent';
			if ( isset( $_REQUEST[$post_type_name . '-tab'] ) && in_array( $_REQUEST[$post_type_name . '-tab'], array('all', 'search') ) ) {
				$current_tab = $_REQUEST[$post_type_name . '-tab'];
			}

			if ( ! empty( $_REQUEST['quick-search-posttype-' . $post_type_name] ) ) {
				$current_tab = 'search';
			}

			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);
			?>
			<div id="posttype-<?php echo $post_type_name; ?>" class="posttypediv">
				<ul id="posttype-<?php echo $post_type_name; ?>-tabs" class="posttype-tabs add-menu-item-tabs">
					<li <?php echo ( 'most-recent' == $current_tab ? ' class="tabs"' : '' ); ?>><a class="nav-tab-link" href="<?php if ( $nav_menu_selected_id ) echo esc_url(add_query_arg($post_type_name . '-tab', 'most-recent', remove_query_arg($removed_args))); ?>#tabs-panel-posttype-<?php echo $post_type_name; ?>-most-recent"><?php _e('Most Recent'); ?></a></li>
					<li <?php echo ( 'all' == $current_tab ? ' class="tabs"' : '' ); ?>><a class="nav-tab-link" href="<?php if ( $nav_menu_selected_id ) echo esc_url(add_query_arg($post_type_name . '-tab', 'all', remove_query_arg($removed_args))); ?>#<?php echo $post_type_name; ?>-all"><?php _e('View All'); ?></a></li>
					<li <?php echo ( 'search' == $current_tab ? ' class="tabs"' : '' ); ?>><a class="nav-tab-link" href="<?php if ( $nav_menu_selected_id ) echo esc_url(add_query_arg($post_type_name . '-tab', 'search', remove_query_arg($removed_args))); ?>#tabs-panel-posttype-<?php echo $post_type_name; ?>-search"><?php _e('Search'); ?></a></li>
				</ul>

				<div id="tabs-panel-posttype-<?php echo $post_type_name; ?>-most-recent" class="tabs-panel <?php
					echo ( 'most-recent' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' );
				?>">
					<ul id="<?php echo $post_type_name; ?>checklist-most-recent" class="categorychecklist form-no-clear">

						<!-- Posttype Archive Checkbox -->
						<?php if ( 'post' != $post_type_object->name && 'page' != $post_type_object->name ) : ?>
							<li>
								<label class="menu-item-title">
									<input type="checkbox" value="1" name="menu-item[-1112][menu-item-object-id]" class="menu-item-checkbox">
									<strong><?php echo sprintf( __( '%s Archive', 'crumina-page-slider' ), $post_type_object->labels->singular_name ); ?></strong>

								</label>
								<input class="menu-item-db-id" type="hidden" value="0" name="menu-item[-1112][menu-item-db-id]">
								<input class="menu-item-object" type="hidden" value="<?php echo $post_type_object->name; ?>" name="menu-item[-1112][menu-item-object]">
								<input class="menu-item-parent-id" type="hidden" value="0" name="menu-item[-1112][menu-item-parent-id]">
								<input class="menu-item-type" type="hidden" value="post_type_archive" name="menu-item[-1112][menu-item-type]">
								<input class="menu-item-title" type="hidden" value="<?php echo sprintf( __( '%s Archive', 'crumina-page-slider' ), $post_type_object->labels->singular_name ); ?>" name="menu-item[-1112][menu-item-title]">					
							</li>
						<?php endif; ?>

						<?php
						$recent_args = array_merge( $args, array( 'orderby' => 'post_date', 'order' => 'DESC', 'posts_per_page' => 15 ) );
						$most_recent = $get_posts->query( $recent_args );
						$args['walker'] = $walker;
						echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $most_recent), 0, (object) $args );
						?>
					</ul>
				</div><!-- /.tabs-panel -->

				<div class="tabs-panel <?php
					echo ( 'search' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' );
				?>" id="tabs-panel-posttype-<?php echo $post_type_name; ?>-search">
					<?php
					if ( isset( $_REQUEST['quick-search-posttype-' . $post_type_name] ) ) {
						$searched = esc_attr( $_REQUEST['quick-search-posttype-' . $post_type_name] );
						$search_results = get_posts( array( 's' => $searched, 'post_type' => $post_type_name, 'fields' => 'all', 'order' => 'DESC', ) );
					} else {
						$searched = '';
						$search_results = array();
					}
					?>
					<p class="quick-search-wrap">
						<input type="search" class="quick-search input-with-default-title" title="<?php esc_attr_e('Search'); ?>" value="<?php echo $searched; ?>" name="quick-search-posttype-<?php echo $post_type_name; ?>" />
						<span class="spinner"></span>
						<?php submit_button( __( 'Search' ), 'button-small quick-search-submit button-secondary hide-if-js', 'submit', false, array( 'id' => 'submit-quick-search-posttype-' . $post_type_name ) ); ?>
					</p>

					<ul id="<?php echo $post_type_name; ?>-search-checklist" data-wp-lists="list:<?php echo $post_type_name?>" class="categorychecklist form-no-clear">
					<?php if ( ! empty( $search_results ) && ! is_wp_error( $search_results ) ) : ?>
						<?php
						$args['walker'] = $walker;
						echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $search_results), 0, (object) $args );
						?>
					<?php elseif ( is_wp_error( $search_results ) ) : ?>
						<li><?php echo $search_results->get_error_message(); ?></li>
					<?php elseif ( ! empty( $searched ) ) : ?>
						<li><?php _e('No results found.'); ?></li>
					<?php endif; ?>
					</ul>
				</div><!-- /.tabs-panel -->

				<div id="<?php echo $post_type_name; ?>-all" class="tabs-panel tabs-panel-view-all <?php
					echo ( 'all' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' );
				?>">
					<?php if ( ! empty( $page_links ) ) : ?>
						<div class="add-menu-item-pagelinks">
							<?php echo $page_links; ?>
						</div>
					<?php endif; ?>
					<ul id="<?php echo $post_type_name; ?>checklist" data-wp-lists="list:<?php echo $post_type_name?>" class="categorychecklist form-no-clear">
						
						<!-- Posttype Archive Checkbox -->
						<?php if ( 'post' != $post_type_object->name && 'page' != $post_type_object->name ) : ?>
							<li>
								<label class="menu-item-title">
									<input type="checkbox" value="1" name="menu-item[-1112][menu-item-object-id]" class="menu-item-checkbox">
									<strong><?php echo sprintf( __( '%s Archive', 'crumina-page-slider' ), $post_type_object->labels->singular_name ); ?></strong>

								</label>
								<input class="menu-item-db-id" type="hidden" value="0" name="menu-item[-1112][menu-item-db-id]">
								<input class="menu-item-object" type="hidden" value="<?php echo $post_type_object->name; ?>" name="menu-item[-1112][menu-item-object]">
								<input class="menu-item-parent-id" type="hidden" value="0" name="menu-item[-1112][menu-item-parent-id]">
								<input class="menu-item-type" type="hidden" value="post_type_archive" name="menu-item[-1112][menu-item-type]">
								<input class="menu-item-title" type="hidden" value="<?php echo sprintf( __( '%s Archive', 'crumina-page-slider' ), $post_type_object->labels->singular_name ); ?>" name="menu-item[-1112][menu-item-title]">					
							</li>
						<?php endif; ?>
						
						<?php
						$args['walker'] = $walker;

						// if we're dealing with pages, let's put a checkbox for the front page at the top of the list
						if ( 'page' == $post_type_name ) {
							$front_page = 'page' == get_option('show_on_front') ? (int) get_option( 'page_on_front' ) : 0;
							if ( ! empty( $front_page ) ) {
								$front_page_obj = get_post( $front_page );
								$front_page_obj->front_or_home = true;
								array_unshift( $posts, $front_page_obj );
							} else {
								$_nav_menu_placeholder = ( 0 > $_nav_menu_placeholder ) ? intval($_nav_menu_placeholder) - 1 : -1;
								array_unshift( $posts, (object) array(
									'front_or_home' => true,
									'ID'            => 0,
									'object_id'     => $_nav_menu_placeholder,
									'post_content'  => '',
									'post_excerpt'  => '',
									'post_parent'   => '',
									'post_title'    => _x('Home', 'nav menu home label'),
									'post_type'     => 'nav_menu_item',
									'type'          => 'custom',
									'url'           => home_url('/'),
								) );
							}
						}

						$posts = apply_filters( 'master_sidebar_items_'.$post_type_name, $posts, $args, $post_type );
						$checkbox_items = walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $posts), 0, (object) $args );

						if ( 'all' == $current_tab && ! empty( $_REQUEST['selectall'] ) ) {
							$checkbox_items = preg_replace('/(type=(.)checkbox(\2))/', '$1 checked=$2checked$2', $checkbox_items);

						}

						echo $checkbox_items;
						?>
					</ul>
					<?php if ( ! empty( $page_links ) ) : ?>
						<div class="add-menu-item-pagelinks">
							<?php echo $page_links; ?>
						</div>
					<?php endif; ?>
				</div><!-- /.tabs-panel -->

				<p class="button-controls">
					<span class="list-controls">
						<a href="<?php
							echo esc_url(add_query_arg(
								array(
									$post_type_name . '-tab' => 'all',
									'selectall' => 1,
								),
								remove_query_arg($removed_args)
							));
						?>#posttype-<?php echo $post_type_name; ?>" class="select-all"><?php _e( 'Select All', 'crumina-page-slider' ); ?></a>
					</span>

					<span class="add-to-menu">
						<input type="submit"<?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Slider', 'crumina-page-slider' ); ?>" name="add-post-type-menu-item" id="submit-posttype-<?php echo $post_type_name; ?>" />
						<span class="spinner"></span>
					</span>
				</p>
			</div><!-- /.posttypediv -->
			<?php
		}

		/**
		 * Setup Taxonomy Metaboxes
		 * 
		 * @return [type] [description]
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function setup_taxonomy_meta_boxes() {
			$taxonomies      = get_taxonomies( array( 'show_in_nav_menus' => true ), 'object' );
			$admin_page_name = 'toplevel_page_crumina-page-slider';

			if ( ! $taxonomies ) {
				return;
			}

			foreach ( $taxonomies as $tax ) {
				$tax = apply_filters( 'crumina_sidebar_meta_box_object', $tax );
				if ( $tax ) {
					$id = $tax->name;
					add_meta_box( 
						"master-add-{$id}", 
						$tax->labels->name, 
						'Crumina_Page_Slider_Admin::taxonomy_meta_box_output',
						$admin_page_name, 
						'side', 
						'default',
						$tax 
					);
				}
			}
		}

		/**
		 * Displays a metabox for a taxonomy menu item.
		 *
		 * This function outputs the sidebar checklist metabox
		 * that is used on the admin page.
		 * 
		 * @link 	http://codex.wordpress.org/Function_Reference/apply_filters 				apply_filters()
		 * @link 	http://codex.wordpress.org/Function_Reference/get_post_type_object			get_post_type_object()
		 * @link 	http://codex.wordpress.org/Function_Reference/paginate_links				paginate_links()
		 * @link 	http://codex.wordpress.org/Function_Reference/add_query_arg					add_query_arg()
		 * @link 	http://codex.wordpress.org/Function_Reference/is_post_type_hierarchical		is_post_type_hierarchical()
		 * @link 	http://codex.wordpress.org/Function_Reference/esc_attr						esc_attr()
		 * @link 	http://codex.wordpress.org/Function_Reference/get_terms						get_terms()
		 * @link 	http://codex.wordpress.org/Function_Reference/get_taxonomy					get_taxonomy()
		 * @link 	http://codex.wordpress.org/Function_Reference/submit_button					submit_button()
		 * @link 	http://codex.wordpress.org/Function_Reference/is_wp_error					is_wp_error()
		 * @link 	http://codex.wordpress.org/Function_Reference/get_option					get_option()
		 * @link 	http://codex.wordpress.org/Function_Reference/wp_count_terms				wp_count_terms()
		 *
		 * @global $nav_menu_selected_id
		 * 
		 * @uses  class CPS_Walker_Slider_Checklist
		 *
		 * @param string $object Not used.
		 * @param string $taxonomy The taxonomy object.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function taxonomy_meta_box_output( $object, $taxonomy ) {
			global $nav_menu_selected_id;
			$taxonomy_name = $taxonomy['args']->name;

			// paginate browsing for large numbers of objects
			$per_page = 50;
			$pagenum  = isset( $_REQUEST[$taxonomy_name . '-tab'] ) && isset( $_REQUEST['paged'] ) ? absint( $_REQUEST['paged'] ) : 1;
			$offset   = 0 < $pagenum ? $per_page * ( $pagenum - 1 ) : 0;

			$args = array(
				'child_of'     => 0,
				'exclude'      => '',
				'hide_empty'   => false,
				'hierarchical' => 1,
				'include'      => '',
				'number'       => $per_page,
				'offset'       => $offset,
				'order'        => 'ASC',
				'orderby'      => 'name',
				'pad_counts'   => false,
			);

			$terms        = get_terms( $taxonomy_name, $args );
			$taxonomy_obj = get_taxonomy( $taxonomy_name );

			if ( ! $terms || is_wp_error($terms) ) {
				echo '<p>' . __( 'No items.' ) . '</p>';
				return;
			}

			$num_pages = ceil( wp_count_terms( $taxonomy_name , array_merge( $args, array('number' => '', 'offset' => '') ) ) / $per_page );

			$admin_url  = esc_url( 
							add_query_arg( 
								array( 
									'page' => 'crumina-page-slider' 
								), 
								admin_url( 'admin.php' ) 
							) 
						);

			$page_links = paginate_links( array(
				'base' => add_query_arg(
					array(
						$taxonomy_name . '-tab' => 'all',
						'paged'                 => '%#%',
						'item-type'             => 'taxonomy',
						'item-object'           => $taxonomy_name
					), $admin_url
				),
				'format'    => '',
				'prev_text' => __('&laquo;'),
				'next_text' => __('&raquo;'),
				'total'     => $num_pages,
				'current'   => $pagenum
			));

			$db_fields = false;
			if ( is_taxonomy_hierarchical( $taxonomy_name ) ) {
				$db_fields = array( 'parent' => 'parent', 'id' => 'term_id' );
			}

			// Define our own custom walker
			$walker = new CPS_Walker_Slider_Checklist( $db_fields );

			$current_tab = 'most-used';
			if ( isset( $_REQUEST[$taxonomy_name . '-tab'] ) && in_array( $_REQUEST[ $taxonomy_name . '-tab' ], array( 'all', 'most-used', 'search' ) ) ) {
				$current_tab = $_REQUEST[$taxonomy_name . '-tab'];
			}

			if ( ! empty( $_REQUEST['quick-search-taxonomy-' . $taxonomy_name] ) ) {
				$current_tab = 'search';
			}

			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);
			?>
			<div id="taxonomy-<?php echo $taxonomy_name; ?>" class="taxonomydiv">
				<ul id="taxonomy-<?php echo $taxonomy_name; ?>-tabs" class="taxonomy-tabs add-menu-item-tabs">
					<li <?php echo ( 'most-used' == $current_tab ? ' class="tabs"' : '' ); ?>><a class="nav-tab-link" href="<?php if ( $nav_menu_selected_id ) echo esc_url(add_query_arg($taxonomy_name . '-tab', 'most-used', remove_query_arg($removed_args))); ?>#tabs-panel-<?php echo $taxonomy_name; ?>-pop"><?php _e('Most Used'); ?></a></li>
					<li <?php echo ( 'all' == $current_tab ? ' class="tabs"' : '' ); ?>><a class="nav-tab-link" href="<?php if ( $nav_menu_selected_id ) echo esc_url(add_query_arg($taxonomy_name . '-tab', 'all', remove_query_arg($removed_args))); ?>#tabs-panel-<?php echo $taxonomy_name; ?>-all"><?php _e('View All'); ?></a></li>
					<li <?php echo ( 'search' == $current_tab ? ' class="tabs"' : '' ); ?>><a class="nav-tab-link" href="<?php if ( $nav_menu_selected_id ) echo esc_url(add_query_arg($taxonomy_name . '-tab', 'search', remove_query_arg($removed_args))); ?>#tabs-panel-search-taxonomy-<?php echo $taxonomy_name; ?>"><?php _e('Search'); ?></a></li>
				</ul>

				<div id="tabs-panel-<?php echo $taxonomy_name; ?>-pop" class="tabs-panel <?php
					echo ( 'most-used' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' );
				?>">
					<ul id="<?php echo $taxonomy_name; ?>checklist-pop" class="categorychecklist form-no-clear" >
						<?php
						$popular_terms = get_terms( $taxonomy_name, array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 10, 'hierarchical' => false ) );
						$args['walker'] = $walker;
						echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $popular_terms), 0, (object) $args );
						?>
					</ul>
				</div><!-- /.tabs-panel -->

				<div id="tabs-panel-<?php echo $taxonomy_name; ?>-all" class="tabs-panel tabs-panel-view-all <?php
					echo ( 'all' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' );
				?>">
					<?php if ( ! empty( $page_links ) ) : ?>
						<div class="add-menu-item-pagelinks">
							<?php echo $page_links; ?>
						</div>
					<?php endif; ?>
					<ul id="<?php echo $taxonomy_name; ?>checklist" data-wp-lists="list:<?php echo $taxonomy_name?>" class="categorychecklist form-no-clear">
						<?php
						$args['walker'] = $walker;
						echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $terms), 0, (object) $args );
						?>
					</ul>
					<?php if ( ! empty( $page_links ) ) : ?>
						<div class="add-menu-item-pagelinks">
							<?php echo $page_links; ?>
						</div>
					<?php endif; ?>
				</div><!-- /.tabs-panel -->

				<div class="tabs-panel <?php
					echo ( 'search' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' );
				?>" id="tabs-panel-search-taxonomy-<?php echo $taxonomy_name; ?>">
					<?php
					if ( isset( $_REQUEST['quick-search-taxonomy-' . $taxonomy_name] ) ) {
						$searched = esc_attr( $_REQUEST['quick-search-taxonomy-' . $taxonomy_name] );
						$search_results = get_terms( $taxonomy_name, array( 'name__like' => $searched, 'fields' => 'all', 'orderby' => 'count', 'order' => 'DESC', 'hierarchical' => false ) );
					} else {
						$searched = '';
						$search_results = array();
					}
					?>
					<p class="quick-search-wrap">
						<input type="search" class="quick-search input-with-default-title" title="<?php esc_attr_e('Search'); ?>" value="<?php echo $searched; ?>" name="quick-search-taxonomy-<?php echo $taxonomy_name; ?>" />
						<span class="spinner"></span>
						<?php submit_button( __( 'Search' ), 'button-small quick-search-submit button-secondary hide-if-js', 'submit', false, array( 'id' => 'submit-quick-search-taxonomy-' . $taxonomy_name ) ); ?>
					</p>

					<ul id="<?php echo $taxonomy_name; ?>-search-checklist" data-wp-lists="list:<?php echo $taxonomy_name?>" class="categorychecklist form-no-clear">
					<?php if ( ! empty( $search_results ) && ! is_wp_error( $search_results ) ) : ?>
						<?php
						$args['walker'] = $walker;
						echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $search_results), 0, (object) $args );
						?>
					<?php elseif ( is_wp_error( $search_results ) ) : ?>
						<li><?php echo $search_results->get_error_message(); ?></li>
					<?php elseif ( ! empty( $searched ) ) : ?>
						<li><?php _e('No results found.'); ?></li>
					<?php endif; ?>
					</ul>
				</div><!-- /.tabs-panel -->

				<p class="button-controls">
					<span class="list-controls">
						<a href="<?php
							echo esc_url(add_query_arg(
								array(
									$taxonomy_name . '-tab' => 'all',
									'selectall' => 1,
								),
								remove_query_arg($removed_args)
							));
						?>#taxonomy-<?php echo $taxonomy_name; ?>" class="select-all"><?php _e( 'Select All', 'crumina-page-slider' ); ?></a>
					</span>

					<span class="add-to-menu">
						<input type="submit"<?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Slider', 'crumina-page-slider' ); ?>" name="add-taxonomy-menu-item" id="submit-taxonomy-<?php echo $taxonomy_name; ?>" />
						<span class="spinner"></span>
					</span>
				</p>
			</div><!-- /.taxonomydiv -->
			<?php
		}

		/**
		 * Generate Quick Search Response
		 * 
		 * @param  array  $request [description]
		 * @return [type]          [description]
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public static function quick_search( $request = array() ) {

			$args            = array();
			$type            = isset( $request['type'] ) ? $request['type'] : '';
			$object_type     = isset( $request['object_type'] ) ? $request['object_type'] : '';
			$query           = isset( $request['q'] ) ? $request['q'] : '';
			$response_format = isset( $request['response-format'] ) && in_array( $request['response-format'], array( 'json', 'markup' ) ) ? $request['response-format'] : 'json';

			if ( 'markup' == $response_format ) {
				$args['walker'] = new CPS_Walker_Slider_Checklist;
			}

			// Get search results
			if ( 'get-post-item' == $type ) {
				if ( post_type_exists( $object_type ) ) {
					if ( isset( $request['ID'] ) ) {
						$object_id = (int) $request['ID'];
						if ( 'markup' == $response_format ) {
							echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', array( get_post( $object_id ) ) ), 0, (object) $args );
						} elseif ( 'json' == $response_format ) {
							$post_obj = get_post( $object_id );
							echo json_encode(
								array(
									'ID'         => $object_id,
									'post_title' => get_the_title( $object_id ),
									'post_type'  => get_post_type( $object_id )
								)
							);
							echo "\n";
						}
					}
				} elseif ( taxonomy_exists( $object_type ) ) {
					if ( isset( $request['ID'] ) ) {
						$object_id = (int) $request['ID'];
						if ( 'markup' == $response_format ) {
							echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', array( get_term( $object_id, $object_type ) ) ), 0, (object) $args );
						} elseif ( 'json' == $response_format ) {
							$post_obj = get_term( $object_id, $object_type );
							echo json_encode(
								array(
									'ID'         => $object_id,
									'post_title' => $post_obj->name,
									'post_type'  => $object_type
								)
							);
							echo "\n";
						}
					}

				}
			} elseif ( preg_match('/quick-search-(posttype|taxonomy)-([a-zA-Z_-]*\b)/', $type, $matches) ) {
				if ( 'posttype' == $matches[1] && get_post_type_object( $matches[2] ) ) {
					query_posts(array(
						'posts_per_page' => 10,
						'post_type'      => $matches[2],
						's'              => $query
					));
					if ( ! have_posts() )
						return;
					while ( have_posts() ) {
						the_post();
						if ( 'markup' == $response_format ) {
							$var_by_ref = get_the_ID();

							echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', array( get_post( $var_by_ref ) ) ), 0, (object) $args );
						} elseif ( 'json' == $response_format ) {
							echo json_encode(
								array(
									'ID'         => get_the_ID(),
									'post_title' => get_the_title(),
									'post_type'  => get_post_type()
								)
							);
							echo "\n";
						}
					}
				} elseif ( 'taxonomy' == $matches[1] ) {
					$terms = get_terms( $matches[2], array(
						'name__like' => $query,
						'number'     => 10
					));
					if ( empty( $terms ) || is_wp_error( $terms ) )
						return;
					foreach( (array) $terms as $term ) {
						if ( 'markup' == $response_format ) {

							/**
							 * Change Object Type Before Output
							 * 
							 * Checks if the search result is for the 'All Posts In Category'
							 * metabox and adds an argument to the $args array before the
							 * walker outputs the items.
							 */
							if ( isset( $request['type'] ) && 'quick-search-taxonomy-category-custom-category' == $request['type'] ) {
								$args['custom_item_type'] = 'category_posts';
							} 

							// Walk through the results and echo back to the client
							echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', array( $term ) ), 0, (object) $args );

						} elseif ( 'json' == $response_format ) {
							echo json_encode(
								array(
									'ID'         => $term->term_id,
									'post_title' => $term->name,
									'post_type'  => $matches[2]
								)
							);
							echo "\n";
						}
					}
				}
			}
		}

		/**
		 * Output Admin Page
		 * 
		 * Render the settings page for this plugin.
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function display_plugin_admin_page() {
			$controller = new CPS_Admin_Controller();
			$controller->render();
		}

		/**
		 * Add Action Links
		 * 
		 * Add settings action link to the plugins page.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */	
		public function add_action_links( $links ) {

			return array_merge(
				array(
					'settings' => '<a href="' . admin_url( '?page=' . $this->plugin_slug ) . '">' . __( 'Manage Sliders', $this->plugin_slug ) . '</a>'
				),
				$links
			);
		}

		/**
		 * Get Screen Tab Options
		 *
		 * This function has been created in order to give developers
		 * a hook by which to add their own screen options.
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function add_screen_option() {
			
			// Bail if hook not defined
			if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
				return;
			}

			$screen = get_current_screen();

			if ( $this->plugin_screen_hook_suffix == $screen->id ) {
				// Developers: Add Options Below
			}
		}

		/**
		 * Add Help Tabs To The Font Generator Admin Page
		 *
		 * Adds contextual help tabs to the custom themes fonts page.
		 * This function is attached to an action that ensures that the
		 * help tabs are only displayed on the custom admin page.
		 *
		 * Custom Actions:
		 * 		- cps-help-tabs
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function add_help_tabs() {

			// Bail if hook not defined
			if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
				return;
			}

			$screen = get_current_screen();

			// Check that this is the Crumina Page Slider admin page
			if ( $this->plugin_screen_hook_suffix == $screen->id ) {
				
				// Add overview tab
				$screen->add_help_tab( array(
					'id'      => 'overview',
					'title'   => __( 'Overview', 'crumina-page-slider' ),
					'content' => $this->get_overview_tab_content(),
				) );

				/**
				 * Hook into this action to add more tabs to the admin page
				 * or remove any tabs defined above, if you wish to change
				 * the tab content based on the theme that is activated.
				 */
				do_action( 'cps-help-tabs', $screen );

				$screen->set_help_sidebar(
					'<p><strong>' . __( 'For more information:', 'crumina-page-slider' ) . '</strong></p>' .
					'<p><a href="mailto:info@crumina.net" target="_blank">' . __( 'E-mail Support', 'crumina-page-slider' ) . '</a></p>' .
					'<p><a href="http://support.crumina.net/" target="_blank">' . __( 'Support Forums', 'crumina-page-slider' ) . '</a></p>'
				);	
			}
		}

		/**
		 * Get Overview Tab
		 *
		 * Gets the html contect to be used in the 'Overview'
		 * tab as a string.
		 * 
		 * @return string $content 	- Tab Content
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function get_overview_tab_content() {
			$content = '';

			$content  .= '<p>' . __( 'This screen is used for managing your page sliders. Page sliders are used to display your post/page/site content in an easy to view slider.', 'crumina-page-slider' ) . '</p>';
			$content .= '<p>' . __( 'From this screen you can:', 'crumina-page-slider' ) . '</p>';
			$content .= '<ul><li>' . __( 'Create, edit, and delete page sliders', 'crumina-page-slider' ) . '</li>';
			$content .= '<li>' . __( 'Choose a template for each page slider.', 'crumina-page-slider' ) . '</li>';
			$content .= '<li>' . __( 'Add, organize, and modify pages/posts etc that belong to a page slider', 'crumina-page-slider' ) . '</li></ul>';


			// Return tab content
			return $content;
		}

		public static function get_page_slider_attachment_markup( $page_slider_id ) {
			
			// Make sure user has the required access level
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_die( -1 );			
			}

			/**
			 * Include Nav Menu File
			 * 
			 * As this function uses some of the utility functions 
			 * contained in this file.
			 * 
			 */
			require_once ABSPATH . 'wp-admin/includes/nav-menu.php';

			/**
			 * Variables used to generate menu output
			 * @var mixed
			 */
			$output          = '';
			$page_slider     = CPS_Posttype::get_page_slider( $page_slider_id );
			$menu_items      = array();
			$menu_items_data = array();
			$item_ids        = array();
			
			if ( $page_slider ) {

				// Get page slider attachment data
				$attachments = get_post_meta( $page_slider->ID, '_cps_attachments', true );

				// Bail if no attachments
				if ( ! $attachments ) {
					return $output;
				}

				/**
				 * Get Slider Menu Item Data:
				 * 
				 * Loops through the menu items that are attached to
				 * this crumina page slider instance.
				 * 
				 */
				foreach ( $attachments as $attachment ) {
					if ( ! empty( $attachment['menu-item-type'] ) && ! empty( $attachment['menu-item-object-id'] ) ) {
						$menu_item_type = $attachment['menu-item-type'];

						switch ( $menu_item_type ) {
							case 'post_type':
								$item_ids[] = array( 
									'type' => 'post_type', 
									'id'   => $attachment['menu-item-object-id'],
									'data' => $attachment,
								);
								break;
							
							case 'taxonomy':
								$item_ids[] = array( 
									'type' => 'taxonomy', 
									'id'   => $attachment['menu-item-object-id'],
									'data' => $attachment,
								);
								break;
						}

						$menu_items_data[] = $attachment;
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
							$tax_term = get_term_by( 'id', (int) $menu_item_id['data']['menu-item-object-id'], $tax_obj->name );

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
								$menu_item->no_of_posts      = empty( $menu_item_id['data']['menu-item-crumina-number-of-posts'] ) ? '' : $menu_item_id['data']['menu-item-crumina-number-of-posts'];
								$menu_item->post_order       = empty( $menu_item_id['data']['menu-item-crumina-post-order'] ) ? '' : $menu_item_id['data']['menu-item-crumina-post-order'];
								$menu_item->post_offset      = empty( $menu_item_id['data']['menu-item-crumina-post-offset'] ) ? '' : $menu_item_id['data']['menu-item-crumina-post-offset'];

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
						'pending'     => false,
						'walker'      => new $walker_class_name,
					);

					$output .= walk_nav_menu_tree( $menu_items, 0, (object) $args );
				}	

				return $output;
			}


			
			$page_slider_attachments = array();
			$page_slider_data        = array();
			$output                  = '';
			$page_slider_ids         = array();

			if ( $page_slider ) {
				
				// Get page slider attachment data
				$page_slider_attachments = get_post_meta( $page_slider->ID, '_cps_attachments', true );

				foreach ( $page_slider_attachments as $attachment ) {

					// Check what type of object we are working with
					if ( 
						! empty( $attachment['menu-item-type'] )      &&
						! empty( $attachment['menu-item-object-id'] ) &&
						'custom' != $attachment['menu-item-type'] 
					) {
						switch ( $attachment['menu-item-type'] ) {
							case 'post_type':
								$_object = get_post( $attachment['menu-item-object-id'] );
								break;
							
							case 'taxonomy':
								$_object = get_term( $attachment['menu-item-object-id'], $attachment['menu-item-object'] );
								break;
						} // end switch

						// Prepare object if it exists
						if ( $attachment['menu-item-type'] == 'post_type' || $attachment['menu-item-type'] == 'taxonomy') {
							$page_slider_items = array_map( 'wp_setup_nav_menu_item', array( $_object ) );
							$page_slider_item  = array_shift( $page_slider_items );
						}
					}

					$page_slider_data[] = $attachment;
					$page_slider_ids[] = $attachment['menu-item-object-id'];
				}
				// echo "<pre>";
				// print_r($page_slider_data);
				// echo "</pre>";
				



				// // $page_slider_ids = wp_save_nav_menu_items( 0, $page_slider_data );
				
				// echo '------------------';

				// print_r( $page_slider_ids );
				// echo '------------------';

				if ( is_wp_error( $page_slider_ids ) ) {
					wp_die( 0 );
				}

				$page_slider_items = array();

				foreach ( $page_slider_ids as $page_slider_item_id ) {
					$menu_obj = get_post( $page_slider_item_id );
					if ( ! empty( $menu_obj->ID ) ) {
						$menu_obj            = wp_setup_nav_menu_item( $menu_obj );
						$menu_obj->label     = $menu_obj->title; // don't show "(pending)" in ajax-added items
						$page_slider_items[] = $menu_obj;
					}			
				}

				$walker_class_name = apply_filters( 'crumina_edit_slider_walker', 'CPS_Walker_Slider_Edit', $page_slider_attachments );

				if ( ! class_exists( $walker_class_name ) ) {
					wp_die( 0 );
				}

				if ( ! empty( $page_slider_items ) ) {
					$args = array(
						'after'       => '',
						'before'      => '',
						'link_after'  => '',
						'link_before' => '',
						'walker'      => new $walker_class_name,
						'pending'     => false
					);

					$output .= walk_nav_menu_tree( $page_slider_items, 0, (object) $args );
				}					

			} // end if

			return $output;
		}
	}
endif;
