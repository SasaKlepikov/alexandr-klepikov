<?php
if (!class_exists('Crum_Tile_Module')){
	class Crum_Tile_Module{

		function __construct(){
			add_action('admin_init',array($this,'crum_tile_module_init'));
			add_shortcode('crum_tile_module',array($this,'crum_tile_module_form'));
		}

		function crum_tile_module_init(){

			if (function_exists('vc_map')){

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name"        => __( "Tile module", "crum" ),
						"base"        => "crum_tile_module",
						"icon"        => "",
						"category"    => __( 'Presentation', 'crum' ),
						"description" => __( 'Simple tile', 'crum' ),
						"params" => array(
							array(
								"type" => "dropdown",
								"heading" => __("Select style of block", "crum"),
								"param_name" => "tile_module_style",
								"value" => array(
									__("Big text","crum") => "text-big",
									__("Small text","crum") => "text-small",
								),
								"group"       => $group,
							),
							array(
								"type" => "dropdown",
								"heading" => __("Select alignment of text in block", "crum"),
								"param_name" => "tile_module_align",
								"value" => array(
									__("Align left","crum") => "left",
									__("Align right","crum") => "right",
									__("Align center","crum") => "center",
								),
								"group"       => $group,
							),
							array(
								"type" => "dropdown",
								"heading" => __("Select position of text in block", "crum"),
								"param_name" => "tile_module_position",
								"value" => array(
									__("Top","crum") => "top",
									__("Center","crum") => "center",
									__("Bottom","crum") => "bottom",
								),
								"group"       => $group,
							),
							array(
								"type" => "dropdown",
								"heading" => __("Show icon", "crum"),
								"param_name" => "tile_module_show_icon",
								"value" => array(
									__("Yes","crum") => "yes",
									__("No","crum") => "no",
								),
								"group"       => $group,
							),
							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => __("Select Icon ","crum"),
								"param_name" => "tile_module_icon",
								"value" => "",
								"group"       => $group,
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=Font_Icon_Manager' target='_blank'>add new here</a>.", "crum"),
								"dependency" => Array("element" => "tile_module_show_icon","value" => array("yes")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon color", "crum"),
								"param_name" => "tile_module_icon_color",
								"value" => "",
								"group"       => $group,
								"dependency" => Array("element" => "tile_module_show_icon","value" => array("yes")),
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Icon size", "crum" ),
								"param_name"  => "tile_module_icon_size",
								"group"       => $group,
								"description" => __("Size of icon","crum"),
								"dependency" => Array("element" => "tile_module_show_icon","value" => array("yes")),
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Tile text", "crum" ),
								"param_name"  => "tile_module_text",
								"group"       => $group,
								"description" => __("Text, will be displayed on your tile","crum"),
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Number on the tile", "crum" ),
								"param_name"  => "tile_module_number",
								"description" => __("Number on special tile style","crum"),
								"group"       => $group,
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Link ","crum"),
								"param_name" => "tile_module_link",
								"value" => "",
								"group"       => $group,
								"description" => __("Add a custom link or select existing page. You can remove existing link as well.","crum")
							),
							array(
								"type" => "dropdown",
								"heading" => __("Select type of background", "crum"),
								"param_name" => "tile_module_background",
								"value" => array(
									__("Color","crum") => "color",
									__("Image","crum") => "image",
								),
								"group"       => $group,
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Background color", "crum"),
								"param_name" => "tile_module_bg_color",
								"value" => "",
								"group"       => $group,
								"dependency" => Array("element" => "tile_module_background","value" => array("color")),
							),
							array(
								"type" => "attach_image",
								"class" => "",
								"heading" => __("Upload Image:", "crum"),
								"param_name" => "tile_module_bg_image",
								"value" => "",
								"group"       => $group,
								"description" => __("Upload the image.", "crum"),
								"dependency" => Array("element" => "tile_module_background","value" => array("image")),
							),
							array(
								"type" => "dropdown",
								"heading" => __("Select type block", "crum"),
								"param_name" => "tile_module_block",
								"value" => array(
									__("Rectangle","crum") => "rectangle",
									__("Square","crum") => "square",
								),
								"group"       => $group,
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Custom block height", "crum" ),
								"param_name"  => "tile_module_height",
								"group"       => $group,
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

		function crum_tile_module_form($atts, $content = null){

			$tile_module_style = $tile_module_align = $tile_module_position = $tile_module_show_icon = $tile_module_icon = $tile_module_icon_color = $tile_module_icon_size = $tile_module_text = $tile_module_number = $tile_module_link = $tile_module_background = $tile_module_bg_color = $tile_module_bg_image = $tile_module_block = $tile_module_height = $module_animation = '';

			extract(
				shortcode_atts(
					array(
						'tile_module_style' => 'text-big',
						'tile_module_align' => 'left',
						'tile_module_position' => 'top',
						'tile_module_show_icon' => 'yes',
						'tile_module_icon' => '',
						'tile_module_icon_color' =>'',
						'tile_module_icon_size' => '',
						'tile_module_text' => '',
						'tile_module_number' => '',
						'tile_module_link' => '',
						'tile_module_background' => 'color',
						'tile_module_bg_color' => '',
						'tile_module_bg_image' => '',
						'tile_module_block' => 'rectangle',
						'tile_module_height' => '',
						'module_animation' => '',
					),$atts
				)
			);

			if (isset($tile_module_align) && ($tile_module_align == 'left')){
				$text_alignment = $tile_module_align;
				$number_alignment = 'right';
			}elseif(isset($tile_module_align) && ($tile_module_align == 'right')){
				$text_alignment = $tile_module_align;
				$number_alignment = 'left';
			}else{
				$text_alignment = $number_alignment = 'center';
			}

			if (isset($tile_module_position) && ($tile_module_position == 'top')){
				$text_position = $tile_module_position;
				$number_position = $tile_module_position;
			}elseif(isset($tile_module_position) && ($tile_module_position == 'bottom')){
				$text_position = $tile_module_position;
				$number_position = $tile_module_position;
			}else{
				$text_position = $number_position = 'center';
			}

			if (isset($tile_module_icon_size) && !($tile_module_icon_size == '')){
				$module_icon_size = $tile_module_icon_size;
			}else{
				$module_icon_size = '32';
			}

			if ($tile_module_style == 'text-big'){
				$text_opening = '<div class="big tile-text '.$text_alignment.' '.$text_position.'">';
			}else{
				$text_opening = '<div class="small tile-text '.$text_alignment.' '.$text_position.'">';
			}

			if (isset($tile_module_block) && ($tile_module_block == 'rectangle')){
				if (isset($tile_module_height) && !($tile_module_height == '')){
					$height = $tile_module_height;
				}else{
					$height = 164;
				}

				$width = $height*2;

			}else{
				if (isset($tile_module_height) && !($tile_module_height == '')){
					$height = $tile_module_height;
				}else{
					$height = 164;
				}
				$width = $height;
			}

			if (isset($tile_module_icon) && !($tile_module_icon == '') &&($tile_module_show_icon == 'yes')){
				$module_icon = '<div class="icon-wrapper" style="line-height: '.$height.'px">'.do_shortcode('[just_icon icon_type="selector" icon="'.$tile_module_icon.'" img_width="48" icon_size="'.$module_icon_size.'" icon_color="'.$tile_module_icon_color.'" icon_style="circle"]').'</div>';
			}else{
				$module_icon = '';
			}

			if (isset($tile_module_link) && !($tile_module_link == '')){
				$module_link = vc_build_link($tile_module_link);
				$module_link = $module_link['url'];
			}

			if (isset($tile_module_bg_color) && !($tile_module_bg_color == '') && ($tile_module_background == 'color')){
				$background_style = 'background-color:'.$tile_module_bg_color.'';
			}elseif(isset($tile_module_bg_image) && !($tile_module_bg_image == '') && ($tile_module_background == 'image')){
				$image_ulr = crum_int_image($tile_module_bg_image, $width, $height, true);
				$background_style = 'background-image: url('.$image_ulr.')';
			}else{
				$background_style = '';
			}

			$block_style = 'style="'.$background_style.'; width:'.$width.'px; height:'.$height.'px"';

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			$html = '';

			$html .= '<div class="crum-tile-module '.$animate.'" '.$block_style.' '.$animation_data.'>';



			$html .= $module_icon;

			if ( isset($tile_module_text) && !($tile_module_text == '') ) {

				$html .= $text_opening .$tile_module_text . '</div>';

			}

			if (isset($tile_module_number) && !($tile_module_number == '' )){

				$html .= '<div class="tile-module-number '.$number_alignment.' '.$number_position.'">'.$tile_module_number.'</div>';

			}

			if ( !($module_link == '') ) {
				$html .= '<a href="' . $module_link . '">';
				$html .= '</a>';
			}
			$html .= '</div>';



			return $html;

		}

	}
}
if (class_exists('Crum_Tile_Module')){
	$Crum_Tile_Module = new Crum_Tile_Module;
}
