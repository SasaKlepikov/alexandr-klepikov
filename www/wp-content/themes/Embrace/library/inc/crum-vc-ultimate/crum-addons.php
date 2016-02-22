<?php

$vc_is_wp_version_3_6_more = version_compare( preg_replace( '/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo( 'version' ) ), '3.6' ) >= 0;

if ( function_exists('vc_remove_element') ) {
	vc_remove_element( "vc_posts_slider" );
	vc_remove_element( "vc_gmaps" );
	vc_remove_element( "vc_teaser_grid" );
	vc_remove_element( "vc_facebook" );
	vc_remove_element( "vc_tweetmeme" );
	vc_remove_element( "vc_googleplus" );
	vc_remove_element( "vc_facebook" );
	vc_remove_element( "vc_pinterest" );
	vc_remove_element( "vc_message" );
	vc_remove_element( "vc_posts_grid" );
	vc_remove_element( "vc_carousel" );
	vc_remove_element( "vc_flickr" );
	vc_remove_element( "vc_tour" );
	//vc_remove_element( "vc_separator" );
	vc_remove_element( "vc_button" );
	vc_remove_element( "vc_button2" );
	vc_remove_element( "vc_cta_button" );
	vc_remove_element( "vc_toggle" );
	vc_remove_element( "vc_images_carousel" );
	vc_remove_element( "vc_wp_archives" );
	vc_remove_element( "vc_wp_calendar" );
	vc_remove_element( "vc_wp_categories" );
	vc_remove_element( "vc_wp_custommenu" );
	vc_remove_element( "vc_wp_links" );
	vc_remove_element( "vc_wp_meta" );
	vc_remove_element( "vc_wp_pages" );
	vc_remove_element( "vc_wp_posts" );
	vc_remove_element( "vc_wp_recentcomments" );
	vc_remove_element( "vc_wp_rss" );
	vc_remove_element( "vc_wp_search" );
	vc_remove_element( "vc_wp_tagcloud" );
	vc_remove_element( "vc_wp_text" );
	vc_remove_element( "vc_pie" );
}

if ( function_exists('vc_remove_param') ) {

	//gallery
	vc_remove_param( "vc_gallery", "title" );
	vc_remove_param( "vc_gallery", "type" );

	//single image
	vc_remove_param( 'vc_single_image', 'title' );
	vc_remove_param( 'vc_single_image', 'css_animation' );

	//call to action button
	vc_remove_param( 'vc_cta_button2', 'css_animation');
	vc_remove_param( 'vc_cta_button2', 'color');
	vc_remove_param( 'vc_cta_button2', 'size');
	vc_remove_param( 'vc_cta_button2', 'position');
	vc_remove_param( 'vc_cta_button2', 'el_class');

	vc_remove_param( 'vc_progress_bar', 'el_class');

	vc_remove_param( 'vc_tabs', 'title' );
	vc_remove_param( 'vc_tabs', 'interval' );
	vc_remove_param( 'vc_accordion', 'title' );

	//row
	vc_remove_param( 'vc_row', 'video_bg' );
	vc_remove_param( 'vc_row', 'video_bg_url' );
	vc_remove_param( 'vc_row', 'video_bg_parallax' );
	vc_remove_param( 'vc_row', 'parallax' );
	vc_remove_param( 'vc_row', 'parallax_image' );
}

if ( function_exists('vc_add_param') ) {

	vc_add_param("vc_cta_button2",array(
				'type'               => 'dropdown',
				'heading'            => __( 'Color', 'js_composer' ),
				'param_name'         => 'color',
				'value'              =>  array(
					'Main site color' => 'main_site_color',
					'Blue' => 'blue', // Why __( 'Blue', 'js_composer' ) doesn't work?
					'Turquoise' => 'turquoise',
					'Pink' => 'pink',
					'Violet' => 'violet',
					'Peacoc' => 'peacoc',
					'Chino' => 'chino',
					'Mulled Wine' => 'mulled_wine',
					'Vista Blue' => 'vista_blue',
					'Black' => 'black',
					'Grey' => 'grey',
					'Orange' => 'orange',
					'Sky' => 'sky',
					'Green' => 'green',
					'Juicy pink' => 'juicy_pink',
					'Sandy brown' => 'sandy_brown',
					'Purple' => 'purple',
					'White' => 'white',
					'Custom' => 'custom',
				),
				'description'        => __( 'Button color.', 'js_composer' ),
				'param_holder_class' => 'vc-colored-dropdown'

		)
	);
	vc_add_param("vc_cta_button2",array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Background color", "crum"),
			"param_name" => "button_bg_color",
			"dependency" => Array("element" => "color","value" => array("custom")),
		)
	);
	vc_add_param("vc_cta_button2",array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Text color", "crum"),
			"param_name" => "button_text_color",
			"dependency" => Array("element" => "color","value" => array("custom")),
		)
	);
	vc_add_param("vc_cta_button2",array(
			'type' => 'dropdown',
			'heading' => __( 'Size', 'crum' ),
			'param_name' => 'size',
			'value' => getVcShared( 'sizes' ),
			'std' => 'md',
			'description' => __( 'Button size.', 'crum' )
		)
	);
	vc_add_param("vc_cta_button2",array(
			'type' => 'dropdown',
			'heading' => __( 'Button position', 'crum' ),
			'param_name' => 'position',
			'value' => array(
				__( 'Align right', 'crum' ) => 'right',
				__( 'Align left', 'crum' ) => 'left',
				__( 'Align bottom', 'crum' ) => 'bottom'
			),
			'description' => __( 'Select button alignment.', 'crum' )
		)
	);
	vc_add_param("vc_cta_button2",array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'crum' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'crum' )
		)
	);

	vc_add_param( "vc_progress_bar", array(
		"type"       => "dropdown",
		"class"      => "",
		"heading"    => "Select Line Width",
		"param_name" => "line_width",
		"value"      => array(
			"Big"    => "big",
			"Small"  => "small"
		),

	) );

	vc_add_param("vc_progress_bar",array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'crum' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'crum' )
		)
	);

	vc_add_param( "vc_row", array(
		'type' => 'colorpicker',
		'heading' => __( 'Font Color', 'js_composer' ),
		'param_name' => 'font_color',
		'description' => __( 'Select font color', 'js_composer' ),
		'edit_field_class' => 'vc_col-md-6 vc_column'

	) );

	vc_add_param( "vc_row", array(
		"type"       => "dropdown",
		"class"      => "",
		"heading"    => "Select Content Width",
		"param_name" => "full_width",
		"value"      => array(
			"Default"            => "",
			"Full Width Content" => "full_width_content"
		),

	) );


	vc_add_param(
		"vc_gallery", array(
			"type"        => "dropdown",
			"heading"     => __( "Auto rotate slides", "crum" ),
			"param_name"  => "interval",
			"value"       => array( 3, 5, 10, 15, __( "Disable", "crum" ) => 0 ),
			"description" => __( "Auto rotate slides each X seconds.", "crum" ),
			"dependency"  => Array(
				'element' => "type",
				'value'   => array( 'flexslider_fade', 'flexslider_slide', 'crum' )
			)
		)
	);
	vc_add_param(
		"vc_gallery", array(
			"type"        => "attach_images",
			"heading"     => __( "Images", "crum" ),
			"param_name"  => "images",
			"value"       => "",
			"description" => __( "Select images from media library.", "crum" )
		)
	);
	vc_add_param(
		"vc_gallery", array(
			"type"        => "textfield",
			"heading"     => __( "Image size", "crum" ),
			"param_name"  => "img_size",
			"description" => __( "Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'thumbnail' size.", "crum" )
		)
	);
	vc_add_param(
		"vc_gallery", array(
			"type"        => "dropdown",
			"heading"     => __( "On click", "crum" ),
			"param_name"  => "onclick",
			"value"       => array(
				__( "Open lightbox", "crum" )    => "link_image",
				__( "Do nothing", "crum" )       => "link_no",
				__( "Open custom link", "crum" ) => "custom_link"
			),
			"description" => __( "What to do when slide is clicked?", "crum" )
		)
	);
	vc_add_param(
		"vc_gallery", array(
			"type"        => "exploded_textarea",
			"heading"     => __( "Custom links", "crum" ),
			"param_name"  => "custom_links",
			"description" => __( 'Enter links for each slide here. Divide links with linebreaks (Enter).', 'crum' ),
			"dependency"  => Array( 'element' => "onclick", 'value' => array( 'custom_link' ) )
		)
	);
	vc_add_param(
		"vc_gallery", array(
			"type"        => "dropdown",
			"heading"     => __( "Custom link target", "crum" ),
			"param_name"  => "custom_links_target",
			"description" => __( 'Select where to open  custom links.', 'crum' ),
			"dependency"  => Array( 'element' => "onclick", 'value' => array( 'custom_link' ) ),
			'value'       => array( __( "Same window", "crum" ) => "_self", __( "New window", "crum" ) => "_blank" )
		)
	);
	vc_add_param(
		"vc_gallery", array(
			"type"        => "textfield",
			"heading"     => __( "Extra class name", "crum" ),
			"param_name"  => "el_class",
			"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "crum" )
		)
	);
	vc_add_param(
		"vc_tab", array(
			"type"        => "icon_manager",
			"class"       => "",
			"heading"     => __( "Select Icon ", "crum" ),
			"param_name"  => "icon",
			"value"       => "",
			"description" => __( "Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php' target='_blank'>add new here</a>.", "crum" ),
			"dependency"  => Array( "element" => "icon_type", "value" => array( "selector" ) ),
		)
	);
	vc_add_param(
		"vc_accordion_tab", array(
			"type"        => "icon_manager",
			"class"       => "",
			"heading"     => __( "Select Icon ", "crum" ),
			"param_name"  => "icon",
			"value"       => "",
			"description" => __( "Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php' target='_blank'>add new here</a>.", "crum" ),
			"dependency"  => Array( "element" => "icon_type", "value" => array( "selector" ) ),
		)
	);

	$animation_types = array(
		"type"        => "dropdown",
		"class"       => "",
		"heading"     => __( "Animation", "crum" ),
		"param_name"  => "module_animation",
		"value"       => array(
			__( "No Animation", "crum" )       => "",
			__( "FadeIn", "crum" )             => "transition.fadeIn",
			__( "FlipXIn", "crum" )            => "transition.flipXIn",
			__( "FlipYIn", "crum" )            => "transition.flipYIn",
			__( "FlipBounceXIn", "crum" )      => "transition.flipBounceXIn",
			__( "FlipBounceYIn", "crum" )      => "transition.flipBounceYIn",
			__( "SwoopIn", "crum" )            => "transition.swoopIn",
			__( "WhirlIn", "crum" )            => "transition.whirlIn",
			__( "ShrinkIn", "crum" )           => "transition.shrinkIn",
			__( "ExpandIn", "crum" )           => "transition.expandIn",
			__( "BounceIn", "crum" )           => "transition.bounceIn",
			__( "BounceUpIn", "crum" )         => "transition.bounceUpIn",
			__( "BounceDownIn", "crum" )       => "transition.bounceDownIn",
			__( "BounceLeftIn", "crum" )       => "transition.bounceLeftIn",
			__( "BounceRightIn", "crum" )      => "transition.bounceRightIn",
			__( "SlideUpIn", "crum" )          => "transition.slideUpIn",
			__( "SlideDownIn", "crum" )        => "transition.slideDownIn",
			__( "SlideLeftIn", "crum" )        => "transition.slideLeftIn",
			__( "SlideRightIn", "crum" )       => "transition.slideRightIn",
			__( "SlideUpBigIn", "crum" )       => "transition.slideUpBigIn",
			__( "SlideDownBigIn", "crum" )     => "transition.slideDownBigIn",
			__( "SlideLeftBigIn", "crum" )     => "transition.slideLeftBigIn",
			__( "SlideRightBigIn", "crum" )    => "transition.slideRightBigIn",
			__( "PerspectiveUpIn", "crum" )    => "transition.perspectiveUpIn",
			__( "PerspectiveDownIn", "crum" )  => "transition.perspectiveDownIn",
			__( "PerspectiveLeftIn", "crum" )  => "transition.perspectiveLeftIn",
			__( "PerspectiveRightIn", "crum" ) => "transition.perspectiveRightIn",
		),
		"description" => __( "", "crum" ),
		"group"       => "Animation Settings",
	);

	//Standard modules animations

	//Single image
	vc_add_param(
		"vc_single_image", $animation_types
	);
	//Call to acton button
	vc_add_param(
		"vc_cta_button2", $animation_types
	);
	//Gallery
	vc_add_param(
		"vc_gallery",$animation_types
	);

	//Progress bar
	vc_add_param(
		"vc_progress_bar",$animation_types
	);
	//Horizontal tabs
	vc_add_param(
		"vc_tabs",$animation_types
	);
	//Accordion
	vc_add_param(
		"vc_accordion",$animation_types
	);

}

