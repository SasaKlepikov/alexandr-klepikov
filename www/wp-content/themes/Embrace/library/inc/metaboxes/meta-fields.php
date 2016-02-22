<?php
add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {
	if ( ! class_exists( 'cmb_Meta_Box' ) ) {
		require_once locate_template( '/library/inc/metaboxes/init.php' );
	}
}


add_filter('cmb_meta_boxes','crum_meta_options_bar');

function crum_meta_options_bar(array $meta_boxes){

	$prefix = 'meta_options_bar_';

	$meta_boxes[] = array(
		'id'         => $prefix . 'options',
		'title'      => __( 'Options', 'crum' ),
		'pages'      => array( 'page', 'post', 'portfolio' ),
		'context'    => 'normal',
		'show_names' => true,
		'fields'     => array(
			array(
				'name'    => __( 'Options', 'crum' ),
				'desc'    => __( 'Select, what do you want to edit', 'crum' ),
				'id'      => $prefix . 'show',
				'type'    => 'radio_inline',
				'options' => array(
					''               => __( 'Close', 'crum' ),
					'header_options' => __( 'Header options', 'crum' ),
					'stun_header_options' => __( 'Stunning header options','crum' ),
					'page_params' => __( 'Page parameters', 'crum' ),

				),
			)
		)
	);

	return $meta_boxes;

}

add_filter( 'cmb_meta_boxes', 'crum_header_meta_options' );

function crum_header_meta_options( array $meta_boxes ) {

	$prefix = 'meta_header_';

	$meta_boxes[] = array(
		'id'         => $prefix . 'custom_options',
		'title'      => __( 'Header options', 'crum' ),
		'pages'      => array( 'page', 'post', 'portfolio' ),
		'context'    => 'normal',
		'show_names' => true,
		'fields'     => array(
			array(
				'name'    => __( 'Header Style', 'crum' ),
				'desc'    => __( 'Select variant of Header styling', 'crum' ),
				'id'      => $prefix . 'style',
				'type'    => 'radio_inline',
				'options' => array(
					''               => __( 'Default', 'crum' ),
					'header-style-1' => __( 'Left align', 'crum' ),
					'header-style-2' => __( 'With banner','crum' ),
					'header-style-3' => __( 'Centered', 'crum' ),
					'header-style-4' => __( 'Semitransparent', 'crum' )
				),
			),
			array(
				'name' => __( 'Select background color', 'crum' ),
				'desc' => __( 'Pick a background color for header.', 'crum' ),
				'id'   => $prefix . 'color_bg',
				'type' => 'colorpicker',
			),
			array(
				'name' => __( 'Select background opacity', 'crum' ),
				'desc' => __( 'Please type opacity number from 1 to 100', 'crum' ),
				'id'   => $prefix . 'opacity_bg',
				'type' => 'text_small',
			),
			array(
				'name' => __( 'Font color', 'crum' ),
				'desc' => __( 'Select font color for header', 'crum' ),
				'id'   => $prefix . 'color_font',
				'type' => 'colorpicker',
			),
			array(
				'name' => __( 'Text in front of logo', 'crum' ),
				'desc' => __( 'Text that will be shown in header near logotype', 'crum' ),
				'id'   => $prefix . 'banner_code',
				'type' => 'textarea_code',
			),
		)
	);

	return $meta_boxes;
}


