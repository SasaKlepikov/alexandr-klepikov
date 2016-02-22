<?php

if (!class_exists('Crum_Mega_menu')) {
	class Crum_Mega_menu {
		var $_options;

		public function __construct() {
			$this->_options = self::options();
			$this->_add_filters();
			$this->get_megamenus();
		}

		private static function get_megamenus() {
			$args = array(
				'post_type' => 'megamenu',
				'posts_per_page' => -1
			);


			$post_id = array('0');
			$post_title = array(__('No', 'crum'));
			$postslist = get_posts( $args );
			foreach ($postslist as $posts){
				if ( isset($posts->ID) ) {
					$post_id[] .= $posts->ID;
					$post_title[] .= $posts->post_title;
				}
			}

			$megamenus = array_combine($post_id, $post_title);

			return $megamenus;
		}

		public static function options() {

			return array(
				'_crum_mega_menu_icon' => array(
					'type' => 'text',
					'label' => __( 'Icon', 'crum' ),
					'default' => '',
					'size' => 'wide',
				),
				'_crum_mega_menu_enabled'	=> array(
					'type' => 'select',
					'label' => __( 'Enable mega menu', 'crum' ),
					'default' => 0,
					'options' => array(1=>__( 'Yes', 'crum' ), 0=>__( 'No', 'crum' )),
					'size' => 'thin',
					'class' => 'crum-show-only-depth-0',
				),
				'_crum_mega_menu_columns'	=> array(
					'type' => 'select',
					'label' => __( 'Columns', 'crum' ),
					'default' => '3',
					'options' => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4'
					),
					'size' => 'thin',
					'class' => 'crum-show-only-depth-0',
				),
				'_crum_mega_menu_full'	=> array(
					'type' => 'select',
					'label' => __('Full width block?','crum'),
					'default' => 1,
					'options' => array(1=>__('Yes', 'crum'), 0=>__('No', 'crum')),
					'size' => 'thin',
					'class' => 'crum-show-only-depth-0',
				),
				'_crum_mega_menu_page'	=> array(
					'type' => 'select',
					'label' => __('Use content instead of submenu?','crum'),+
					'default' => 0,
					'options' =>  self::get_megamenus(),
					'size' => 'thin',
					'class' => 'crum-show-only-depth-0',
				),
				'_crum_mega_menu_image' => array(
					'type' => 'text',
					'label' => __('Select image for background','crum'),
					'default' => '',
					'size' => 'wide',
					'class' => 'crum-show-only-depth-0',
				),
				'_crum_mega_menu_color' => array(
					'type' => 'text',
					'label' => __('Select background color','crum'),
					'default' => '',
					'size' => 'thin',
					'class' => 'crum-show-only-depth-0',
				),
				'_crum_mega_menu_font_color' => array(
					'type' => 'text',
					'label' => __('Select font color','crum'),
					'default' => '',
					'size' => 'thin',
					'class' => 'crum-show-only-depth-0',
				),
			);
		}



		private function _add_filters() {
			# Add custom options to menu
			add_filter('wp_setup_nav_menu_item', array($this, 'add_custom_options'));

			# Update custom menu options
			add_action('wp_update_nav_menu_item', array($this, 'update_custom_options'), 10, 3);

			# Set edit menu walker
			add_filter('wp_edit_nav_menu_walker', array($this, 'apply_edit_walker_class'), 10, 2);

			# Addition style
			add_action('admin_enqueue_scripts', array( $this, 'add_menu_css' ));

		}

		/**
		 * Register custom options and load options values
		 *
		 * @param obj $item Menu Item
		 * @return obj Menu Item
		 */
		public function add_custom_options($item) {

			foreach($this->_options as $option => $params) {
				$item->$option = get_post_meta($item->ID, $option, true);
				if ($item->$option===false) {
					if ( isset($params['default']) && !($params['default'] == '') ) {
						$item->$option = $params['default'];
					}
				}
			}

			return $item;
		}

		public function update_custom_options($menu_id, $menu_item_id, $args) {
			foreach($this->_options as $option => $params) {
				$key = 'menu-item-'. $option;

				$option_value = '';

				if (isset($_REQUEST[$key], $_REQUEST[$key][$menu_item_id])) {
					$option_value = $_REQUEST[$key][$menu_item_id];
				}

				update_post_meta($menu_item_id, $option, $option_value );
			}
		}

		public function apply_edit_walker_class( $walker, $menu_id ) {
			return CRUM_EDIT_MENU_WALKER_CLASS;
		}

		public function add_menu_css() {
			$css = "
				.menu-item .crum-show-only-depth-0 { display: none; }
				.menu-item.menu-item-depth-0 .crum-show-only-depth-0 { display: block; }
				.menu-item .crum-hide-only-depth-0 { display: block; }
				.menu-item.menu-item-depth-0 .crum-hide-only-depth-0 { display: none; }
			";
			wp_add_inline_style('wp-admin', $css);
		}
	}
}
