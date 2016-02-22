<?php
/*
* Add-on Name: Info Box
* Add-on URI: https://www.brainstormforce.com
*/
if ( ! class_exists( 'AIO_Icons_Box' ) ) {
	class AIO_Icons_Box {
		function __construct() {
			// Add shortcode for icon box
			add_shortcode( 'bsf-info-box', array( &$this, 'icon_boxes' ) );
			// Initialize the icon box component for Visual Composer
			add_action( 'admin_init', array( &$this, 'icon_box_init' ) );
		}

		// Add shortcode for icon-box
		function icon_boxes( $atts, $content = null ) {
			wp_enqueue_style( 'crumVCmodules' );
			$icon_type    = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $el_class = $icon_animation = $title = $title_color = $link = $hover_effect = $pos = $read_more = '';
			$button_color = $button_bg_color = $button_text_color = $read_text = $box_border_style = $box_border_width = $box_border_color = $box_bg_color = '';
			$pos          = $css_class = $module_animation = '';
			extract( shortcode_atts( array(
				'icon_type'           => '',
				'icon'                => '',
				'icon_img'            => '',
				'img_width'           => '',
				'icon_size'           => '',
				'icon_color'          => '',
				'icon_style'          => '',
				'icon_color_bg'       => '',
				'icon_color_border'   => '',
				'icon_border_style'   => '',
				'icon_border_size'    => '',
				'icon_border_radius'  => '',
				'icon_border_spacing' => '',
				'icon_animation'      => '',
				'title'               => '',
				'title_color'         => '',
				'link'                => '',
				'hover_effect'        => 'style_1',
				'pos'                 => 'default',
				'box_border_style'    => '',
				'box_border_width'    => '',
				'box_border_color'    => '',
				'box_bg_color'        => "",
				'read_more'           => '',
				'button_color'        => '',
				'button_bg_color'     => '',
				'button_text_color'   => '',
				'read_text'           => '',
				'el_class'            => '',
				'module_animation'    => '',
			), $atts, 'bsf-info-box' ) );
			$html     = $target = $suffix = $prefix = '';
			$box_icon = do_shortcode( '[just_icon icon_type="' . $icon_type . '" icon="' . $icon . '" icon_img="' . $icon_img . '" img_width="' . $img_width . '" icon_size="' . $icon_size . '" icon_color="' . $icon_color . '" icon_style="' . $icon_style . '" icon_color_bg="' . $icon_color_bg . '" icon_color_border="' . $icon_color_border . '"  icon_border_style="' . $icon_border_style . '" icon_border_size="' . $icon_border_size . '" icon_border_radius="' . $icon_border_radius . '" icon_border_spacing="' . $icon_border_spacing . '" icon_animation="' . $icon_animation . '"]' );

			$predefined_colors = array(
				'peacoc'      => '#329691',
				'chino'       => '#D5D0B0',
				'mulled_wine' => '#524d5b',
				'vista_blue'  => '#7C9ED9',
				'sky'         => '#6698FF',
				'juicy_pink'  => '#F778A1',
				'sandy_brown' => '#F4A460',
			);

			foreach ( $predefined_colors as $predifined_color => $value ) {
				if ( $button_color == $predifined_color ) {
					$button_color = $value;
				}
			}

			if ( isset( $button_bg_color ) && ! ( $button_bg_color == '' ) ) {
				$custom_button_color = $button_bg_color;
			} else {
				$custom_button_color = '';
			}

			if ( isset( $button_text_color ) && ! ( $button_text_color == '' ) ) {
				$custom_button_text_color = $button_text_color;
			} else {
				$custom_button_text_color = '';
			}

			if ( isset( $button_color ) && ! ( $button_color == '' ) && ! ( $button_color == 'custom' ) ) {
				if ( ! ( reactor_option( 'main_site_color' ) == '' ) ) {
					$main_site_color = reactor_option( 'main_site_color' );
				} else {
					$main_site_color = '#6ABCE3';
				}
				if ( $button_color == 'main_site_color' ) {
					$button_style = 'style="background-color:' . $main_site_color . '"';
				} else {
					$button_style = 'style="background-color:' . $button_color . '"';
				}
			} else {
				if ( $button_color == 'custom' ) {
					$button_style = 'style="background-color:' . $custom_button_color . '; color:' . $custom_button_text_color . '"';
				} else {
					$button_style = '';
				}
			}

			$animate = $animation_data = '';

			if ( ! ( $module_animation == '' ) ) {
				$animate        = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "' . $module_animation . '" ';
			}

			$prefix .= '<div class="aio-icon-component ' . $animate . ' ' . $css_class . ' ' . $el_class . ' ' . $hover_effect . '" ' . $animation_data . '>';
			$suffix .= '</div> <!-- aio-icon-component -->';
			$ex_class = $ic_class = '';
			if ( $pos != '' ) {
				$ex_class .= $pos . '-icon';
				$ic_class = 'aio-icon-' . $pos;
			}
			$box_style = '';
			if ( $pos == 'square_box' ) {
				if ( $box_border_color != '' ) {
					$box_style .= "border-color:" . $box_border_color . ";";
				}
				if ( $box_border_style != '' ) {
					$box_style .= "border-style:" . $box_border_style . ";";
				}
				if ( $box_border_width != '' ) {
					$box_style .= "border-width:" . $box_border_width . "px;";
				}
				if ( $box_bg_color != '' ) {
					$box_style .= "background-color:" . $box_bg_color . ";";
				}
			}
			$html .= '<div class="aio-icon-box ' . $ex_class . '" style="' . $box_style . '">';
			if ( $icon !== 'none' ) {
				$html .= '<div class="' . $ic_class . '">' . $box_icon . '</div>';
			}
			if ( ($pos == "left") || ($pos == "right") ) {
				$html .= '<div class="aio-ibd-block">';
			}
			if ( $title !== '' ) {
				$html .= '<div class="aio-icon-header">';
				$link_prefix = $link_sufix = '';

				if(isset($title_color) && !($title_color == '')){
					$title_style = 'style="color:'.$title_color.'"';
				}else{
					$title_style = '';
				}

				if ( $link !== 'none' ) {
					if ( $read_more == 'title' ) {
						$href = vc_build_link( $link );
						if ( isset( $href['target'] ) ) {
							$target = 'target="' . $href['target'] . '"';
						}
						$link_prefix = '<a class="aio-icon-box-link" href="' . $href['url'] . '" ' . $target . '>';
						$link_sufix  = '</a>';
					}
				}
				$html .= $link_prefix . '<h3 class="aio-icon-title" '.$title_style.'>' . $title . '</h3>' . $link_sufix;
				$html .= '</div> <!-- header -->';
			}
			if ( $content !== '' ) {
				$html .= '<div class="aio-icon-description">';
				$html .= do_shortcode( $content );
				if ( $link !== 'none' ) {
					if ( $read_more == 'more' ) {
						$href = vc_build_link( $link );
						if ( isset( $href['target'] ) ) {
							$target = 'target="' . $href['target'] . '"';
						}
						$more_link = '<span style = "display:block; margin-top: 20px; clear:both;"><a class="button" ' . $button_style . ' href="' . $href['url'] . '" ' . $target . '>';
						$more_link .= $read_text;
						$more_link .= '</a></span>';
						$html .= $more_link;
					}
				}
				$html .= '</div> <!-- description -->';
			}
			if ( ($pos == "left") || ($pos == "right") ) {
				$html .= '</div> <!-- aio-ibd-block -->';
			}
			$html .= '</div> <!-- aio-icon-box -->';
			if ( $link !== 'none' ) {
				if ( $read_more == 'box' ) {
					$href = vc_build_link( $link );
					if ( isset( $href['target'] ) ) {
						$target = 'target="' . $href['target'] . '"';
					}
					$output = $prefix . '<a class="aio-icon-box-link" href="' . $href['url'] . '" ' . $target . '>' . $html . '</a>' . $suffix;
				} else {
					$output = $prefix . $html . $suffix;
				}
			} else {
				$output = $prefix . $html . $suffix;
			}

			return $output;
		}

		// Function generate param type "number"
		function number_settings_field( $settings, $value ) {
			$dependency = vc_generate_dependencies_attributes( $settings );
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$min        = isset( $settings['min'] ) ? $settings['min'] : '';
			$max        = isset( $settings['max'] ) ? $settings['max'] : '';
			$suffix     = isset( $settings['suffix'] ) ? $settings['suffix'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$output     = '<input type="number" min="' . $min . '" max="' . $max . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" style="max-width:100px; margin-right: 10px;" />' . $suffix;

			return $output;
		}

		/* Add icon box Component*/
		function icon_box_init() {
			if ( function_exists( 'vc_map' ) ) {
				$group = __( "Main Options", "crum" );

				vc_map(
					array(
						"name"                    => __( "Info Box", "crum" ),
						"base"                    => "bsf-info-box",
						"icon"                    => "vc_info_box",
						"class"                   => "info_box",
						"category"                => __( "Presentation", "crum" ),
						"description"             => "Adds icon box with custom font icon",
						"controls"                => "full",
						"show_settings_on_create" => true,
						"params"                  => array(
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Icon to display:", "crum" ),
								"param_name"  => "icon_type",
								"value"       => array(
									"Font Icon Manager" => "selector",
									"Custom Image Icon" => "custom",
								),
								"group"       => $group,
								"description" => __( "Use an existing font icon</a> or upload a custom image.", "crum" )
							),
							array(
								"type"        => "icon_manager",
								"class"       => "",
								"heading"     => __( "Select Icon ", "crum" ),
								"param_name"  => "icon",
								"value"       => "",
								"group"       => $group,
								"description" => __( "Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=Font_Icon_Manager' target='_blank'>add new here</a>.", "crum" ),
								"dependency"  => Array( "element" => "icon_type", "value" => array( "selector" ) ),
							),
							array(
								"type"        => "attach_image",
								"class"       => "",
								"heading"     => __( "Upload Image Icon:", "crum" ),
								"param_name"  => "icon_img",
								"value"       => "",
								"group"       => $group,
								"description" => __( "Upload the custom image icon.", "crum" ),
								"dependency"  => Array( "element" => "icon_type", "value" => array( "custom" ) ),
							),
							array(
								"type"        => "number",
								"class"       => "",
								"heading"     => __( "Image Width", "crum" ),
								"param_name"  => "img_width",
								"value"       => 48,
								"min"         => 16,
								"max"         => 512,
								"suffix"      => "px",
								"group"       => $group,
								"description" => __( "Provide image width", "crum" ),
								"dependency"  => Array( "element" => "icon_type", "value" => array( "custom" ) ),
							),
							array(
								"type"        => "number",
								"class"       => "",
								"heading"     => __( "Size of Icon", "crum" ),
								"param_name"  => "icon_size",
								"value"       => 32,
								"min"         => 12,
								"max"         => 72,
								"suffix"      => "px",
								"group"       => $group,
								"description" => __( "How big would you like it?", "crum" ),
								"dependency"  => Array( "element" => "icon_type", "value" => array( "selector" ) ),
							),
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Color", "crum" ),
								"param_name"  => "icon_color",
								"value"       => "#333333",
								"group"       => $group,
								"description" => __( "Give it a nice paint!", "crum" ),
								"dependency"  => Array( "element" => "icon_type", "value" => array( "selector" ) ),
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Icon Style", "crum" ),
								"param_name"  => "icon_style",
								"value"       => array(
									"Simple"            => "none",
									"Circle Background" => "circle",
									"Square Background" => "square",
									"Design your own"   => "advanced",
								),
								"group"       => $group,
								"description" => __( "We have given three quick preset if you are in a hurry. Otherwise, create your own with various options.", "crum" ),
							),
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Background Color", "crum" ),
								"param_name"  => "icon_color_bg",
								"value"       => "#ffffff",
								"group"       => $group,
								"description" => __( "Select background color for icon.", "crum" ),
								"dependency"  => Array(
									"element" => "icon_style",
									"value"   => array( "circle", "square", "advanced" )
								),
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Icon Border Style", "crum" ),
								"param_name"  => "icon_border_style",
								"value"       => array(
									"None"   => "",
									"Solid"  => "solid",
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset"  => "inset",
									"Outset" => "outset",
								),
								"group"       => $group,
								"description" => __( "Select the border style for icon.", "crum" ),
								"dependency"  => Array( "element" => "icon_style", "value" => array( "advanced" ) ),
							),
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Border Color", "crum" ),
								"param_name"  => "icon_color_border",
								"value"       => "#333333",
								"group"       => $group,
								"description" => __( "Select border color for icon.", "crum" ),
								"dependency"  => Array( "element" => "icon_border_style", "not_empty" => true ),
							),
							array(
								"type"        => "number",
								"class"       => "",
								"heading"     => __( "Border Width", "crum" ),
								"param_name"  => "icon_border_size",
								"value"       => 1,
								"min"         => 1,
								"max"         => 10,
								"suffix"      => "px",
								"group"       => $group,
								"description" => __( "Thickness of the border.", "crum" ),
								"dependency"  => Array( "element" => "icon_border_style", "not_empty" => true ),
							),
							array(
								"type"        => "number",
								"class"       => "",
								"heading"     => __( "Border Radius", "crum" ),
								"param_name"  => "icon_border_radius",
								"value"       => 500,
								"min"         => 1,
								"max"         => 500,
								"suffix"      => "px",
								"group"       => $group,
								"description" => __( "0 pixel value will create a square border. As you increase the value, the shape convert in circle slowly. (e.g 500 pixels).", "crum" ),
								"dependency"  => Array( "element" => "icon_border_style", "not_empty" => true ),
							),
							array(
								"type"        => "number",
								"class"       => "",
								"heading"     => __( "Background Size", "crum" ),
								"param_name"  => "icon_border_spacing",
								"value"       => 50,
								"min"         => 30,
								"max"         => 500,
								"suffix"      => "px",
								"group"       => $group,
								"description" => __( "Spacing from center of the icon till the boundary of border / background", "crum" ),
								"dependency"  => Array( "element" => "icon_style", "value" => array( "advanced" ) ),
							),
							// Icon Box Heading
							array(
								"type"        => "textfield",
								"class"       => "",
								"heading"     => __( "Title", "crum" ),
								"param_name"  => "title",
								"admin_label" => true,
								"value"       => "",
								"group"       => $group,
								"description" => __( "Provide the title for this icon box.", "crum" ),
							),
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Title Color", "crum" ),
								"param_name"  => "title_color",
								"value"       => "",
								"group"       => $group,
								"description" => __( "Select custom color for title if you want", "crum" )
							),
							// Add some description
							array(
								"type"        => "textarea_html",
								"class"       => "",
								"heading"     => __( "Description", "crum" ),
								"param_name"  => "content",
								"value"       => "",
								"group"       => $group,
								"description" => __( "Provide the description for this icon box.", "crum" )
							),
							// Select link option - to box or with read more text
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Apply link to:", "crum" ),
								"param_name"  => "read_more",
								"value"       => array(
									"No Link"           => "none",
									"Complete Box"      => "box",
									"Box Title"         => "title",
									"Display Read More" => "more",
								),
								"group"       => $group,
								"description" => __( "Select whether to use color for icon or not.", "crum" )
							),
							array(
								'type'               => 'dropdown',
								"heading"            => __( "Button color", "crum" ),
								'param_name'         => 'button_color',
								'value'              => array(
									'Main site color' => 'main_site_color',
									'Blue'            => 'blue', // Why __( 'Blue', 'js_composer' ) doesn't work?
									'Turquoise'       => 'turquoise',
									'Pink'            => 'pink',
									'Violet'          => 'violet',
									'Peacoc'          => 'peacoc',
									'Chino'           => 'chino',
									'Mulled Wine'     => 'mulled_wine',
									'Vista Blue'      => 'vista_blue',
									'Black'           => 'black',
									'Grey'            => 'grey',
									'Orange'          => 'orange',
									'Sky'             => 'sky',
									'Green'           => 'green',
									'Juicy pink'      => 'juicy_pink',
									'Sandy brown'     => 'sandy_brown',
									'Purple'          => 'purple',
									'White'           => 'white',
									'Custom'          => 'custom',
								),
								"group"              => $group,
								"description"        => __( "Select one of preset colors for style your button", "crum" ),
								'param_holder_class' => 'vc-colored-dropdown',
								"dependency"         => Array( "element" => "read_more", "value" => array( "more" ) ),
							),
							array(
								"type"       => "colorpicker",
								"class"      => "",
								"heading"    => __( "Background color", "crum" ),
								"param_name" => "button_bg_color",
								"group"      => $group,
								"dependency" => Array( "element" => "button_color", "value" => array( "custom" ) ),
							),
							array(
								"type"       => "colorpicker",
								"class"      => "",
								"heading"    => __( "Text color", "crum" ),
								"param_name" => "button_text_color",
								"group"      => $group,
								"dependency" => Array( "element" => "button_color", "value" => array( "custom" ) ),
							),
							// Add link to existing content or to another resource
							array(
								"type"        => "vc_link",
								"class"       => "",
								"heading"     => __( "Add Link", "crum" ),
								"param_name"  => "link",
								"value"       => "",
								"group"       => $group,
								"description" => __( "Add a custom link or select existing page. You can remove existing link as well.", "crum" ),
								"dependency"  => Array(
									"element" => "read_more",
									"value"   => array( "box", "title", "more" )
								),
							),
							// Link to traditional read more
							array(
								"type"        => "textfield",
								"class"       => "",
								"heading"     => __( "Read More Text", "crum" ),
								"param_name"  => "read_text",
								"value"       => "Read More",
								"group"       => $group,
								"description" => __( "Customize the read more text.", "crum" ),
								"dependency"  => Array( "element" => "read_more", "value" => array( "more" ) ),
							),
							// Hover Effect type
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Select Hover Effect type", "crum" ),
								"param_name"  => "hover_effect",
								"value"       => array(
									"No Effect"            => "style_1",
									"Icon Zoom"            => "style_2",
									"Icon Bounce Up"       => "style_3",
									"Main site color"      => "style_4",
									"Secondary site color" => "style_5",
								),
								"group"       => $group,
								"description" => __( "Select the type of effect you want on hover", "crum" )
							),
							// Position the icon box
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Box Style", "crum" ),
								"param_name"  => "pos",
								"value"       => array(
									"Icon at Left with heading" => "default",
									"Icon at Left"              => "left",
									"Icon at Right"             => "right",
									"Icon at Top"               => "top",
									"Boxed Style"               => "square_box",
								),
								"group"       => $group,
								"description" => __( "Select icon position. Icon box style will be changed according to the icon position.", "crum" )
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Box Border Style", "crum" ),
								"param_name"  => "box_border_style",
								"value"       => array(
									"None"   => "",
									"Solid"  => "solid",
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset"  => "inset",
									"Outset" => "outset",
								),
								"group"       => $group,
								"dependency"  => Array( "element" => "pos", "value" => array( "square_box" ) ),
								"description" => __( "Select Border Style for box border.", "crum" )
							),
							array(
								"type"        => "number",
								"class"       => "",
								"heading"     => __( "Box Border Width", "crum" ),
								"param_name"  => "box_border_width",
								"value"       => "",
								"suffix"      => "",
								"group"       => $group,
								"dependency"  => Array( "element" => "pos", "value" => array( "square_box" ) ),
								"description" => __( "Select Width for Box Border.", "crum" )
							),
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Box Border Color", "crum" ),
								"param_name"  => "box_border_color",
								"value"       => "",
								"group"       => $group,
								"dependency"  => Array( "element" => "pos", "value" => array( "square_box" ) ),
								"description" => __( "Select Border color for border box.", "crum" )
							),
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Box Background Color", "crum" ),
								"param_name"  => "box_bg_color",
								"value"       => "",
								"group"       => $group,
								"dependency"  => Array( "element" => "pos", "value" => array( "square_box" ) ),
								"description" => __( "Select Box background color.", "crum" )
							),
							// Customize everything
							array(
								"type"        => "textfield",
								"class"       => "",
								"heading"     => __( "Extra Class", "crum" ),
								"param_name"  => "el_class",
								"value"       => "",
								"group"       => $group,
								"description" => __( "Add extra class name that will be applied to the icon box, and you can use this class for your customizations.", "crum" ),
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
						) // end params array
					) // end vc_map array
				); // end vc_map
			} // end function check 'vc_map'
		}// end function icon_box_init
	}//Class end
}
if ( class_exists( 'AIO_Icons_Box' ) ) {
	$AIO_Icons_Box = new AIO_Icons_Box;
}