add_filter( 'cmb_meta_boxes', 'crum_contacts_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 *
 * @return array
 */

function crum_contacts_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_contacts_';


	$meta_boxes[] = array(
		'id'         => 'contacts-page-options',
		'title'      => __( 'Contacts page options', 'crum' ),
		'pages'      => array( 'page', ), // Post type
		'show_on'    => array( 'key' => 'page-template', 'value' => array( 'page-templates/contact.php' ) ),
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __( 'Custom form shortcode', 'crum' ),
				'id'   => '_custom_form_shortcode',
				'type' => 'text',
				'desc' => __( 'Display shortcode of contact form that made with 3-rd party plugin?', 'crum' ),
			),
			array(
				'name'    => __( 'Additional text', 'crum' ),
				'desc'    => __( 'Will be displayed on left from the contact form', 'crum' ),
				'id'      => $prefix . 'text',
				'type'    => 'wysiwyg',
				'options' => array(
					'wpautop' => true,
				),
				'std'     => '<h2><span style="color: #2AA6E3;">Contact info</span></h2><p>Address: Street 9890, New Something 1234, Country <br/>Telephone: 1234 5678 <br/>Fax: 9876 5432</p><h2><span style="color: #2AA6E3;">Support info</span></h2><p>Telephone: 1234 5678<br/>Fax: 9876 5432<br/>Email: <a href="mailto:ouremail@planetearth.com">ouremail@planetearth.com</a></p>'
			),


		),
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}


