<?php
/*
* Add-on Name: Interactive Banners for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('AIO_Interactive_Banners')) 
{
	class AIO_Interactive_Banners
	{
		function __construct()
		{
			add_action('admin_init',array($this,'banner_init'));
			add_shortcode('interactive_banner',array($this,'banner_shortcode'));
		}
		function banner_init()
		{
			if(function_exists('vc_map'))
			{

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name" => __("Interactive Banner","crum"),
						"base" => "interactive_banner",
						"class" => "vc_interactive_icon",
						"icon" => "vc_icon_interactive",
						"category" => __("Presentation","crum"),
						"description" => __("Displays the banner image with Information","crum"),
						"params" => array(
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Interactive Banner Title ","crum"),
								"param_name" => "banner_title",
								"admin_label" => true,
								"value" => "",
								"group"       => $group,
								"description" => __("Give a title to this banner","crum")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Banner Title Location ","crum"),
								"param_name" => "banner_title_location",
								"value" => array(
									__("Title on Center","crum")=>'center',
									__("Title on Left","crum")=>'left',
								),
								"group"       => $group,
								"description" => __("Alignment of the title.","crum")
							),
							array(
								"type" => "textarea",
								"class" => "",
								"heading" => __("Banner Description","crum"),
								"param_name" => "banner_desc",
								"value" => "",
								"group"       => $group,
								"description" => __("Text that comes on mouse hover.","crum")
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Description color", "crum"),
								"param_name" => "description_color",
								"group"       => $group,
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Use Icon", "crum"),
								"param_name" => "icon_disp",
								"value" => array(
									"None" => "none",
									"Icon with Heading" => "with_heading",
									"Icon with Description" => "with_description",
									"Both" => "both",
								),
								"group"       => $group,
								"description" => __("Icon can be displayed with title and description.", "crum"),
							),
							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => __("Select Icon","crum"),
								"param_name" => "banner_icon",
								"admin_label" => true,
								"value" => "",
								"group"       => $group,
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=Crum_Icon_Manager' target='_blank'>add new here</a>.", "crum"),
								"dependency" => Array("element" => "icon_disp","value" => array("with_heading","with_description","both")),
							),
							array(
								"type" => "attach_image",
								"class" => "",
								"heading" => __("Banner Image","crum"),
								"param_name" => "banner_image",
								"value" => "",
								"group"       => $group,
								"description" => __("Upload the image for this banner","crum")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Apply link to:", "crum"),
								"param_name" => "link_opts",
								"value" => array(
									"No Link" => "none",
									"Complete Box" => "box",
									"Display Read More" => "more",
								),
								"group"       => $group,
								"description" => __("Select whether to use color for icon or not.", "crum"),

							),
							array(
								'type'               => 'dropdown',
								"heading"     => __( "Button color", "crum" ),
								'param_name'         => 'button_color',
								'value'              =>  array(
									'White' => 'white',
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
									'Custom' => 'custom',
								),
								"group"       => $group,
								"description" => __( "Select one of preset colors for style your button", "crum" ),
								'param_holder_class' => 'vc-colored-dropdown',
								"dependency" => Array("element" => "link_opts","value" => array("more")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Button border color", "crum"),
								"param_name" => "button_bg_color",
								"group"       => $group,
								"dependency" => Array("element" => "button_color","value" => array("custom")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Text color", "crum"),
								"param_name" => "button_text_color",
								"group"       => $group,
								"dependency" => Array("element" => "button_color","value" => array("custom")),
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Banner Link ","crum"),
								"param_name" => "banner_link",
								"value" => "",
								"group"       => $group,
								"description" => __("Add link / select existing page to link to this banner","crum"),
								"dependency" => Array("element" => "link_opts", "value" => array("box","more")),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Link Text","crum"),
								"param_name" => "banner_link_text",
								"value" => "",
								"group"       => $group,
								"description" => __("Enter text for button","crum"),
								"dependency" => Array("element" => "link_opts","value" => array("more")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Box Hover Effects","crum"),
								"param_name" => "banner_style",
								"value" => array(
									__("Appear From Bottom","crum") => "style01",
									__("Appear From Top","crum") => "style02",
									__("Appear From Left","crum") => "style03",
									__("Appear From Right","crum") => "style04",
									__("Zoom In","crum") => "style11",
									__("Zoom Out","crum") => "style12",
									__("Zoom In-Out","crum") => "style13",
									__("Jump From Left","crum") => "style21",
									__("Jump From Right","crum") => "style22",
									__("Pull From Bottom","crum") => "style31",
									__("Pull From Top","crum") => "style32",
									__("Pull From Left","crum") => "style33",
									__("Pull From Right","crum") => "style34",
								),
								"group"       => $group,
								"description" => __("Select animation effect style for this block.","crum")
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Heading Background Color","crum"),
								"param_name" => "banner_bg_color",
								"value" => "#242424",
								"group"       => $group,
								"description" => __("Select the background color for banner heading","crum")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Background Color Opacity","crum"),
								"param_name" => "banner_opacity",
								"value" => array(
									'Opaque Background'=>'opaque',
									'Solid Background'=>'solid'
								),
								"group"       => $group,
								"description" => __("Select the background opacity for content overlay","crum")
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Extra Class", "crum"),
								"param_name" => "el_class",
								"value" => "",
								"group"       => $group,
								"description" => __("Add extra class name that will be applied to the icon process, and you can use this class for your customizations.", "crum"),
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
		// Shortcode handler function for stats banner
		function banner_shortcode($atts)
		{
			wp_enqueue_style('crumVCmodules');
			$banner_title = $banner_desc = $description_color = $banner_icon = $banner_image = $banner_link = $banner_link_text = $banner_style = $banner_bg_color = $el_class = $animation = $icon_disp = '';
			$link_opts = $button_color = $button_bg_color = $button_text_color = $banner_title_location = $module_animation = $banner_height = $banner_height_val = $banner_opacity = '';
			extract(shortcode_atts( array(
				'banner_title' => '',
				'banner_desc' => '',
				'description_color' => '',
				'banner_title_location' => 'center',
				'icon_disp' => 'none',
				'banner_icon' => '',
				'banner_image' => '',
				'banner_height'=>'',
				'banner_height_val'=>'',
				'link_opts' => 'none',
				'button_color' => '',
				'button_bg_color' => '',
				'button_text_color' => '',
				'banner_link' => '',
				'banner_link_text' => '',
				'banner_style' => 'style01',
				'banner_bg_color' => '',
				'banner_opacity' => 'opaque',
				'el_class' =>'',
				'animation' => '',
				'module_animation' => '',
			),$atts));
			$output = $icon = $style = $target = '';
			//$banner_style = 'style01';
			if($animation !== 'none')
			{
				$css_trans = 'data-animation="'.$animation.'" data-animation-delay="03"';
			}
			if($banner_bg_color != '')
				$style = 'style="background:'.$banner_bg_color.';"';
			if($banner_icon !== '')
				$icon = '<i class="'.$banner_icon.'"></i>';
			$img = wp_get_attachment_image_src( $banner_image, 'large');
			$href = vc_build_link($banner_link);
			if(isset($href['target'])){
				$target = 'target="'.$href['target'].'"';
			}
			$banner_top_style='';
			if($banner_height!='' && $banner_height_val!=''){
				$banner_top_style = 'height:'.$banner_height_val.'px;';
			}

			if (isset($description_color) && !($description_color == '')){
				$description_style = 'style="color:'.$description_color.'"';
			}else{
				$description_style = '';
			}

			if(isset($button_color) && !($button_color == 'custom')){
				$button_class = $button_color;
			}else{
				$button_class = 'white';
			}

			if ($button_color == 'custom'){
				$button_text_style = 'color: '.$button_text_color.' !important;';
				$button_border_style = 'border-color: '.$button_bg_color.';';
			}else{
				$button_text_style = '';
				$button_border_style = '';
			}

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			$output .= "\n".'<div class="banner-block '.$animate.' '.$banner_height.' banner-'.$banner_style.' '.$el_class.'"  '.$css_trans.' style="'.$banner_top_style.'" '.$animation_data.'>';
			$output .= "\n\t".'<img src="'.$img[0].'" alt="'.$banner_title.'">';
			if($banner_title !== ''){
				$output .= "\n\t".'<h3 class="title-'.$banner_title_location.' bb-top-title" '.$style.'>'.$banner_title;
				if($icon_disp == "with_heading" || $icon_disp == "both")
					$output .= $icon;
				$output .= '</h3>';
			}
			$output .= "\n\t".'<div class="mask '.$banner_opacity.'-background"><div class="bb-description" '.$description_style.'>';
			if($icon_disp == "with_description" || $icon_disp == "both"){
				if($banner_icon !== ''){
					$output .= "\n\t\t".'<div class="bb-back-icon">'.$icon.'</div>';
					$output .= "\n\t\t".'<p>'.$banner_desc.'</p>';
				}
			} else {
				$output .= "\n\t\t".'<p>'.$banner_desc.'</p>';
			}
			if($link_opts == "more")
				$output .= "\n\t\t".'<a class="vc_btn vc_btn_'.$button_class.' vc_btn_outlined" href="'.$href['url'].'" '.$target.' style="'.$button_text_style.' '.$button_border_style.'">'.$banner_link_text.'</a>';

            $output .= "\n\t".'</div>';
            $output .= "\n\t".'</div>';
			$output .= "\n".'</div>';
			if($link_opts == "box"){
				$banner_with_link = '<a class="" href="'.$href['url'].'" '.$target.'>'.$output.'</a>';
				return $banner_with_link;
			} else {
				return $output;
			}
		}
	}
}
if(class_exists('AIO_Interactive_Banners'))
{
	$AIO_Interactive_Banners = new AIO_Interactive_Banners;
}
