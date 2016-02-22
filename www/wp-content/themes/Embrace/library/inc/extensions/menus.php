<?php
/**
 * Register Menus
 * register menus in WordPress
 * creates menu functions for use in theme
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @author Eddie Machado (@eddiemachado / themeble.com/bones)
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */
add_action('init', 'reactor_register_menus'); 

function reactor_register_menus() {

    /**
	 * Register navigation menus for a theme.
	 *
	 * @since 1.0.0
	 * @param array $locations Associative array of menu location identifiers (like a slug) and descriptive text.
	 */
	$menus = get_theme_support( 'reactor-menus' );
	
	if ( !is_array( $menus[0] ) ) {
		return;
	}
	
	if ( in_array('top-bar-l', $menus[0] ) ) {
		register_nav_menu('top-bar-l', __( 'Top Bar Left', 'crum'));
	}
	
	if ( in_array( 'top-bar-r', $menus[0] ) ) {
		register_nav_menu('top-bar-r', __( 'Top Bar Right', 'crum'));
	}
	
	if ( in_array( 'sidebar-secondary', $menus[0] ) ) {
		register_nav_menu('sidebar-secondary', __( 'Sliding Menu', 'crum'));
	}
    if ( in_array( 'main-menu', $menus[0] ) ) {
        register_nav_menu('main-menu', __( 'Main Menu', 'crum'));
    }
	
	if ( in_array( 'footer-links', $menus[0] ) ) {
		register_nav_menu('footer-links', __( 'Footer Links', 'crum'));
	}
	
}
	
/**
 * Top bar left menu
 *
 * @since 1.0.0
 * @see wp_nav_menu
 * @param array $locations Associative array of menu location identifiers (like a slug) and descriptive text.
 */
if ( !function_exists('reactor_top_bar_l') ) { 
	function reactor_top_bar_l() {
		$defaults = array( 
			'theme_location'  => 'top-bar-l',
			'container'       => false,
			'menu_class'      => 'top-bar-menu left',
			'echo'            => 0,
			'fallback_cb'     => false,
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 1,
			'walker'          => new Top_Bar_Walker()
		 );
		$top_bar_l_menu = get_transient( 'nav-top-bar-l' );


		if ( $top_bar_l_menu == false ) {

			$top_bar_l_menu = wp_nav_menu( $defaults );
			set_transient( 'nav-top-bar-l', $top_bar_l_menu );
		}

		return $top_bar_l_menu;
	}
}
				
/**
 * Top bar right menu
 *
 * @since 1.0.0
 * @see wp_nav_menu
 * @param array $locations Associative array of menu location identifiers (like a slug) and descriptive text.
 */
if ( !function_exists('reactor_top_bar_r') ) {
	function reactor_top_bar_r() {
		$defaults = array( 
			'theme_location'  => 'top-bar-r',
			'container'       => false,
			'menu_class'      => 'top-bar-menu right',
			'echo'            => 0,
			'fallback_cb'     => false,
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 1,
			'walker'          => new Top_Bar_Walker()
		 );
		$top_bar_r_menu = get_transient( 'nav-top-bar-r' );

		if ( $top_bar_r_menu == false ) {

			$top_bar_r_menu = wp_nav_menu( $defaults );
			set_transient( 'nav-top-bar-r', $top_bar_r_menu );
		}

		return $top_bar_r_menu;
	}
}
		
/**
 * Main menu
 *
 * @since 1.0.0
 * @see wp_nav_menu
 * @param array $locations Associative array of menu location identifiers (like a slug) and descriptive text.
 */
if ( ! function_exists( 'reactor_main_menu' ) ) {
	function reactor_main_menu() {
		$defaults = array(
			'theme_location' => 'main-menu',
			'container'      => false,
			'depth'          => 5,
			'echo'				=> false,
			'fallback_cb'    => 'crum_menu_fallback',
			'menu_class'     => 'menu-primary-navigation',
			'walker'         => new Crum_Nav_Menu_Walker()
		);




		//$main_menu = get_transient( 'nav-main-menu' );

		//if ( $main_menu === false ) {

			$main_menu = wp_nav_menu( $defaults );

			//set_transient( 'nav-main-menu', $main_menu );
		//}

		echo $main_menu;

	}
}

/**
 * Footer menu
 *
 * @since 1.0.0
 * @see wp_nav_menu
 * @param array $locations Associative array of menu location identifiers (like a slug) and descriptive text.
 */
if ( !function_exists('reactor_footer_links') ) {
	function reactor_footer_links() { 
		$defaults = array( 
			'theme_location'  => 'footer-links',
			'container'       => false,
			'menu_class'      => 'inline-list',
			'echo'				=> 0,
			'fallback_cb'     => false,
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 1,
		 );

		$footer_menu = wp_nav_menu( $defaults );

        return $footer_menu;


	}
}
/**
 * Aside Sliding menu
 *
 * @since 1.0.0
 * @see wp_nav_menu
 * @param array $locations Associative array of menu location identifiers (like a slug) and descriptive text.
 */
if ( !function_exists('reactor_sidebar_menu') ) {
	function reactor_sidebar_menu() {
		$defaults = array(
			'theme_location'  => 'sidebar-secondary',
			'container'       => false,
			'menu_class'      => 'cd-navigation',
            'echo'				=> 0,
			'fallback_cb'     => false,
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 2,
            'walker'         => new Crum_Clean_Walker()
		 );

		$reactor_sidebar_menu = get_transient( 'nav-sidebar-secondary' );

		if ( $reactor_sidebar_menu === false ) {

			$reactor_sidebar_menu = wp_nav_menu( $defaults );
			set_transient( 'nav-sidebar-secondary', $reactor_sidebar_menu );
		}

		echo ($reactor_sidebar_menu);

	}
}

/**
 * Clear menu cache
 *
 * @since 1.0.0
 * @see wp_nav_menu
 * @param array $locations Associative array of menu location identifiers (like a slug) and descriptive text.
 */

function crum_invalidate_nav_cache( $id )
{
	$locations = get_nav_menu_locations();
	if( is_array( $locations ) && $locations )
	{
		$locations = array_keys( $locations, $id );
		if( $locations )
		{
			foreach( $locations as $location )
			{
				delete_transient( 'nav-' . $location );
			}
		}
	}
}
add_action( 'wp_update_nav_menu', 'crum_invalidate_nav_cache' );
add_action( 'save_post', 'crum_invalidate_nav_cache' );