add_filter( 'cmb_meta_boxes', 'crum_portfolio_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 *
 * @return array
 */

function crum_portfolio_metaboxes( array $meta_boxes ) {


	// Start with an underscore to hide fields from custom fields list
	$prefix = '_folio_';

	$meta_boxes[] = array(
		'id'         => $prefix . '_video',
		'title'      => __( 'Portfolio Video', 'crum' ),
		'pages'      => array( 'portfolio' ), // Post type
		'context'    => 'normal',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'oEmbed',
				'desc' => __( 'Enter a Youtube, Vimeo URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'crum' ),
				'id'   => $prefix . 'embed',
				'type' => 'oembed',
			),
			array(
				'name' => __( 'Self hosted video file in mp4 format', 'crum' ),
				'desc' => '',
				'id'   => $prefix . 'self_hosted_mp4',
				'type' => 'file'
			),
			array(
				'name' => __( 'Self hosted video file in webM format', 'crum' ),
				'desc' => '',
				'id'   => $prefix . 'self_hosted_webm',
				'type' => 'file'
			)
		),
	);

	$meta_boxes[] = array(
		'id'         => $prefix . '_add_desc',
		'title'      => __( 'Project Description', 'crum' ),
		'pages'      => array( 'portfolio' ),
		'context'    => 'normal',
		'show_names' => false,
		'fields'     => array(
			array(
				'name'    => __( 'Project Description', 'crum' ),
				'desc'    => __( '', 'crum' ),
				'id'      => $prefix . 'description',
				'type'    => 'wysiwyg',
				'options' => array(
					'wpautop' => true,
				),
			)
		),
	);

	$meta_boxes[] = array(
		'id'         => $prefix . '_add_detail',
		'title'      => __( 'Project Details', 'crum' ),
		'pages'      => array( 'portfolio' ),
		'context'    => 'normal',
		'show_names' => false,
		'fields'     => array(
			array(
				'name' => __( 'The "|" character as a delimiter for the name and value. Example( Designer:|John Doe )', 'crum' ),
				'type' => 'title',
				'id'   => $prefix . 'test_title'
			),
			array(
				'id'         => $prefix . 'details_fields',
				'type'       => 'text',
				'repeatable' => true,
			),
		),
	);


	$meta_boxes[] = array(
		'id'         => 'page_custom_subtitle',
		'title'      => __( 'Page parameters', 'crum' ),
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(

			array(
				'name' => __( 'Full-width shortcode', 'crum' ),
				'desc' => __( 'Block that displayed before content and sidebars', 'crum' ),
				'id'   => '_page_top_shortcode',
				'type' => 'text'
			),
			array(
				'name'    => __( 'Select page layout', 'crum' ),
				'desc'    => __( 'You can select layout for current page', 'crum' ),
				'id'      => '_page_layout_select',
				'type'    => 'radio_inline',
				'options' => array(
					array( 'name' => 'Default', 'value' => '' ),
					array( 'name' => 'Full width', 'value' => 'full-width' ),
					array( 'name' => 'No sidebars', 'value' => '1col-fixed' ),
					array( 'name' => 'Sidebar on left', 'value' => '2c-l-fixed' ),
					array( 'name' => 'Sidebar on right', 'value' => '2c-r-fixed' ),
					array( 'name' => '2 left sidebars', 'value' => '3c-l-fixed' ),
					array( 'name' => '2 right sidebars', 'value' => '3c-r-fixed' ),
					array( 'name' => 'Sidebar on either side', 'value' => '3c-fixed' )
				),
			),
			array(
				'name'    => __( 'Boxed Body Layout', 'crum' ),
				'id'      => '_page_boxed_layout',
				'type'    => 'radio_inline',
				'options' => array(
					array( 'name' => 'Default', 'value' => 'default' ),
					array( 'name' => 'Enabled', 'value' => 'on' ),
					array( 'name' => 'Disabled', 'value' => 'off' ),
				),
			),
			array(
				'name' => __( 'Body background image', 'crum' ),
				'desc' => __('Upload your own background image or pattern.', 'crum'),
				'id'   => '_page_boxed_bg_image',
				'type' => 'file'
			),
			array(
				'name'    => __('Body background image repeat', 'crum'),
				'desc'    => __('Select type background image repeat', 'crum'),
				'id'      => '_page_boxed_bg_repeat',
				'type'    => 'radio_inline',
				'options' => array(
					array( 'name' => 'Default', 'value' => 'default' ),
					array( 'name' => 'Vertically', 'value' => 'repeat-y' ),
					array( 'name' => 'Horizontally', 'value' => 'repeat-x' ),
					array( 'name' => 'No repeat', 'value' => 'no-repeat' ),
					array( 'name' => 'Both vertically and horizontally', 'value' => 'repeat' ),
				),
			),
			array(
				'name'    => __( 'Fixed Body background image', 'crum' ),
				'id'      => '_page_boxed_bg_fixed',
				'type'    => 'radio_inline',
				'options' => array(
					array( 'name' => 'Default', 'value' => 'default' ),
					array( 'name' => 'Enabled', 'value' => 'on' ),
					array( 'name' => 'Disabled', 'value' => 'of' ),
				),
			),
			array(
				'name' =>  __('Body background color', 'crum'),
				'desc' => __('Select background color.', 'crum'),
				'id'   => '_page_boxed_bg_color',
				'type' => 'colorpicker',
			),
		)
	);

	$meta_boxes[] = array(
		'id'         => 'page_custom_stunning_header',
		'title'      => __( 'Stunning header options', 'crum' ),
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => __( 'Stunning header style', 'crum' ),
				'desc'    => __( 'Select style stunning page header', 'crum' ),
				'id'      => 'single_page_header_style',
				'type'    => 'radio_inline',
				'options' => array( ''       => 'Default',
				                    'left'   => 'Left Aligned',
				                    'right'  => 'Right Aligned',
				                    'center' => 'Centered',
				                    'both'   => 'Separate'
				),

			),
			array(
				'name'    => __( 'Page Header Height', 'crum' ),
				'desc'    => __( 'Don\'t include "px" in the string. e.g. 350 This only applies when you are using an image.', 'crum' ),
				'id'      => 'single_page_header_height',
				'type'    => 'text',
				'default' => '',
			),
			array(
				'name' => __( 'Page Header Image', 'crum' ),
				'desc' => __( 'We recommend image  between 1600px - 2000px wide and have a minimum height of 475px for best results', 'crum' ),
				'id'   => 'single_page_header_bg',
				'type' => 'file'
			),
			array(
				'name' => __( 'Select background color', 'crum' ),
				'desc' => __( 'Pick a background color for the stunning header panel.', 'crum' ),
				'id'   => 'single_page_color_bg',
				'type' => 'colorpicker',
			),
			array(
				'name' => __( 'Font color', 'crum' ),
				'desc' => __( 'Select font color for stunning header', 'crum' ),
				'id'   => 'single_page_color_font',
				'type' => 'colorpicker',
			),
		)
	);

	$meta_boxes[] = array(
		'id'         => 'blog_params',
		'title'      => __( 'Select Blog parameters', 'crum' ),
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'default',
		'show_on'    => array( 'key' => 'page-template', 'value' => array( 'page-templates/news-page.php' ) ),
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __('Select blog style','crum'),
				'desc' => __('Select style of blog posts display', 'crum'),
				'id' => 'blog_post_style',
				'type' => 'radio_inline',
				'options' => array(
					array( 'name' => __( 'Default', 'crum' ), 'value' => 'default', ),
					array( 'name' => __( 'Left aligned image', 'crum' ), 'value' => 'blog_left_aligned', ),
					array( 'name' => __( 'Right aligned image', 'crum' ), 'value' => 'blog_right_aligned', ),
				),
			),
			array(
				'name'    => __( 'Select News Columns', 'crum' ),
				'desc'    => __( 'You can select columns for blog page', 'crum' ),
				'id'      => 'newspage_post_columns',
				'type'    => 'radio_inline',
				'options' => array(
					array( 'name' => '1 Column', 'value' => '1', ),
					array( 'name' => '2 Columns', 'value' => '2', ),
					array( 'name' => '3 Columns', 'value' => '3', ),
				),
			),
			array(
				'name'    => 'Post thumbnail width (in px)',
				'crum',
				'desc'    => __( 'Don\'t include "px" in the string. e.g. 350', 'crum' ),
				'default' => '',
				'id'      => '_cr_post_thumb_width',
				'type'    => 'text_small'
			),
			array(
				'name'    => 'Post  thumbnail height (in px)',
				'crum',
				'desc'    => __( 'Don\'t include "px" in the string. e.g. 350', 'crum' ),
				'default' => '',
				'id'      => '_cr_post_thumb_height',
				'type'    => 'text_small'
			),
			array(
				'name' => __( 'Number of items', 'crum' ),
				'desc' => __( 'Number of items that will be show on page', 'crum' ),
				'id'   => 'blog_number_to_display',
				'type' => 'text'
			),
			array(
				'name'    => __( 'Pagination type', 'crum' ),
				'desc'    => __( 'You can select layout for current page', 'crum' ),
				'id'      => 'blog_pagination_type',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __( 'Default', 'crum' ), 'value' => 'default', ),
					array( 'name' => __( 'Prev / Next', 'crum' ), 'value' => 'prev_next', ),
					array( 'name' => __( 'Page Numbers', 'crum' ), 'value' => 'numbered', ),
					array( 'name' => __( 'Ajax loading button', 'crum' ), 'value' => 'load-more', ),
				),
			),
			array(
				'name'     => __( 'Blog Category', 'crum' ),
				'desc'     => __( 'Select blog category', 'crum' ),
				'id'       => 'blog_category',
				'taxonomy' => 'category',
				'type'     => 'taxonomy_multicheck',
			),
		),
	);

	$meta_boxes[] = array(
		'id'         => 'folio_params',
		'title'      => __( 'Select Portfolio parameters', 'crum' ),
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'default',
		'show_on'    => array( 'key' => 'page-template', 'value' => array( 'page-templates/portfolio.php' ) ),
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => __( 'Portfolio select template', 'crum' ),
				'desc'    => __( '', 'crum' ),
				'id'      => 'single_folio_template',
				'type'    => 'radio_inline',
				'options' => array(
					'default'     => __( "Default", "crum" ),
					'list'        => __( 'List style', 'crum' ),
					'grid'        => __( 'Grid + Sorting', 'crum' ),
					'grid-inline' => __( 'Grid + Inline box', 'crum' ),

				),
			),
			array(
				'name'    => __( 'Select style', 'crum' ),
				'desc'    => __( 'You can select layout for current page', 'crum' ),
				'id'      => 'single_folio_list_style',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __( 'Default', 'crum' ), 'value' => 'default', ),
					array( 'name' => __( 'Left Thumbnail', 'crum' ), 'value' => 'left', ),
					array( 'name' => __( 'Right Thumbnail', 'crum' ), 'value' => 'right', ),
					array( 'name' => __( 'Alternately align', 'crum' ), 'value' => 'both', ),
				),
			),
			array(
				'name'    => __( 'Post Columns', 'crum' ),
				'desc'    => __( 'Number of porfolio posts columns', 'crum' ),
				'id'      => 'single_folio_grid_columns',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __( 'Default', 'crum' ), 'value' => 'default', ),
					array( 'name' => __( 'Two columns', 'crum' ), 'value' => '2', ),
					array( 'name' => __( 'Three columns', 'crum' ), 'value' => '3', ),
					array( 'name' => __( 'Four columns', 'crum' ), 'value' => '4', ),
					array( 'name' => __( 'Five columns', 'crum' ), 'value' => '5', ),
					array( 'name' => __( 'Six columns', 'crum' ), 'value' => '6', ),
				),
			),
			array(
				'name' => __( 'Item spacing', 'crum' ),
				'desc' => __( 'Display space gap between grid items', 'crum' ),
				'id'   => 'single_folio_space_gap',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __( 'Default', 'crum' ), 'value' => 'default', ),
					array( 'name' => __( 'Enable spacing', 'crum' ), 'value' => 'show', ),
					array( 'name' => __( 'Disable spacing', 'crum' ), 'value' => 'not_show', ),
				),
			),
			array(
				'name' => __( 'Panel for items sorting', 'crum' ),
				'desc' => __( 'Display panel for portfolio isotope items sorting by category', 'crum' ),
				'id'   => 'single_folio_sorting_panel',
				'type' => 'checkbox'
			),
			array(
				'name' => __( 'Title / description under item', 'crum' ),
				'id'   => 'single_folio_item_description',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __( 'Default', 'crum' ), 'value' => 'default', ),
					array( 'name' => __( 'Show title', 'crum' ), 'value' => 'show', ),
					array( 'name' => __( 'Do not show title', 'crum' ), 'value' => 'not_show', ),
				),
			),
			array(
				'name' => __( 'Show "Read more" button', 'crum' ),
				'id'   => 'single_folio_read_more',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __( 'Default', 'crum' ), 'value' => 'default', ),
					array( 'name' => __( 'Show button', 'crum' ), 'value' => 'show', ),
					array( 'name' => __( 'Do not show button', 'crum' ), 'value' => 'not_show', ),
				),
			),
			array(
				'name' => __( 'Number of items', 'crum' ),
				'desc' => __( 'Number of items that will be show on page', 'crum' ),
				'id'   => 'portfolio_number_to_display',
				'type' => 'text'
			),
			array(
				'name'    => __( 'Pagination type', 'crum' ),
				'desc'    => __( 'You can select layout for current page', 'crum' ),
				'id'      => 'folio_pagination_type',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __( 'Default', 'crum' ), 'value' => 'default', ),
					array( 'name' => __( 'Prev / Next', 'crum' ), 'value' => 'prev_next', ),
					array( 'name' => __( 'Page Numbers', 'crum' ), 'value' => 'numbered', ),
					array( 'name' => __( 'Ajax loading button', 'crum' ), 'value' => 'load-more', ),
				),
			),
			array(
				'name'     => __( 'Limit to Category', 'crum' ),
				'desc'     => __( 'Select portfolio items category', 'crum' ),
				'id'       => $prefix . 'category',
				'type'     => 'taxonomy_multicheck',
				'taxonomy' => 'portfolio-category'
			),
		),
	);

	return $meta_boxes;
}

