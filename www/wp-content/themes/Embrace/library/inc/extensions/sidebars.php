<?php
/**
 * Register Sidebar Widget Areas
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 * @see register_sidebar
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */
add_action('widgets_init', 'reactor_register_sidebars'); 

function reactor_register_sidebars() {

	$sidebars = get_theme_support( 'reactor-sidebars' );
	
	if ( !is_array( $sidebars[0] ) ) {
		return;
	}
	
	if ( in_array( 'primary', $sidebars[0] ) ) {
		register_sidebar( array( 
			'name'          => __('Left Sidebar', 'crum'),
			'id'            => 'sidebar',
			'class'         => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
	
	if ( in_array( 'secondary', $sidebars[0] ) ) {	
		register_sidebar( array( 
			'name'          => __('Right Sidebar', 'crum'),
			'id'            => 'sidebar-2',
			'class'         => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}

	if ( in_array( 'front-primary', $sidebars[0] ) ) {
		register_sidebar( array(
			'name'          => __('Front Page Primary', 'crum'),
			'id'            => 'sidebar-frontpage',
			'description'   => 'Primary sidebar for the front page template',
			'class'         => '',
			'before_widget' => '<div id="%1$s" class="widget frontpage-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
	
	if ( in_array( 'front-secondary', $sidebars[0] ) ) {
		register_sidebar( array(
			'name'          => __('Front Page Secondary', 'crum'),
			'id'            => 'sidebar-frontpage-2',
			'description'   => 'Secondary sidebar for the front page template',
			'class'         => '',
			'before_widget' => '<div id="%1$s" class="widget frontpage-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}

	if ( in_array( 'footer-column-1', $sidebars[0] ) ) {
		$footer  = '<div id="%1$s" class="widget top-bar-widget ';
		$footer .= ' %2$s">';
		register_sidebar( array(
			'name'          => __('Footer column', 'crum'),
			'id'            => 'footer-column-1',
			'description'   => 'Footer widget area',
			'class'         => '',
			'before_widget' => $footer,
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
    if ( in_array( 'footer-column-2', $sidebars[0] ) ) {
        $footer  = '<div id="%1$s" class="widget top-bar-widget ';
        $footer .= ' %2$s">';
        register_sidebar( array(
            'name'          => __('Footer column 2', 'crum'),
            'id'            => 'footer-column-2',
            'description'   => 'Footer widget area',
            'class'         => '',
            'before_widget' => $footer,
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );
    }
	if ( in_array( 'footer-column-3', $sidebars[0] ) ) {
		$footer  = '<div id="%1$s" class="widget top-bar-widget ';
		$footer .= ' %2$s">';
		register_sidebar( array(
			'name'          => __('Footer column 3', 'crum'),
			'id'            => 'footer-column-3',
			'description'   => 'Footer widget area',
			'class'         => '',
			'before_widget' => $footer,
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
	if ( in_array( 'footer-column-4', $sidebars[0] ) ) {
		$footer  = '<div id="%1$s" class="widget top-bar-widget ';
		$footer .= ' %2$s">';
		register_sidebar( array(
			'name'          => __('Footer column 4', 'crum'),
			'id'            => 'footer-column-4',
			'description'   => 'Footer widget area',
			'class'         => '',
			'before_widget' => $footer,
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
	if ( in_array( 'footer-column-5', $sidebars[0] ) ) {
		$footer  = '<div id="%1$s" class="widget top-bar-widget ';
		$footer .= ' %2$s">';
		register_sidebar( array(
			'name'          => __('Footer column 5', 'crum'),
			'id'            => 'footer-column-5',
			'description'   => 'Footer widget area',
			'class'         => '',
			'before_widget' => $footer,
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
	if ( in_array( 'footer-column-6', $sidebars[0] ) ) {
		$footer  = '<div id="%1$s" class="widget top-bar-widget ';
		$footer .= ' %2$s">';
		register_sidebar( array(
			'name'          => __('Footer column 6', 'crum'),
			'id'            => 'footer-column-6',
			'description'   => 'Footer widget area',
			'class'         => '',
			'before_widget' => $footer,
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
	if ( in_array( 'side-secondary', $sidebars[0] ) ) {
		$footer  = '<div id="%1$s" class="widget top-bar-widget ';
		$footer .= ' %2$s">';
		register_sidebar( array(
			'name'          => __('Side secondary', 'crum'),
			'id'            => 'side-secondary',
			'description'   => 'Secondary panel sidebar',
			'class'         => '',
			'before_widget' => $footer,
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
}
if (class_exists('WPP_F')){
function replace_wp_property_sidebars(){

	global $wp_properties;

	unregister_sidebar('wpp_sidebar_building');
	unregister_sidebar('wpp_sidebar_floorplan');
	unregister_sidebar('wpp_sidebar_single_family_home');

	if(
		!isset( $wp_properties[ 'configuration' ][ 'do_not_register_sidebars' ] ) ||
		( isset( $wp_properties[ 'configuration' ][ 'do_not_register_sidebars' ] ) && $wp_properties[ 'configuration' ][ 'do_not_register_sidebars' ] != 'true' )
	) {
		foreach( (array)$wp_properties[ 'property_types' ] as $property_slug => $property_title ) {
			register_sidebar( array(
				'name'          => sprintf( __( 'Property: %s', 'wpp' ), $property_title ),
				'id'            => "wpp_sidebar_{$property_slug}",
				'description'   => sprintf( __( 'Sidebar located on the %s page.', 'wpp' ), $property_title ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			) );
		}
	}
}
add_action( 'widgets_init', 'replace_wp_property_sidebars', 11 );
}
/**
 * Count Widgets
 * Count the number of widgets to add dynamic column class
 *
 * @param string $sidebar_id id of sidebar
 * @since 1.0.0
 */
function reactor_get_widget_columns( $sidebar_id ) {
	// Default number of columns in Foundation grid is 12
	$columns = apply_filters( 'reactor_columns', 12 );
	
	// get the sidebar widgets
	$the_sidebars = wp_get_sidebars_widgets();
	
	// if sidebar doesn't exist return error
	if ( !isset( $the_sidebars[$sidebar_id] ) ) {
		return __('Invalid sidebar ID', 'crum');
	}
	
	/* count number of widgets in the sidebar
	and do some simple math to calculate the columns */
	$num = count( $the_sidebars[$sidebar_id] );
	switch( $num ) {
		case 1 : $num = $columns; break;
		case 2 : $num = $columns / 2; break;
		case 3 : $num = $columns / 3; break;
		case 4 : $num = $columns / 4; break;
		case 5 : $num = $columns / 5; break;
		case 6 : $num = $columns / 6; break;
		case 7 : $num = $columns / 7; break;
		case 8 : $num = $columns / 8; break;
	}
	$num = floor( $num );
	return $num;
}