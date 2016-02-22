<?php
/**
 * Class: CPS_Walker_Slider_Edit
 *
 * Create HTML list of sidebar input items. This is 
 * used to generate the markup used to output the 
 * sortable list items used in the admin page.
 *
 * DEVELOPER NOTE:
 * 
 * If you wish to add html markup to the admin toggle
 * panel just check the $item->type object property,
 * in start_el() which will give you either:
 *     - 'post_type'
 *     - 'taxonomy'
 * Use an if statement to determine the type and output
 * your options markup accordingly.
 *
 * @package   Crumina_Page_Slider
 * @author    Sunny Johal <support@titaniumthemes.com>
 * @license   GPL-2.0+
 * @copyright Copyright (c) 2014, Crumina Team
 * @version   1.0
 * 
 */
if ( ! class_exists( 'CPS_Walker_Slider_Edit' ) && class_exists( 'Walker_Nav_Menu' ) ) :
	class CPS_Walker_Slider_Edit extends Walker_Nav_Menu {
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
		 * Start Element Walker
		 *
		 * @see     Walker::start_el()
		 * @since   3.0.0
		 *
		 * @param string       $output - Passed by reference. Used to append additional content.
		 * @param object       $item   - Menu item data object.
		 * @param int          $depth  - Depth of menu item. Used for padding.
		 * @param array|object $args
		 *
		 * @param int          $id
		 *
		 * @since   1.0
		 * @version 1.0
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $_wp_nav_menu_max_depth;
			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			// Start output buffer
			ob_start();

			$item_id   = esc_attr( $item->ID );
			$page_name = 'crumina-page-slider';
			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);

			// Set the title
			$original_title = '';

			if ( 'taxonomy' == $item->type ) {
				$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
				if ( is_wp_error( $original_title ) ) {
					$original_title = false;
				}

			} elseif ( 'post_type' == $item->type ) {
				
				$original_object = get_post( $item->object_id );
				$original_title  = $original_object->post_title;

			}

			// Add any classes
			$classes = array(
				'menu-item menu-item-depth-' . $depth,
				'menu-item-' . esc_attr( $item->object ),
				'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
			);

			$title = $item->title;

			if ( ! empty( $item->_invalid ) ) {
				$classes[] = 'menu-item-invalid';
				/* translators: %s: title of menu item which is invalid */
				$title = sprintf( __( '%s (Invalid)' ), $item->title );
			} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {

				if ( isset( $args->pending ) ) {
					
					if ( ! $args->pending ) {
						$classes[] = 'not-pending';
					} else {
						$classes[] = 'pending';
					}

				} else {
					$classes[] = 'pending';
				}
				
				/* translators: %s: title of menu item in draft status */
				$title = sprintf( __('%s (Pending)'), $item->title );
			}

			$title = empty( $item->label ) ? $title : $item->label;
			?>
			<li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
						<span class="item-title"><?php echo esc_html( $title ); ?></span>
						<span class="item-controls">
							<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
							<a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Slider Item', 'crumina-page-slider' ); ?>" href="#">
								<?php _e( 'Edit Slider Item', 'theme-translate' ); ?>
							</a>
						</span>
					</dt>
				</dl>

				<div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">

					<?php if ( 'taxonomy' == $item->type ) : ?>
						<?php
							/**
							 * Taxonomy Specific Options
							 *
							 * Gets specific taxonomy 
							 * 
							 * Custom Filters:
							 *     - crumina_default_post_offset
							 *     - crumina_default_post_order
							 *     - crumina_default_number_of_posts
							 *
							 */
							$post_offset = apply_filters( 'crumina_default_post_offset', 0 );
							$post_order  = apply_filters( 'crumina_default_post_order', 'DESC' );
							$no_of_posts = apply_filters( 'crumina_default_number_of_posts', 10 );

							if ( ! empty( $item->post_offset ) ) {
								$post_offset = $item->post_offset;
							}

							if ( ! empty( $item->post_order ) ) {
								$post_order = $item->post_order;
							}

							if ( ! empty( $item->no_of_posts ) ) {
								$no_of_posts = $item->no_of_posts;
							}

						?>
						<div class="crumina-tax-options-wrapper">
							<div class="query-option">
								<label for="menu-item-crumina-post-offset"><?php _e( 'Post Offset:', 'crumina-page-slider' ); ?></label>
								<input class="menu-item-crumina-post-offset" name="menu-item-crumina-post-offset[<?php echo $item_id; ?>]" value="<?php echo $post_offset; ?>" type="number">
								<div class="clear"></div>
							</div>

							<div class="query-option">
								<label for="menu-item-crumina-post-order"><?php _e( 'Post Order:', 'crumina-page-slider' ); ?></label>
								<select class="menu-item-crumina-post-order" name="menu-item-crumina-post-order[<?php echo $item_id; ?>]" id="">
									<option value="ASC" <?php if ( selected( $post_order, 'ASC' ) ) : ?>selected<?php endif; ?>><?php _e( 'ASC', 'crumina-page-slider' ); ?></option>
									<option value="DESC" <?php if ( selected( $post_order, 'DESC' ) ) : ?>selected<?php endif; ?>><?php _e( 'DESC', 'crumina-page-slider' ); ?></option>
								</select>
								<div class="clear"></div>
							</div>

							<div class="query-option">
								<label for="menu-item-crumina-number-of-posts"><?php _e( 'Number of items:', 'crumina-page-slider' ); ?></label>
								<select class="menu-item-crumina-number-of-posts" name="menu-item-crumina-number-of-posts[<?php echo $item_id; ?>]" id="">
									<option value="1"  <?php if ( selected( $no_of_posts, '1' ) )  : ?>selected<?php endif; ?>><?php _e( '1', 'crumina-page-slider' ); ?></option>
									<option value="2"  <?php if ( selected( $no_of_posts, '2' ) )  : ?>selected<?php endif; ?>><?php _e( '2', 'crumina-page-slider' ); ?></option>
									<option value="3"  <?php if ( selected( $no_of_posts, '3' ) )  : ?>selected<?php endif; ?>><?php _e( '3', 'crumina-page-slider' ); ?></option>
									<option value="4"  <?php if ( selected( $no_of_posts, '4' ) )  : ?>selected<?php endif; ?>><?php _e( '4', 'crumina-page-slider' ); ?></option>
									<option value="5"  <?php if ( selected( $no_of_posts, '5' ) )  : ?>selected<?php endif; ?>><?php _e( '5', 'crumina-page-slider' ); ?></option>
									<option value="6"  <?php if ( selected( $no_of_posts, '6' ) )  : ?>selected<?php endif; ?>><?php _e( '6', 'crumina-page-slider' ); ?></option>
									<option value="7"  <?php if ( selected( $no_of_posts, '7' ) )  : ?>selected<?php endif; ?>><?php _e( '7', 'crumina-page-slider' ); ?></option>
									<option value="8"  <?php if ( selected( $no_of_posts, '8' ) )  : ?>selected<?php endif; ?>><?php _e( '8', 'crumina-page-slider' ); ?></option>
									<option value="9"  <?php if ( selected( $no_of_posts, '9' ) )  : ?>selected<?php endif; ?>><?php _e( '9', 'crumina-page-slider' ); ?></option>
									<option value="10" <?php if ( selected( $no_of_posts, '10' ) ) : ?>selected<?php endif; ?>><?php _e( '10', 'crumina-page-slider' ); ?></option>
								</select>
								<div class="clear"></div>
							</div>
						</div>
					<?php endif; ?>
					
					<div class="menu-item-actions description-wide submitbox">
						<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
							<p class="link-to-original">
								<?php printf( __( 'Original: %s' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
							</p>
						<?php endif; ?>
						<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
						echo wp_nonce_url(
							add_query_arg(
								array(
									'action'       => 'delete-sidebar-item',
									'sidebar-item' => $item_id,
									'page'         => $page_name
								),
								remove_query_arg($removed_args, admin_url( 'themes.php' ) )
							),
							'delete-menu_item_' . $item_id
						); ?>"><?php _e('Remove'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php	echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'themes.php' ) ) ) );
							?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel'); ?></a>
					</div>
					
					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php esc_html_e( $item_id ); ?>]" value="<?php esc_html_e( $item_id ); ?>" />
					<input class="menu-item-title" type="hidden" name="menu-item-title[<?php esc_html_e( $original_title ); ?>]" value="<?php esc_html_e( $original_title ); ?>">
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
			<?php
			// Append to output
			$output .= ob_get_clean();
		}
	}
endif;