add_filter( 'cmb_meta_boxes', 'crum_post_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 *
 * @return array
 */


function crum_post_metaboxes( array $meta_boxes ) {
	$prefix = 'single_post_';

	$meta_boxes[] = array(
		'id'         => 'stun-head-options',
		'title'      => __( 'Stunning header options', 'crum' ),
		'pages'      => array( 'post', ), // Post type
		'context'    => 'normal',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __( 'Page Header Image', 'crum' ),
				'desc' => __( 'Background image for stunning header', 'crum' ),
				'id'   => $prefix . 'header_bg',
				'type' => 'file'
			),
			array(
				'name' => __( 'Select background color', 'crum' ),
				'desc' => __( 'Pick a background color for the stunning header panel.', 'crum' ),
				'id'   => $prefix . 'color_bg',
				'type' => 'colorpicker',
			),
			array(
				'name' => __( 'Font color', 'crum' ),
				'desc' => __( 'Select font color for stunning header', 'crum' ),
				'id'   => $prefix . 'color_font',
				'type' => 'colorpicker',
			),
			array(
				'name'    => __( 'Page Header Height', 'crum' ),
				'desc'    => __( 'Don\'t include "px" in the string. e.g. 350 This only applies when you are using an image.', 'crum' ),
				'id'      => $prefix . 'header_height',
				'type'    => 'text'
			),
			array(
				'name'    => __( 'Stunning header style', 'crum' ),
				'desc'    => __( 'Select style stunning page header', 'crum' ),
				'id'      => $prefix . 'header_style',
				'type'    => 'radio_inline',
				'options' => array( ''       => 'Default',
				                    'left'   => 'Left Aligned',
				                    'right'  => 'Right Aligned',
				                    'center' => 'Centered',
				                    'both'   => 'Separate'
				),
			),

		),
	);


	return $meta_boxes;
}


