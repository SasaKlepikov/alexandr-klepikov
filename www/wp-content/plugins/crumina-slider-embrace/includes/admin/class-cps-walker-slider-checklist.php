<?php
/**
 * Class: CPS_Walker_Slider_Checklist
 *
 * Create HTML list of sidebar input items. This is 
 * used to generate the markup used to output the 
 * checkbox items in the sidebar on the admin settings
 * page.
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */
if ( ! class_exists( 'CPS_Walker_Slider_Checklist' ) && class_exists( 'Walker_Nav_Menu' ) ) :
	class CPS_Walker_Slider_Checklist extends Walker_Nav_Menu {
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
		function __construct( $fields = false ) {

			if ( $fields ) {
				$this->db_fields = $fields;
			}

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
		 * Start Level Ouput
		 *
		 * Outputs the container opening tag to wrap the 
		 * children list elements. This function overrides
		 * the parent function of the same name.
		 * 
		 * @param  string  $output - Actual reference to the string output
		 * @param  integer $depth  - Current iteration depth
		 * @param  array   $args   - Property args
		 * 
		 * @return string $output 	- The combined string output so far
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent  = str_repeat( "\t", $depth );
			$output .= "\n$indent<ul class='children'>\n";
		}		

		/**
		 * End Level Ouput
		 *
		 * Outputs the container opening tag to wrap the 
		 * children list elements. This function overrides
		 * the parent function of the same name.
		 * 
		 * @param  string  $output - Actual reference to the string output
		 * @param  integer $depth  - Current iteration depth
		 * @param  array   $args   - Property args
		 * 
		 * @return string $output 	- The combined string output so far
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent  = str_repeat( "\t", $depth );
			$output .= "\n$indent</ul>";
		}

		/**
		 * Start Element Walker
		 * 
		 * @see Walker::start_el()
		 * @since 3.0.0
		 *
		 * @param string 	$output 	- Passed by reference. Used to append additional content.
		 * @param object 	$item 		- Menu item data object.
		 * @param int 		$depth 		- Depth of menu item. Used for padding.
		 * @param object 	$args
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $_nav_menu_placeholder;

			$_nav_menu_placeholder = ( 0 > $_nav_menu_placeholder ) ? intval($_nav_menu_placeholder) - 1 : -1;
			$possible_object_id    = isset( $item->post_type ) && 'nav_menu_item' == $item->post_type ? $item->object_id : $_nav_menu_placeholder;
			$possible_db_id        = ( ! empty( $item->ID ) ) && ( 0 < $possible_object_id ) ? (int) $item->ID : 0;

			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			/**
			 * Check if a custom item type is defined and modify
			 * the $item->type property accordingly. This allows
			 * us to pass in custom data types in future updates
			 * when required.
			 */
			if ( isset( $args->custom_item_type ) ) {
				$item->type = $args->custom_item_type;
			}

			$output .= $indent . '<li>';
			$output .= '<label class="menu-item-title">';
			$output .= '<input type="checkbox" class="menu-item-checkbox';
			
			if ( property_exists( $item, 'front_or_home' ) && $item->front_or_home ) {
				$title   = sprintf( _x( 'Home: %s', 'nav menu front page title' ), $item->post_title );
				$output .= ' add-to-top';
			}

			$output .= '" name="menu-item[' . $possible_object_id . '][menu-item-object-id]" value="'. esc_attr( $item->object_id ) .'" /> ';
			$output .= isset( $title ) ? esc_html( $title ) : esc_html( $item->title );
			$output .= '</label>';

			// Menu item hidden fields		
			$output .= '<input type="hidden" class="menu-item-db-id" name="menu-item[' . $possible_object_id . '][menu-item-db-id]" value="' . $possible_db_id . '" />';
			$output .= '<input type="hidden" class="menu-item-object" name="menu-item[' . $possible_object_id . '][menu-item-object]" value="'. esc_attr( $item->object ) .'" />';
			$output .= '<input type="hidden" class="menu-item-parent-id" name="menu-item[' . $possible_object_id . '][menu-item-parent-id]" value="'. esc_attr( $item->menu_item_parent ) .'" />';
			$output .= '<input type="hidden" class="menu-item-type" name="menu-item[' . $possible_object_id . '][menu-item-type]" value="'. esc_attr( $item->type ) .'" />';
			$output .= '<input type="hidden" class="menu-item-title" name="menu-item[' . $possible_object_id . '][menu-item-title]" value="'. esc_attr( $item->title ) .'" />';
			$output .= '<input type="hidden" class="menu-item-url" name="menu-item[' . $possible_object_id . '][menu-item-url]" value="'. esc_attr( $item->url ) .'" />';
			$output .= '<input type="hidden" class="menu-item-target" name="menu-item[' . $possible_object_id . '][menu-item-target]" value="'. esc_attr( $item->target ) .'" />';
			$output .= '<input type="hidden" class="menu-item-attr_title" name="menu-item[' . $possible_object_id . '][menu-item-attr_title]" value="'. esc_attr( $item->attr_title ) .'" />';
			$output .= '<input type="hidden" class="menu-item-classes" name="menu-item[' . $possible_object_id . '][menu-item-classes]" value="'. esc_attr( implode( ' ', $item->classes ) ) .'" />';
			$output .= '<input type="hidden" class="menu-item-xfn" name="menu-item[' . $possible_object_id . '][menu-item-xfn]" value="'. esc_attr( $item->xfn ) .'" />';			
		}
		
	}
endif;