if ( function_exists('vc_remove_param') ) {

	//Pie chart redacting


	// Sidebar
	vc_remove_param( "vc_widget_sidebar", "title" );

	// Video
	vc_remove_param( "vc_video", "title" );
}

//crumina sliders

if ( class_exists( 'Crumina_Page_Slider' ) ) {

	$args    = array(
		'post_type' => 'crumina_page_slider',
	);
	$sliders = get_posts( $args );
	$i       = 0;
	if ( count( $sliders ) > 0 ) {
		foreach ( $sliders as $single_slider ) {
			$slider_id[]   = get_post_meta( $single_slider->ID, '_cps_shortcode_id', true );
			$slider_name[] = $single_slider->post_title;
			$sliders_list  = array_combine( $slider_name, $slider_id );
			$i ++;
		}
	} else {
		$sliders_list = array( 'There is no sliders to choose from. Please add at least one' );
	}

	if ( function_exists('vc_map') ) {
		vc_map(

			array(
				"name"        => __( "Crumina slider selection", "crum" ),
				"base"        => "crumina_page_slider",
				"icon"        => "crumina-page-slider",
				"category"    => __( 'Crumina Elements', 'crum' ),
				"description" => __( 'Add Crumina sliders to any page', 'crum' ),
				"params"      => array(
					array(
						"type"        => "dropdown",
						"heading"     => __( "Select Slider", "crum" ),
						"param_name"  => "id",
						"value"       => $sliders_list,
						"description" => __( "Select Crumina slider to insert", "crum" )
					)
				)
			)
		);
	}
}