/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 *
 * @return array
 */

add_filter( 'cmb_meta_boxes', 'crum_countdown_metaboxes' );

function crum_countdown_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_soon_';


	$meta_boxes[] = array(
		'id'         => $prefix . 'options',
		'title'      => __( 'Coming soon page options', 'crum' ),
		'pages'      => array( 'page' ), // Post type
		'priority'   => 'default',
		'show_on'    => array( 'key' => 'page-template', 'value' => array( 'page-templates/coming-soon.php' ) ),
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'  => __( 'Logotype image', 'crum' ),
				'id'    => $prefix . 'logo',
				'type'  => 'file',
				'allow' => array( 'url', 'attachment' )
			),
			array(
				'name' => __( 'Site name / tagline', 'crum' ),
				'id'   => $prefix . 'tagline',
				'type' => 'text'
			),
			array(
				'name' => __( 'Countdown Date', 'crum' ),
				'desc' => __( 'Click on field to select date', 'crum' ),
				'id'   => $prefix . 'date',
				'type' => 'text_date',
			),
			array(
				'name' => __( 'Send email to address', 'crum' ),
				'desc' => __( 'Email address for contact form', 'crum' ),
				'id'   => $prefix . 'mail',
				'type' => 'text_email'
			),
			array(
				'name'  => __( 'Background image', 'crum' ),
				'id'    => $prefix . 'background',
				'type'  => 'file',
				'allow' => array( 'url', 'attachment' )
			),

		),
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function cr_portfolio_add_custom_box( $slug ) {
	$slug    = 'portfolio';
	$screens = array( $slug );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'crumina_portfolio_gallery',
			__( 'Images gallery', 'crum' ),
			'cr_portfolio_inner_custom_box',
			$screen,
			'side',
			'high'
		);
	}
}

