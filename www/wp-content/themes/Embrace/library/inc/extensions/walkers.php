<?php
/**
 * Nav Walkers
 * Customize the menu output for use with Foundation
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @since 1.0.0
 * @author Ben Word (@retlehs / rootstheme.com (nav.php))
 * @link http://codex.wordpress.org/Function_Reference/Walker_Class
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * Top Bar Walker
 *
 * @since 1.0.0
 */
class Top_Bar_Walker extends Walker_Nav_Menu {
	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {



		$output .= "\n<ul class=\"sub-menu dropdown\">\n";
	}

	/**
	 * @see Walker_Nav_Menu::start_el()
	 * @since 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */

	function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$item_html = '';
		parent::start_el( $item_html, $object, $depth, $args );

		$output .= ( $depth == 0 ) ? '<li class="divider"></li>' : '';

		$classes = empty( $object->classes ) ? array() : ( array ) $object->classes;

		if ( in_array('label', $classes) ) {
			$item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '<label>$1</label>', $item_html );
		}

		if ( in_array('divider', $classes) ) {
			$item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '', $item_html );
		}

		$output .= $item_html;
	}

	/**
	 * @see Walker::display_element()
	 * @since 1.0.0
	 *
	 * @param object $element Data object
	 * @param array $children_elements List of elements to continue traversing.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of current element.
	 * @param array $args
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		$element->has_children = !empty( $children_elements[$element->ID] );
		$element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
		//$element->classes[] = ( $element->has_children ) ? 'has-dropdown' : '';

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

}

function crum_menu_fallback() {
	echo '<div class="no-menu-box">';
	// Translators 1: Link to Menus, 2: Link to Customize
	printf( __( 'Please assign a menu to the primary menu location under %1$s or %2$s the design.', 'crum' ),
		sprintf(  __( '<a href="%s">Menus</a>', 'crum' ),
			get_admin_url( get_current_blog_id(), 'nav-menus.php' )
		),
		sprintf(  __( '<a href="%s">Customize</a>', 'crum' ),
			get_admin_url( get_current_blog_id(), 'customize.php' )
		)
	);
	echo '</div>';
}

/*
* Custom Walker to remove all the wp_nav_menu junk
*/
class Crum_Clean_Walker extends Walker_Nav_Menu
{

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
    {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
	{
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $iconname = ! empty( $item->_crum_mega_menu_icon ) ? '<i class="' . $item->_crum_mega_menu_icon . '"></i>' : '';


		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$current_indicators = array('current-menu-parent', 'current_page_item', 'current_page_parent');

		$newClasses = array();

		foreach($classes as $el){
			//check if it's indicating the current page, otherwise we don't need the class
			if (in_array($el, $current_indicators)){
				array_push($newClasses, $el);
			}
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $newClasses), $item ) );

        if ( $args->has_children && ($depth = 1) ) {
            $class_names .= ' menu-item-has-children ';
        }
        if ($iconname){
            $class_names .= ' menu-has-icon ';
        }

		if($class_names!='') $class_names = ' class="'. esc_attr( $class_names ) . '"';



		$output .= $indent . '<li' . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';


		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		if ($iconname){
			$item_output .= $iconname;
		}
		$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}


class Crum_Nav_Menu_Walker extends Walker_Nav_Menu {
	private $_last_ul = '';

	function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
		$id_field = $this->db_fields['id'];

		if (is_object($args[0])) {
			$args[0]->has_children = !empty($children_elements[$element->$id_field]);

			$args[0]->is_full = ($element->_crum_mega_menu_full==1);

			$args[0]->is_megamenu = ($element->_crum_mega_menu_enabled==1);

			$args[0]->megamenu_bg = ($element->_crum_mega_menu_image);

			$args[0]->megamenu_color = ($element->_crum_mega_menu_color);

			$args[0]->megamenu_font_color = ($element->_crum_mega_menu_font_color);

			$args[0]->number_columns = ($element->_crum_mega_menu_columns);

			$args[0]->megamenu_content = ($element->_crum_mega_menu_page);

		}

		if (
			$depth==0 &&
			$element->_crum_mega_menu_enabled==1 &&
			!empty($children_elements[$element->$id_field])
		) {
			$columns = $element->_crum_mega_menu_columns;
			$cnt = count($children_elements[$element->$id_field]);

			if ($columns>1 && $cnt >1 ) {
				$delim_step = ceil($cnt/$columns);
				$children_elements[$element->$id_field][0]->is_mega_submenu = true;
				for ($i=0; $i<$cnt; $i++) {

					if ($i == ($cnt-1)  && $cnt%$delim_step!==0) {

						$children_elements[$element->$id_field][$i]->is_mega_unlast = true;
					}

					if ($i==0 || $i%$delim_step!==0) {
						continue;
					}

					$children_elements[$element->$id_field][$i]->is_mega_delim = true;
					$children_elements[$element->$id_field][$i]->is_mega_submenu = true;


				}
			}
		}


		$element->classes[] = ($element->current || $element->current_item_ancestor) ? 'active' : '';

