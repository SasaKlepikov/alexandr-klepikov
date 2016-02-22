<?php
/*
* Add-on Name: Just Icon for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('AIO_Just_Icon'))
{
	class AIO_Just_Icon
	{
		function __construct()
		{
			add_action('admin_init',array($this,'just_icon_init'));
			add_shortcode('just_icon',array($this,'just_icon_shortcode'));
		}
		function just_icon_init()
		{
			if(function_exists('vc_map'))
			{

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name" => __("Just Icon", 'crum'),
						"base" => "just_icon",
						"class" => "vc_simple_icon",
						"icon" => "vc_just_icon",
						"category" => __("Presentation","crum"),
						"description" => __("Add a simple icon and give some custom style.","crum"),
						"params" => array(
							// Play with icon selector
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon to display:", "crum"),
								"param_name" => "icon_type",
								"value" => array(
									"Font Icon Manager" => "selector",
									"Custom Image Icon" => "custom",
								),
								"group"       => $group,
								"description" => __("Use <a href='admin.php?page=Font_Icon_Manager' target='_blank'>existing font icon</a> or upload a custom image.", "crum")
							),
							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => __("Select Icon ","crum"),
								"param_name" => "icon",
								"value" => "",
								"group"       => $group,
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=Font_Icon_Manager' target='_blank'>add new here</a>.", "crum"),
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
							),
							array(
								"type" => "attach_image",
								"class" => "",
								"heading" => __("Upload Image Icon:", "crum"),
								"param_name" => "icon_img",
								"admin_label" => true,
								"value" => "",
								"group"       => $group,
								"description" => __("Upload the custom image icon.", "crum"),
								"dependency" => Array("element" => "icon_type","value" => array("custom")),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Image Width", "crum"),
								"param_name" => "img_width",
								"value" => 48,
								"min" => 16,
								"max" => 512,
								"suffix" => "px",
								"group"       => $group,
								"description" => __("Provide image width", "crum"),
								"dependency" => Array("element" => "icon_type","value" => array("custom")),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Size of Icon", "crum"),
								"param_name" => "icon_size",
								"value" => 32,
								"min" => 12,
								"max" => 72,
								"suffix" => "px",
								"group"       => $group,
								"description" => __("How big would you like it?", "crum"),
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Color", "crum"),
								"param_name" => "icon_color",
								"value" => "#333333",
								"group"       => $group,
								"description" => __("Give it a nice paint!", "crum"),
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon or Image Style", "crum"),
								"param_name" => "icon_style",
								"value" => array(
									"Simple" => "none",
									"Circle Background" => "circle",
									"Square Background" => "square",
									"Design your own" => "advanced",
								),
								"group"       => $group,
								"description" => __("We have given three quick preset if you are in a hurry. Otherwise, create your own with various options.", "crum"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Background Color", "crum"),
								"param_name" => "icon_color_bg",
								"value" => "#ffffff",
								"group"       => $group,
								"description" => __("Select background color for icon.", "crum"),
								"dependency" => Array("element" => "icon_style", "value" => array("circle","square","advanced")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon Border Style", "crum"),
								"param_name" => "icon_border_style",
								"value" => array(
									"None"=> "",
									"Solid"=> "solid",
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset" => "inset",
									"Outset" => "outset",
								),
								"group"       => $group,
								"description" => __("Select the border style for icon.","crum"),
								"dependency" => Array("element" => "icon_style", "value" => array("advanced")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Border Color", "crum"),
								"param_name" => "icon_color_border",
								"value" => "#333333",
								"group"       => $group,
								"description" => __("Select border color for icon.", "crum"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Width", "crum"),
								"param_name" => "icon_border_size",
								"value" => 1,
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								"group"       => $group,
								"description" => __("Thickness of the border.", "crum"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Radius", "crum"),
								"param_name" => "icon_border_radius",
								"value" => 500,
								"min" => 1,
								"max" => 500,
								"suffix" => "px",
								"group"       => $group,
								"description" => __("0 pixel value will create a square border. As you increase the value, the shape convert in circle slowly. (e.g 500 pixels).", "crum"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Background Size", "crum"),
								"param_name" => "icon_border_spacing",
								"value" => 50,
								"min" => 30,
								"max" => 500,
								"suffix" => "px",
								"group"       => $group,
								"description" => __("Spacing from center of the icon till the boundary of border / background", "crum"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Link ","crum"),
								"param_name" => "icon_link",
								"value" => "",
								"group"       => $group,
								"description" => __("Add a custom link or select existing page. You can remove existing link as well.","crum")
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Custom CSS Class", "crum"),
								"param_name" => "el_class",
								"value" => "",
								"group"       => $group,
								"description" => __("Ran out of options? Need more styles? Write your own CSS and mention the class name here.", "crum"),
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
					)
				);
			}
		}
		// Shortcode handler function for stats Icon
		function just_icon_shortcode($atts)
		{
			wp_enqueue_script('aio-tooltip',get_template_directory_uri() .'/library/inc/crum-vc-ultimate/assets/js/tooltip.js',array('jquery'));
			wp_enqueue_style('crumVCmodules');
			$icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $icon_link = $el_class = $icon_animation =  $tooltip_disp = $tooltip_text = $href = $module_animation = '';
			extract(shortcode_atts( array(
				'icon_type' => '',
				'icon' => '',
				'icon_img' => '',
				'img_width' => '',
				'icon_size' => '',
				'icon_color' => '',
				'icon_style' => 'none',
				'icon_color_bg' => '',
				'icon_color_border' => '',
				'icon_border_style' => '',
				'icon_border_size' => '',
				'icon_border_radius' => '',
				'icon_border_spacing' => '',
				'icon_link' => '',
				'icon_animation' => '',
				'tooltip_disp' => '',
				'tooltip_text' => '',
				'el_class'=>'',
				'module_animation' => '',
			),$atts));

			if(($icon == '' || $icon == 'none' || $icon == 'carrot-') && !$icon_img) {
				return false;
			}

			if($icon_animation !== 'none')
			{
				$css_trans = 'data-animation="'.$icon_animation.'" data-animation-delay="0"';
			}
			$output = $style = $link_sufix = $link_prefix = $target = '';
			$uniqid = uniqid();
			if($icon_link !== ''){
				$href = vc_build_link($icon_link);
				$target = (isset($href['target'])) ? "target='".$href['target']."'" : '';
				$link_prefix .= '<a href = "'.$href['url'].'" '.$target.'" title="'.$tooltip_text.'">';
				$link_sufix .= '</a>';
			} else {
				if($tooltip_disp !== ""){
					$link_prefix .= '<a href = "'.$href.'" '.$target.' title="'.$tooltip_text.'">';
					$link_sufix .= '</a>';
				}
			}

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			if($icon_type == 'custom'){
				$img = wp_get_attachment_image_src( $icon_img, 'large');
				if($icon_style == 'advanced' && $icon_border_style !== '' ){
					$style .= 'border-style:'.$icon_border_style.';';
					$style .= 'border-color:'.$icon_color_border.';';
					$style .= 'border-width:'.$icon_border_size.'px;';
					$style .= 'padding:'.$icon_border_spacing.'px;';
					$style .= 'border-radius:'.$icon_border_radius.'px;';
				}
				if(!empty($img[0])){
					$output .= "\n".$link_prefix.'<span class="'.$img[0].' aio-icon-img '.$animate.' '.$el_class.'" style="font-size:'.$img_width.'px;'.$style.'" '.$css_trans.' '.$animation_data.'>';
					$output .= "\n\t".'<img class="img-icon" src="'.$img[0].'"/>';
					$output .= "\n".'</span>'.$link_sufix;
				}
				$output = $output;
			} else {
				if($icon_color !== '')
					$style .= 'color:'.$icon_color.';';
				if($icon_style !== 'none'){
					if($icon_color_bg !== '')
						$style .= 'background:'.$icon_color_bg.';';
				}
				if($icon_style == 'advanced'){
					$style .= 'border-style:'.$icon_border_style.';';
					$style .= 'border-color:'.$icon_color_border.';';
					$style .= 'border-width:'.$icon_border_size.'px;';
					$style .= 'width:'.$icon_border_spacing.'px;';
					$style .= 'height:'.$icon_border_spacing.'px;';
					$style .= 'line-height:'.$icon_border_spacing.'px;';
					$style .= 'border-radius:'.$icon_border_radius.'px;';
				}
				if($icon_size !== '')
					$style .='font-size:'.$icon_size.'px;';
				if($icon !== ""){
					$output .= "\n".$link_prefix.'<span class="aio-icon '.$animate.' '.$icon_style.' '.$el_class.'" '.$css_trans.' style="'.$style.'" '.$animation_data.'>';
					$output .= "\n\t".'<i class="'.$icon.'"></i>';
					$output .= "\n".'</span>'.$link_sufix;
				}
				$output = $output;
			}
			if($tooltip_disp !== ""){
				$output .= '<script>
					jQuery(function () {
						jQuery(".'.$uniqid.'").bsf_tooltip("hide");
					})
				</script>';
			}
			return $output;
		}
	}
}
if(class_exists('AIO_Just_Icon'))
{
	$AIO_Just_Icon = new AIO_Just_Icon;
}