<?php
if ( ! class_exists( 'Crum_Ultimate_Header' ) ) {
	class Crum_Ultimate_Header {
		function __construct() {
			// Add shortcode for header
			add_shortcode( 'heading', array( &$this, 'crum_shortcode_heading' ) );
			// Initialize the header component for Visual Composer
			add_action( 'admin_init', array( &$this, 'crum_heading_init' ) );
		}

		//heading
		function crum_shortcode_heading( $atts, $content = null ) {

			$text_italic = $text_bold = $text_underlined = $subtitle = $title_size =  $title_style= $text_align = $text_color = $text_color_custom = $icon_type = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $icon_link = $el_class = $icon_animation = $custom_attribs = $header_icon = $custom_color = $text_lined = '';
			$icon_img = $img_width = $module_animation = '';
			extract(
				shortcode_atts(
					array(
						"subtitle"            => '',
						"title_size"          => 'title-size-medium',
						"text_align"          => 'center',
                        "custom_color"        => '',
						"text_color"          => '',
						"text_color_custom"   => '',
						"custom_attribs"      => '',
						'module_animation'    => '',
					), $atts
				)
			);

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen ';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			$title_styles = 'title-block ';

			$title_styles .= $animate;

			$title_styles .= $title_size;
			$title_styles .= ' vc_txt_align_' . $text_align;

			$custom_attribs_array = explode(',',$custom_attribs);

				if ( in_array('undrln', $custom_attribs_array) ) {
					$text_underlined = true;
				}
                if ( in_array('line', $custom_attribs_array) ) {
                    $text_lined = true;
                }

			$title_style    .= $text_italic ? 'font-style:italic;' : '';
			$title_style    .= $text_bold ? 'font-weight: bold;' : '';

			$title_styles .= $text_lined ? ' stroke ' : '';
            $title_styles .= $text_underlined ? ' underlined ' : '';
            $title_styles .= $custom_color ? ' colored ' : '';

			$predefined_colors = array(
				'peacoc' => '#329691',
				'chino' => '#D5D0B0',
				'mulled_wine' => '#524d5b',
				'vista_blue' => '#7C9ED9',
				'sky' => '#6698FF',
				'juicy_pink' => '#F778A1',
				'sandy_brown' => '#F4A460',
			);

            if ( $custom_color == 'custom') {
                $title_style .= 'color:' . $text_color_custom . '; ';
            } elseif($custom_color == 'select') {

	            foreach ($predefined_colors as $predifined_color => $value){
		            if ($text_color == $predifined_color){
			            $text_color = $value;
		            }
	            }

	            $title_style .= 'color:' . $text_color . '; ';
            }

			$html = '<div class="' . $title_styles . '" style="' . $title_style . '" '.$animation_data.'>';


			$html .= '<div class="ovh">';
			if($content) {
				$html .= '<h2 class="title">';
				$html .= strip_tags( $content );
				$html .= '</h2>';
			}

			if ( ! ( $subtitle == '' ) ) {
				$html .= '<h4 class="subtitle">';
				$html .= $subtitle;
				$html .= '</h4>';
			}
			if ($text_underlined){
				$html .= '<div class="line"></div>';
			}

			$html .= '</div>';
			$html .= '</div>';

			return $html;
		}

		function crum_heading_init() {
			if ( function_exists( 'vc_map' ) ) {

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name"        => __( "Heading", "crum" ),
						"base"        => "heading",
						"icon"        => "icon-wpb-centered-heading",
						"category"    => __( 'Content', 'crum' ),
						"description" => __( 'Simple heading', 'crum' ),
						"params"      => array(
							array(
								"type"        => "textfield",
								"holder"      => "div",
								"heading"     => __( "Heading", "crum" ),
								"param_name"  => "content",
								"group"       => $group,
								"value"       => __( "", "crum" )
							),
							array(
								"type"        => "textarea",
								"heading"     => __( "Subtitle", "crum" ),
								"param_name"  => "subtitle",
								"admin_label" => true,
								"group"       => $group,
								"description" => __( "The subtitle text under the main title", "crum" )
							),
							array(
								"type"        => "dropdown",
								"heading"     => __( "Text Size", "crum" ),
								"param_name"  => "title_size",
								"value"       => array(
									'Medium'      => 'title-size-medium',
									'Small'      => 'title-size-small',
									'Large'       => 'title-size-large',
									'Extra Large' => 'title-size-x-large'
								),
								"default"     => 'title-size-medium',
								"group"       => $group,
								"description" => __( "Please select text size", "crum" )
							),
							array(
								"type"        => "dropdown",
								"heading"     => __( "Text Alignment", "crum" ),
								"param_name"  => "text_align",
								"value"       => array(
									'Center' => 'center',
									'Left'   => 'left',
									'Right'  => 'right',
								),
								"group"       => $group,
								"description" => __( "Please select alignment", "crum" )
							),
                            array(
                                "type"        => "dropdown",
                                "class"       => "",
                                "heading"     => __( "Change Header Color", "crum" ),
                                "param_name"  => "custom_color",
                                'value' => array(
                                    __( 'Default', 'crum' ) => '',
                                    __( 'Select color', 'crum' ) => 'select',
                                    __( 'Custom color', 'crum' ) => 'custom'
                                ),
                                "group"       => $group,
                            ),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Text Color", "crum" ),
								"param_name"  => "text_color",
								"value"       => getVcShared( 'colors' ),
								"group"       => $group,
								"description" => __( "We have given some preset colors if you are in a hurry. Otherwise, choose your own.", "crum" ),
                                "dependency" => Array("element" => "custom_color","value" => array("select"))
							),
							array(
								"type"        => "colorpicker",
								"class"       => "",
								"heading"     => __( "Text Color", "crum" ),
								"param_name"  => "text_color_custom",
								"group"       => $group,
								"description" => __( "Select text color.", "crum" ),
								"dependency"  => Array( "element" => "custom_color", "value" => array( "custom" ) ),
							),
							array(
								"type"        => "checkbox",
								"class"       => "",
								"heading"     => __( "Select custom text attributes ", "crum" ),
								"param_name"  => "custom_attribs",
								"value"       => array(
									'Underlined' => 'undrln',
                                    ' Line Decorate' => 'line',
								),
								"group"       => $group,
								"description" => __( "Select whether to animate connector or not", "crum" )
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
						)
					)
				);
			}
		}
	}

	new Crum_Ultimate_Header;
}