add_action( 'add_meta_boxes', 'cr_portfolio_add_custom_box' );


/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function cr_portfolio_inner_custom_box( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'cr_portfolio_inner_custom_box', 'cr_portfolio_inner_custom_box_nonce' );
	?>

	<div id="my_product_images_container">
		<ul class="my_product_images">
			<?php
			if ( metadata_exists( 'post', $post->ID, '_my_product_image_gallery' ) ) {
				$my_product_image_gallery = get_post_meta( $post->ID, '_my_product_image_gallery', true );
			} else {
				// Backwards compat
				$attachment_ids           = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids' );
				$attachment_ids           = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
				$my_product_image_gallery = implode( ',', $attachment_ids );
			}

			$attachments = array_filter( explode( ',', $my_product_image_gallery ) );

			if ( $attachments ) {
				foreach ( $attachments as $attachment_id ) {
					echo '<li class="image" data-attachment_id="' . $attachment_id . '">
								' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
								<ul class="actions">
									<li><a href="#" class="delete tips" data-tip="' . __( 'Delete image', 'crum' ) . '">' . __( 'Delete', 'crum' ) . '</a></li>
								</ul>
							</li>';
				}
			}
			?>
		</ul>

		<input type="hidden" id="my_product_image_gallery" name="my_product_image_gallery" value="<?php echo esc_attr( $my_product_image_gallery ); ?>" />

	</div>
	<p class="add_my_product_images hide-if-no-js">
		<a class="button" href="#"><?php _e( 'Add gallery images', 'crum' ); ?></a>
	</p>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {

			// Uploading files
			var my_product_gallery_frame;
			var $image_gallery_ids = $('#my_product_image_gallery');
			var $my_product_images = $('#my_product_images_container ul.my_product_images');

			jQuery('.add_my_product_images').on('click', 'a', function (event) {

				var $el = $(this);
				var attachment_ids = $image_gallery_ids.val();

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if (my_product_gallery_frame) {
					my_product_gallery_frame.open();
					return;
				}

				// Create the media frame.
				my_product_gallery_frame = wp.media.frames.downloadable_file = wp.media({
					// Set the title of the modal.
					title   : '<?php _e( 'Add Images to Product Gallery', 'crum' ); ?>',
					button  : {
						text: '<?php _e( 'Add to gallery', 'crum' ); ?>'
					},
					multiple: true
				});

				// When an image is selected, run a callback.
				my_product_gallery_frame.on('select', function () {

					var selection = my_product_gallery_frame.state().get('selection');

					selection.map(function (attachment) {

						attachment = attachment.toJSON();

						if (attachment.id) {
							attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

							$my_product_images.append('\
									<li class="image" data-attachment_id="' + attachment.id + '">\
										<img src="' + attachment.url + '" />\
										<ul class="actions">\
											<li><a href="#" class="delete" title="<?php _e( 'Delete image', 'crum' ); ?>"><?php _e( 'Delete', 'crum' ); ?></a></li>\
										</ul>\
									</li>');
						}

					});

					$image_gallery_ids.val(attachment_ids);
				});

				// Finally, open the modal.
				my_product_gallery_frame.open();
			});

			// Image ordering
			$my_product_images.sortable({
				items               : 'li.image',
				cursor              : 'move',
				scrollSensitivity   : 40,
				forcePlaceholderSize: true,
				forceHelperSize     : false,
				helper              : 'clone',
				opacity             : 0.65,
				placeholder         : 'wc-metabox-sortable-placeholder',
				start               : function (event, ui) {
					ui.item.css('background-color', '#f6f6f6');
				},
				stop                : function (event, ui) {
					ui.item.removeAttr('style');
				},
				update              : function (event, ui) {
					var attachment_ids = '';

					$('#my_product_images_container ul li.image').css('cursor', 'default').each(function () {
						var attachment_id = jQuery(this).attr('data-attachment_id');
						attachment_ids = attachment_ids + attachment_id + ',';
					});

					$image_gallery_ids.val(attachment_ids);
				}
			});

			// Remove images
			$('#my_product_images_container').on('click', 'a.delete', function () {

				$(this).closest('li.image').remove();

				var attachment_ids = '';

				$('#my_product_images_container ul li.image').css('cursor', 'default').each(function () {
					var attachment_id = jQuery(this).attr('data-attachment_id');
					attachment_ids = attachment_ids + attachment_id + ',';
				});

				$image_gallery_ids.val(attachment_ids);

				return false;
			});

		});
	</script>


<?php

}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function cr_portfolio_save_postdata( $post_id ) {

	/*
	 * We need to verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['cr_portfolio_inner_custom_box_nonce'] ) ) {
		return $post_id;
	}

	$nonce = $_POST['cr_portfolio_inner_custom_box_nonce'];

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'cr_portfolio_inner_custom_box' ) ) {
		return $post_id;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// Check the user's permissions.
	if ( 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
	}

	/* OK, its safe for us to save the data now. */

	// Sanitize user input.
	$mydata = $_POST['my_product_image_gallery'];

	// Update the meta field in the database.
	update_post_meta( $post_id, '_my_product_image_gallery', $mydata );
}

add_action( 'save_post', 'cr_portfolio_save_postdata' );