		return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}

	function start_lvl(&$output, $depth = 0, $args = array(),$current_page = 0) {
		// depth dependent classes
		$indent = ( $depth > 0 ? str_repeat("\t", $depth) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0

		$classes = array(
			'menu-depth-' . $display_depth
		);

		if ($display_depth==1 && !$args->is_megamenu) {
			$classes[] = 'dropdown';
		} else if ($display_depth >= 2 && !$args->is_megamenu) {
			$classes[] = 'dropdown';
		}
		$color_class = '';
		$megamenu_style = 'style="';

		if (isset($args->megamenu_bg) && !($args->megamenu_bg == '')){
			$megamenu_style .= 'background-image: url('.$args->megamenu_bg.') !important; ';
            $megamenu_style .= 'background-size: contain; ';
            $megamenu_style .= 'background-repeat: no-repeat; ';
            $megamenu_style .= 'background-position: right bottom; ';
		}

		if (isset($args->megamenu_color)){
			$megamenu_style .= 'background-color:'.$args->megamenu_color.'; ';
			$color_class .= ' custom-bg-color ';
		}

		if (isset($args->megamenu_font_color) && !($args->megamenu_font_color == '')){
			$megamenu_style .= 'color:'.$args->megamenu_font_color.'; ';
			$color_class .= 'custom-font-color';
		}

		$megamenu_style .= '"';

		$prefix = '';
		if ($depth==0 && $args->is_megamenu) {

			if ( $args->is_full ) { $prefix .= '<div class="megamenu full-width '.$color_class.'" '.$megamenu_style.'>'; } else { $prefix .= '<div class="megamenu half-width '.$color_class.'" '.$megamenu_style.'>'; }

			$prefix .= '<div class="row">';

			switch ($args->number_columns) {
				case '1':
					$classes_width = 'large-12 small-12 columns';
					break;
				case '2':
					$classes_width = 'large-6  small-6 columns';
					break;
				case '3':
					$classes_width = 'large-4  small-4 columns';
					break;
				case '4':
					$classes_width = 'large-3  small-3 columns';
					break;
				default:
					$classes_width = 'large-12  small-12 columns';
					break;
			}

		}

		$class_names = implode(' ', $classes);

		$ul = '';

		if ($display_depth == 1 && $args->is_megamenu){
			$ul .= '<div class="'.$classes_width.'"><ul>';
		}else{
			// build html
			$ul .= '<ul class="' . $class_names . ' '.$color_class.'"  '.$megamenu_style.' >';
		}



		$output .= "\n" . $indent . $prefix . $ul . "\n";

		if ($display_depth==1) {
			$this->_last_ul = $ul;
		}

	}

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		// code indent
		$indent = ( $depth > 0 ? str_repeat("\t", $depth) : '' );

		if (isset($item->is_mega_delim) && $item->is_mega_delim) {
			$output .= '</ul></div>'.$this->_last_ul;
		}

		// depth dependent classes
		$depth_classes = array(
			( $depth == 0 ? 'nav-item' : 'sub-nav-item' ),
			'menu-item-depth-' . $depth,
		);
		if (isset($item->is_mega_unlast) && $item->is_mega_unlast) {
			$depth_classes[] = 'unlast';
		}

		$depth_class_names = esc_attr(implode(' ', $depth_classes));


		// build html
		if ($args->has_children) {
			$class_names = 'has-submenu';
		} else {
			$class_names = "";
		}
		if (!empty( $item->_crum_mega_menu_icon )) {
			$class_names .= " has-icon";
		}
		if (!empty( $item->description )) {
			$class_names .= " has-description";
		}


		$class_names .=  in_array('current-menu-item', $classes) ? ' active ' : '';

		if ($depth == 1 && $item->is_mega_submenu ){
			$output .= $indent . '<li class="title">';
		}else{
			$output .= $indent . '<li id="nav-menu-item-' . $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

		}

		// link attributes
		$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
		$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

		$icon = ! empty( $item->_crum_mega_menu_icon ) ? '<i class="' . $item->_crum_mega_menu_icon . '"></i>' : '';


		if ( $depth == 1 && $item->is_mega_submenu ) {
			$item_output = '<h6>' . apply_filters( 'the_title', $item->title, $item->ID ) . '</h6>';
		} else {
			$item_output = sprintf(
				'%1$s<a%2$s>',
				$args->before, $attributes
			);
			$item_output .= $icon;
			$item_output .= '<span class="name"> ' . apply_filters( 'the_title', $item->title, $item->ID ) . '</span>';
			$item_output .= '<span class="desc"> ' . apply_filters( 'the_title', $item->description, $item->ID ) . '</span>';
			$item_output .= sprintf(
				'</a>%1$s',
				$args->after
			);
		}



		if ( $item->_crum_mega_menu_page && $item->_crum_mega_menu_page != '0' ) {
			$post_id_5369 = get_post($item->_crum_mega_menu_page);
			$content = $post_id_5369->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]>', $content);
			$color_class = "";

			$megamenu_style = 'style="';

			if (isset($args->megamenu_bg) && !($args->megamenu_bg == '')){
				$megamenu_style .= 'background-image: url('.$args->megamenu_bg.') !important; ';
				$megamenu_style .= 'background-size: contain; ';
				$megamenu_style .= 'background-repeat: no-repeat; ';
				$megamenu_style .= 'background-position: right bottom; ';
			}

			if (isset($args->megamenu_color)){
				$megamenu_style .= 'background-color:'.$args->megamenu_color.' !important;';
			}

			if (isset($args->megamenu_font_color) && !($args->megamenu_font_color == '')){
				$megamenu_style .= 'color:'.$args->megamenu_font_color.' !important;';
				$color_class = 'custom-font-color';
			}

			$megamenu_style .= '"';

			if ( $args->is_full ) { $item_output .= '<div class="megamenu full-width '.$color_class.'" '.$megamenu_style.'><div class="megamenu-content">'; } else { $item_output .= '<div class="megamenu half-width '.$color_class.'" '.$megamenu_style.'><div class="megamenu-content">'; }
			$item_output .= $content;
			$item_output .= '</div></div>';
		}


		// build html
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {

		if ($depth==0 && $item->_crum_mega_menu_enabled && !($item->_crum_mega_menu_page && $item->_crum_mega_menu_page != '0')) {
			$output .= '</div>';//columns
			$output .= '</div>';//row
			$output .= '</div>';//mega-menu
		}
		$output .= "</li>\n";

	}
}
