<?php
/**
 * Custom Post Types
 * Portfolio, Slider and custom taxonomies
 *
 * @package Reactor
 * @author Anthony Wilhelm (@awshout / anthonywilhelm.com)
 * @author Eddie Machado (@eddiemachado / themeble.com/bones)
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_post_type#Example
 * @license GNU General Public License v2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 */


add_action('after_setup_theme', 'reactor_register_post_types', 16); 
 
function reactor_register_post_types() { 
	$post_types = get_theme_support('reactor-post-types'); 

	if ( !is_array( $post_types[0] ) ) {
		return;
	}

	/**
	 * Register slide post type
	 * Do not use before init
	 *
	 * @see register_post_type
	 * @since 1.0.0
	 */
	if ( in_array('megamenu', $post_types[0] ) ) {
		function reactor_megamenu_register() {
				
			$labels = array( 
				'name'               => __('Mega Menu', 'crum'),
				'singular_name'      => __('Mega Menu Item', 'crum'),
				'add_new'            => __('Add New', 'crum'),
				'add_new_item'       => __('Add New Item', 'crum'),
				'edit_item'          => __('Edit Item', 'crum'),
				'new_item'           => __('New Item', 'crum'),
				'all_items'          => __('All Items', 'crum'),
				'view_item'          => __('View Item', 'crum'),
				'search_items'       => __('Search Items', 'crum'),
				'not_found'          => __('Nothing found', 'crum'),
				'not_found_in_trash' => __('Nothing found in Trash', 'crum'),
				'parent_item_colon'  => '',
				'menu_name'          => __('Mega Menu', 'crum')
			 );
			 
			$args = array( 
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'menu_icon'          => 'dashicons-list-view',
				'rewrite'	         => true,
				'capability_type'    => 'post',
				'has_archive'        => false,
				'hierarchical'       => false,
				'menu_position'      => 7,
					'rewrite'    => array(  
					'slug'       => __('megamenu', 'crum'),
					'with_front' => false,  
					'feed'       => true,  
					'pages'      => true ),
				'supports'           => array('title','editor','excerpt')
			  ); 
		 
			register_post_type('megamenu' , $args );
		}
		add_action('init', 'reactor_megamenu_register');

	}

	/**
	 * Register portfolio post type
	 * Do not use before init
	 *
	 * @see register_post_type
	 * @since 1.0.0
	 */
	if ( in_array('portfolio', $post_types[0] ) ) {
		function reactor_portfolio_register() {

			$slug = reactor_option('custom_portfolio-slug','portfolio-page');

			$labels = array(
				'name'               => __('Portfolio', 'crum'),
				'singular_name'      => __('Portfolio Post', 'crum'),
				'add_new'            => __('Add New', 'crum'),
				'add_new_item'       => __('Add New Portfolio Post', 'crum'),
				'edit_item'          => __('Edit Portfolio Post', 'crum'),
				'new_item'           => __('New Portfolio Post', 'crum'),
				'all_items'          => __('All Portfolio Posts', 'crum'),
				'view_item'          => __('View Portfolio Post', 'crum'),
				'search_items'       => __('Search Portfolio', 'crum'),
				'not_found'          => __('Nothing found', 'crum'),
				'not_found_in_trash' => __('Nothing found in Trash', 'crum'),
				'parent_item_colon'  => '',
				'menu_name'          => __('Portfolio', 'crum')
			);

			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'menu_icon'          => 'dashicons-format-gallery',
				'capability_type'    => 'post',
				'taxonomies'         => array('portfolio-category', 'portfolio-tag'),
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 8,
				'rewrite'            => array(
					'slug'       => $slug,
					'with_front' => false,
					'feed'       => true,
					'pages'      => true ),
				'supports'           => array('title','editor','thumbnail', 'excerpt', 'comments')
			);

			register_post_type('portfolio' , $args );

			// this ads your post categories to your custom post type
			// register_taxonomy_for_object_type('category', 'portfolio');

			// this ads your post tags to your custom post type
			// register_taxonomy_for_object_type('post_tag', 'portfolio');
		}
		add_action('init', 'reactor_portfolio_register');

		/**
		 * Create portfolio taxonomies
		 * Do not use before init
		 *
		 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
		 * @see register_taxonomy
		 * @since 1.0.0
		 */
		function reactor_portfolio_taxonomies() {

			$slug = reactor_option('custom_portfolio-slug','portfolio-page');

			// Add new taxonomy, make it hierarchical ( like categories )
			$labels = array(
				'name' => __('Portfolio Categories', 'crum'),
				'singular_name'     => __('Portfolio Category', 'crum'),
				'search_items'      => __('Search Portfolio Categories', 'crum'),
				'all_items'         => __('All Portfolio Categories', 'crum'),
				'parent_item'       => __('Parent Portfolio Category', 'crum'),
				'parent_item_colon' => __('Parent Portfolio Category:', 'crum'),
				'edit_item'         => __('Edit Portfolio Category', 'crum'),
				'update_item'       => __('Update Portfolio Category', 'crum'),
				'add_new_item'      => __('Add New Portfolio Category', 'crum'),
				'new_item_name'     => __('New Portfolio Category Name', 'crum'),
				'menu_name'         => __('Categories', 'crum'),
			);

			register_taxonomy('portfolio-category', array('portfolio'),
				array(
					'hierarchical'      => true,
					'labels'            => $labels,
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => $slug.'-category' ),
				));

			// Add new taxonomy, NOT hierarchical ( like tags )
			$labels = array(
				'name'                       => __('Portfolio Tags', 'crum'),
				'singular_name'              => __('Tag', 'crum'),
				'search_items'               => __('Search Portfolio Tags', 'crum'),
				'popular_items'              => __('Popular Portfolio Tags', 'crum'),
				'all_items'                  => __('All Portfolio Tags', 'crum'),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __('Edit Tag', 'crum'),
				'update_item'                => __('Update Tag', 'crum'),
				'add_new_item'               => __('Add New Tag', 'crum'),
				'new_item_name'              => __('New Tag Name', 'crum'),
				'separate_items_with_commas' => __('Separate Portfolio Tags with commas', 'crum'),
				'add_or_remove_items'        => __('Add or remove Portfolio Tags', 'crum'),
				'choose_from_most_used'      => __('Choose from the most used Portfolio Tags', 'crum'),
				'menu_name'                  => __('Tags', 'crum'),
			);

			register_taxonomy('portfolio-tag', array('portfolio'),
				array(
					'hierarchical'          => false,
					'labels'                => $labels,
					'show_ui'               => true,
					'show_admin_column'     => true,
					'update_count_callback' => '_update_post_term_count',
					'query_var'             => true,
					'rewrite'           => array( 'slug' => $slug.'-tag' ),
				));
		}
		add_action('init', 'reactor_portfolio_taxonomies', 0);
	}
}