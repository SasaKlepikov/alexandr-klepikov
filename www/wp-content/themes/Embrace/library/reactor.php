<?php
/**
 * Reactor - A WordPress Framework based on Foundation by ZURB
 * Include the necessary files for Reactor Theme
 * Some files are included based on theme support
 *
 * @package   Reactor
 * @author    Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since     1.1.0
 * @copyright Copyright (c) 2013, Anthony Wilhelm
 * @license   GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

class Reactor {

	function __construct() {
		global $reactor;

		$reactor = new stdClass;

		add_action( 'after_setup_theme', array( &$this, 'options' ), 6 );
		add_action( 'after_setup_theme', array( &$this, 'extensions' ), 12 );
		add_action( 'after_setup_theme', array( &$this, 'functions' ), 13 );
		add_action( 'after_setup_theme', array( &$this, 'content' ), 14 );

	}

	function options() {
		// function to get options
		require_once locate_template( '/library/inc/functions/get-options.php' );
		//require_once locate_template('/library/inc/customizer/customize.php');

		if ( ! class_exists( 'ReduxFramework' ) ) {
			require_once locate_template( '/options/ReduxCore/framework.php' );
		}

		require_once locate_template( '/options/options.php' );


	}

	function extensions() {
		// required extensions
		require_once locate_template( '/library/inc/extensions/mr-image-resize.php' );
		require_once locate_template( '/library/inc/extensions/comments.php' );
		require_once locate_template( '/library/inc/extensions/styles.php' );
		require_once locate_template( '/library/inc/extensions/scripts.php' );
		require_once locate_template( '/library/inc/metaboxes/meta-fields.php' );
		require_once locate_template( '/library/inc/icons/icons.php' );
		require_once locate_template( '/library/inc/plugins/tgm-config.php' );

		// custom widgets
		require_once locate_template( '/library/inc/widgets/recent-posts.php' );
		require_once locate_template( '/library/inc/widgets/widget-vcard.php' );
		require_once locate_template( '/library/inc/widgets/widget-facebook.php' );
		require_once locate_template( '/library/inc/widgets/widget-flickr.php' );
		require_once locate_template( '/library/inc/widgets/widget-gallery.php' );
		require_once locate_template( '/library/inc/widgets/widget-tabs.php' );
		require_once locate_template( '/library/inc/widgets/widget-tag-cloud.php' );
		require_once locate_template( '/library/inc/widgets/widget-tweets.php' );
		require_once locate_template( '/library/inc/widgets/widget-social-buttons.php' );
		require_once locate_template( '/library/inc/widgets/widget-socnetworks.php' );
		require_once locate_template( '/library/inc/widgets/widget-featured-posts.php' );

		require_once locate_template( '/library/inc/format-posts/cf-post-formats.php' );

		//Theme update
		//require_once locate_template( '/library/inc/envato-wordpress-toolkit/index.php' );

		// if theme supports extensions
		require_if_theme_supports( 'reactor-menus', locate_template( '/library/inc/extensions/walkers.php' ) );
		require_if_theme_supports( 'reactor-menus', locate_template( '/library/inc/extensions/menus.php' ) );
		require_if_theme_supports( 'reactor-post-types', locate_template( '/library/inc/extensions/post-types.php' ) );
		require_if_theme_supports( 'reactor-sidebars', locate_template( '/library/inc/extensions/sidebars.php' ) );

		load_theme_textdomain('crum', get_template_directory() . '/translation');


		#-----------------------------------------------------------------#
		# Crumina WC
		#-----------------------------------------------------------------#

		//load VC if not already active
		if ( function_exists( 'vc_set_as_theme' ) ) {
			vc_set_as_theme( $disable_updater = true );

		}

		/*if ( function_exists( 'vc_disable_frontend' ) ) {
			vc_disable_frontend();
		}*/

		if ( function_exists( 'vc_set_template_dir' ) ) {
			$dir = get_stylesheet_directory() . '/vc_templates/';
			vc_set_template_dir( $dir );
		}


		//Add Functionality to VC
		if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {


			function crumina_css_classes_for_vc_row_and_vc_column( $class_string, $tag = '' ) {

				if ( $tag == 'vc_row' || $tag == 'vc_row_inner' ) {
					$class_string = str_replace( 'vc_row-fluid', 'row', $class_string );
					$class_string = str_replace( 'wpb_row', '', $class_string );
				}

				return $class_string;
			}

			// Filter to Replace default css class for vc_row shortcode and vc_column
			add_filter( 'vc_shortcodes_css_class', 'crumina_css_classes_for_vc_row_and_vc_column', 10, 2 );


			function add_crumina_to_vc() {
				require_once locate_template( '/library/inc/crum-vc-ultimate/crum-addons.php' );
				require_once locate_template( '/library/inc/crum-vc-ultimate/crum-icon-manager.php' );
				require_once locate_template( '/library/inc/crum-vc-ultimate/crum-woo-addons.php' );

				//Presentation modules

				$modules_path = locate_template( '/library/inc/crum-vc-ultimate/modules' );

				// activate addons one by one from modules directory
				foreach ( glob( $modules_path . "/*.php" ) as $module ) {
					require_once( $module );
				}

				//update_option('wpb_js_content_types',Array('page','post','portfolio','megamenu'));
			}

			add_action( 'init', 'add_crumina_to_vc', 10 );

			function crum_remove_vc_meta_boxes() {

				if ( function_exists('vc_editor_post_types') ) {
					$pt_array = vc_editor_post_types();
					foreach ( $pt_array as $pt ) {
						remove_meta_box( 'vc_teaser', $pt, 'side' );

					}
				}
			}

			add_action( 'admin_init', 'crum_remove_vc_meta_boxes' );

			function crum_vc_styles_collected(){
                wp_deregister_style('js_composer_front');
			}
			add_action('wp_enqueue_scripts','crum_vc_styles_collected');

			//visual composer admin styles
			function crumina_vc_styles() {
				wp_enqueue_style( 'crum_vc', get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/css/crum-addons.css', array(), time(), 'all' );
				wp_enqueue_script( 'vc-inline-editor', get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/vc-inline-editor.js', array( 'vc_inline_custom_view_js' ), '1.5', true );
			}

			add_action( 'admin_enqueue_scripts', 'crumina_vc_styles' );


			function crum_vc_add_admin_fonts() {
				$paths            = wp_upload_dir();
				$paths['fonts']   = 'atlantis_fonts';
				$paths['fonturl'] = trailingslashit( $paths['baseurl'] ) . $paths['fonts'];

				$fonts = get_option( 'atlantis_fonts' );
				if ( is_array( $fonts ) ) {
					foreach ( $fonts as $font => $info ) {
						$style_url = $info['style'];
						if ( strpos( $style_url, 'http://' ) !== false ) {
							wp_enqueue_style( 'crumina-font-' . $font, $info['style'] );
						} else {
							wp_enqueue_style( 'crumina-font-' . $font, trailingslashit( $paths['fonturl'] ) . $info['style'] );
						}
					}
				}
			}

			add_action( 'admin_enqueue_scripts', 'crum_vc_add_admin_fonts' );

			//visual composer frontend styles

			function crumina_vc_front_styles() {
				wp_enqueue_script( 'jquery.video_bg', get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/ultimate_bg.js', array( 'jquery' ), '1.0', true );
				wp_enqueue_script( 'aio-jquery-appear', get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/jquery.appear.js', array( 'jquery' ), '1.5', true );
				wp_enqueue_script( 'aio-custom', get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/custom.js', array( 'jquery' ), '1.5', true );
			}

			add_action( 'wp_enqueue_scripts', 'crumina_vc_front_styles' );


            if(class_exists('WPBMap')):
                function vc_gallery_description() {
                    //Get current values stored in the color param in "Call to Action" element
                    $param = WPBMap::getParam('vc_gallery', 'img_size');
                    //Append new value to the 'value' array
                    $param['description'] =  __( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'crum' );
                    //Finally "mutate" param with new values
                    WPBMap::mutateParam('vc_gallery', $param);
                }
                add_action('init', 'vc_gallery_description');
            endif;

            if(class_exists('WPBMap')):
                function vc_single_image_description() {
                    //Get current values stored in the color param in "Call to Action" element
                    $param = WPBMap::getParam('vc_single_image', 'img_size');
                    //Append new value to the 'value' array
                    $param['description'] =  __( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'crum' );
                    //Finally "mutate" param with new values
                    WPBMap::mutateParam('vc_single_image', $param);
                }
                add_action('init', 'vc_single_image_description');
            endif;


 		}

		require_if_theme_supports( 'reactor-shortcodes', locate_template( '/library/inc/shortcodes/reactor-shortcodes.php' ) );

	}

	function functions() {
		// required functions
		require_once locate_template( '/library/inc/functions/columns.php' );
		require_once locate_template( '/library/inc/functions/helpers.php' );

		// optional functions
		require_once locate_template( '/library/inc/functions/top-bar.php' );
		require_once locate_template( '/library/inc/functions/slider.php' );

		//social count options
		require_once locate_template( '/library/inc/functions/social-counters.php' );

		// if theme supports functions
		require_if_theme_supports( 'reactor-breadcrumbs', locate_template( '/library/inc/functions/breadcrumbs.php' ) );
		require_if_theme_supports( 'reactor-custom-login', locate_template( '/library/inc/functions/custom-login.php' ) );
		require_if_theme_supports( 'reactor-page-links', locate_template( '/library/inc/functions/page-links.php' ) );
		require_if_theme_supports( 'reactor-post-meta', locate_template( '/library/inc/functions/post-meta.php' ) );
		require_if_theme_supports( 'reactor-tumblog-icons', locate_template( '/library/inc/functions/tumblog-icons.php' ) );
		require_if_theme_supports( 'reactor-taxonomy-subnav', locate_template( '/library/inc/functions/taxonomy-subnav.php' ) );
	}

	function content() {
		// hooked content
		require_once locate_template( '/library/inc/extensions/hooks.php' );
		require_once locate_template( '/library/inc/content/content-header.php' );
		require_once locate_template( '/library/inc/content/content-footer.php' );
		require_once locate_template( '/library/inc/content/content-posts.php' );
		require_once locate_template( '/library/inc/content/content-pages.php' );
		require_once locate_template( '/library/inc/content/content-templates.php' );
	}

}


/**
 *	Mega Menu
 */


if (!defined('CRUM_MEGA_MENU_CLASS')) define('CRUM_MEGA_MENU_CLASS', 'Crum_Mega_menu');
if (!defined('CRUM_EDIT_MENU_WALKER_CLASS')) define('CRUM_EDIT_MENU_WALKER_CLASS', 'Crum_Edit_Menu_Walker');
if (!defined('CRUM_NAV_MENU_WALKER_CLASS')) define('CRUM_NAV_MENU_WALKER_CLASS', 'Crum_Nav_Menu_Walker');

if (!function_exists('crum_mega_menu_init')) {
	function crum_mega_menu_init() {
		require_once locate_template('library/inc/menu/edit_mega_menu_walker.php');
		require_once locate_template('library/inc/menu/mega_menu.php');

		$class = CRUM_MEGA_MENU_CLASS;
		$mega_menu = new $class();
	}
}