/* Tour section
---------------------------------------------------------- */
$tab_id_1 = time() . '-1-' . rand( 0, 100 );
$tab_id_2 = time() . '-2-' . rand( 0, 100 );
WPBMap::map(
	  'vc_tour', array(
			  "name"                    => __( "Vertical tabs", "crum" ),
			  "base"                    => "vc_tour",
			  "show_settings_on_create" => false,
			  "is_container"            => true,
			  "container_not_allowed"   => true,
			  "icon"                    => "icon-wpb-ui-tab-content-vertical",
			  "category"                => __( 'Content', 'crum' ),
			  "wrapper_class"           => "clearfix",
			  "description"             => __( 'Vertical tabs section', 'crum' ),
			  "params"                  => array(
				  array(
					  "type"        => "textfield",
					  "heading"     => __( "Extra class name", "crum" ),
					  "param_name"  => "el_class",
					  "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "crum" )
				  ),
				  array(
					  "type"        => 'checkbox',
					  "heading"     => __( "Vertical tabs", "crum" ),
					  "param_name"  => "vertical",
					  "description" => __( "Don't touch that parameter", "crum" ),
					  "value"       => Array( __( "Yes, please", "crum" ) => 'yes' ),
					  "std"         => 'yes'
				  ),
				  array(
					  "type"        => "dropdown",
					  "class"       => "",
					  "heading"     => __( "Animation", "crum" ),
					  "param_name"  => "module_animation",
					  "value"       => array(
						  __( "No Animation", "crum" )       => "",
						  __( "FadeIn", "crum" )             => "transition.fadeIn",
						  __( "FlipXIn", "crum" )            => "transition.flipXIn",
						  __( "FlipYIn", "crum" )            => "transition.flipYIn",
						  __( "FlipBounceXIn", "crum" )      => "transition.flipBounceXIn",
						  __( "FlipBounceYIn", "crum" )      => "transition.flipBounceYIn",
						  __( "SwoopIn", "crum" )            => "transition.swoopIn",
						  __( "WhirlIn", "crum" )            => "transition.whirlIn",
						  __( "ShrinkIn", "crum" )           => "transition.shrinkIn",
						  __( "ExpandIn", "crum" )           => "transition.expandIn",
						  __( "BounceIn", "crum" )           => "transition.bounceIn",
						  __( "BounceUpIn", "crum" )         => "transition.bounceUpIn",
						  __( "BounceDownIn", "crum" )       => "transition.bounceDownIn",
						  __( "BounceLeftIn", "crum" )       => "transition.bounceLeftIn",
						  __( "BounceRightIn", "crum" )      => "transition.bounceRightIn",
						  __( "SlideUpIn", "crum" )          => "transition.slideUpIn",
						  __( "SlideDownIn", "crum" )        => "transition.slideDownIn",
						  __( "SlideLeftIn", "crum" )        => "transition.slideLeftIn",
						  __( "SlideRightIn", "crum" )       => "transition.slideRightIn",
						  __( "SlideUpBigIn", "crum" )       => "transition.slideUpBigIn",
						  __( "SlideDownBigIn", "crum" )     => "transition.slideDownBigIn",
						  __( "SlideLeftBigIn", "crum" )     => "transition.slideLeftBigIn",
						  __( "SlideRightBigIn", "crum" )    => "transition.slideRightBigIn",
						  __( "PerspectiveUpIn", "crum" )    => "transition.perspectiveUpIn",
						  __( "PerspectiveDownIn", "crum" )  => "transition.perspectiveDownIn",
						  __( "PerspectiveLeftIn", "crum" )  => "transition.perspectiveLeftIn",
						  __( "PerspectiveRightIn", "crum" ) => "transition.perspectiveRightIn",
					  ),
					  "description" => __( "", "crum" ),
					  "group"       => "Animation Settings",
				  ),

			  ),
			  "custom_markup"           => '
  <div class="wpb_tabs_holder wpb_holder clearfix vc_container_for_children">
  <ul class="tabs_controls">
  </ul>
  %content%
  </div>'
		  ,
			  'default_content'         => '
  [vc_tab title="' . __( 'Tab 1', 'crum' ) . '" tab_id="' . $tab_id_1 . '"][/vc_tab]
  [vc_tab title="' . __( 'Tab 2', 'crum' ) . '" tab_id="' . $tab_id_2 . '"][/vc_tab]
  ',
			  "js_view"                 => ( $vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35' )
		  )

);

if ( function_exists('vc_map') ) {
	vc_map( array(
		'name'        => __( 'Button', 'js_composer' ),
		'base'        => 'vc_button2',
		'icon'        => 'icon-wpb-ui-button',
		'category'    => array(
			__( 'Content', 'js_composer' )
		),
		'description' => __( 'Eye catching button', 'js_composer' ),
		'params'      => array(
			array(
				'type'        => 'vc_link',
				'heading'     => __( 'URL (Link)', 'js_composer' ),
				'param_name'  => 'link',
				'description' => __( 'Button link.', 'js_composer' )
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Text on the button', 'js_composer' ),
				'holder'      => 'button',
				'class'       => 'wpb_button',
				'param_name'  => 'title',
				'value'       => __( 'Text on the button', 'js_composer' ),
				'description' => __( 'Text on the button.', 'js_composer' )
			),
			array(
				'type'        => 'dropdown',
				'heading'     => __( 'Style', 'js_composer' ),
				'param_name'  => 'style',
				'value'       => getVcShared( 'button styles' ),
				'description' => __( 'Button style.', 'js_composer' )
			),
			array(
				'type'               => 'dropdown',
				'heading'            => __( 'Color', 'js_composer' ),
				'param_name'         => 'color',
				'value'              =>  array(
					'Main site color' => 'main_site_color',
					'Blue' => 'blue', // Why __( 'Blue', 'js_composer' ) doesn't work?
					'Turquoise' => 'turquoise',
					'Pink' => 'pink',
					'Violet' => 'violet',
					'Peacoc' => 'peacoc',
					'Chino' => 'chino',
					'Mulled Wine' => 'mulled_wine',
					'Vista Blue' => 'vista_blue',
					'Black' => 'black',
					'Grey' => 'grey',
					'Orange' => 'orange',
					'Sky' => 'sky',
					'Green' => 'green',
					'Juicy pink' => 'juicy_pink',
					'Sandy brown' => 'sandy_brown',
					'Purple' => 'purple',
					'White' => 'white',
					'Custom' => 'custom',
				),
				'description'        => __( 'Button color.', 'js_composer' ),
				'param_holder_class' => 'vc-colored-dropdown'
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Background color", "crum"),
				"param_name" => "button_bg_color",
				"dependency" => Array("element" => "color","value" => array("custom")),
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Text color", "crum"),
				"param_name" => "button_text_color",
				"dependency" => Array("element" => "color","value" => array("custom")),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => __( 'Icon', 'crum' ),
				'param_name'  => 'icon_type',
				'value'       => array(
					__( 'No icon', 'crum' )          => '',
					__( 'Icon before text', 'crum' ) => 'icon_left',
					__( 'Icon after text', 'crum' )  => 'icon_right',
				),
				'description' => __( 'Button color.', 'js_composer' ),
			),
			array(
				"type"        => "icon_manager",
				"class"       => "",
				"heading"     => __( "Select Icon", "crum" ),
				"param_name"  => "icon",
				"value"       => "",
				"description" => __( "Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=Crum_Icon_Manager' target='_blank'>add new here</a>.", "crum" ),
				"dependency"  => Array( "element" => "icon_type", "value" => array( "icon_left", "icon_right" ) ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => __( 'Size', 'js_composer' ),
				'param_name'  => 'size',
				'value'       => getVcShared( 'sizes' ),
				'std'         => 'md',
				'description' => __( 'Button size.', 'js_composer' )
			),
			array(
				"type" => "checkbox",
				"heading" => __("rel=nofollow", "crum"),
				"param_name" => "nofollow_enable",
				"value" => array("Enable this attribute for button" => "enable"),
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Extra class name', 'js_composer' ),
				'param_name'  => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
			),
			array(
				"type"       => "dropdown",
				"class"      => "",
				"heading"    => __( "Animation", "crum" ),
				"param_name" => "module_animation",
				"value"      => array(
					__( "No Animation", "crum" )       => "",
					__( "FadeIn", "crum" )             => "transition.fadeIn",
					__( "FlipXIn", "crum" )            => "transition.flipXIn",
					__( "FlipYIn", "crum" )            => "transition.flipYIn",
					__( "FlipBounceXIn", "crum" )      => "transition.flipBounceXIn",
					__( "FlipBounceYIn", "crum" )      => "transition.flipBounceYIn",
					__( "SwoopIn", "crum" )            => "transition.swoopIn",
					__( "WhirlIn", "crum" )            => "transition.whirlIn",
					__( "ShrinkIn", "crum" )           => "transition.shrinkIn",
					__( "ExpandIn", "crum" )           => "transition.expandIn",
					__( "BounceIn", "crum" )           => "transition.bounceIn",
					__( "BounceUpIn", "crum" )         => "transition.bounceUpIn",
					__( "BounceDownIn", "crum" )       => "transition.bounceDownIn",
					__( "BounceLeftIn", "crum" )       => "transition.bounceLeftIn",
					__( "BounceRightIn", "crum" )      => "transition.bounceRightIn",
					__( "SlideUpIn", "crum" )          => "transition.slideUpIn",
					__( "SlideDownIn", "crum" )        => "transition.slideDownIn",
					__( "SlideLeftIn", "crum" )        => "transition.slideLeftIn",
					__( "SlideRightIn", "crum" )       => "transition.slideRightIn",
					__( "SlideUpBigIn", "crum" )       => "transition.slideUpBigIn",
					__( "SlideDownBigIn", "crum" )     => "transition.slideDownBigIn",
					__( "SlideLeftBigIn", "crum" )     => "transition.slideLeftBigIn",
					__( "SlideRightBigIn", "crum" )    => "transition.slideRightBigIn",
					__( "PerspectiveUpIn", "crum" )    => "transition.perspectiveUpIn",
					__( "PerspectiveDownIn", "crum" )  => "transition.perspectiveDownIn",
					__( "PerspectiveLeftIn", "crum" )  => "transition.perspectiveLeftIn",
					__( "PerspectiveRightIn", "crum" ) => "transition.perspectiveRightIn",
				),
				"description" => __( "", "crum" ),
			    "group"       => "Animation Settings",
		    ),
	    )
	) );
}
