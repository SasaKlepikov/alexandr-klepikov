<?php
/*
* Add-on Name: Flip Box for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('AIO_Flip_Box'))
{
	class AIO_Flip_Box
	{
		function __construct()
		{
			add_action('admin_init',array($this,'block_init'));
			add_shortcode('icon_counter',array($this,'block_shortcode'));
		}
		function block_init()
		{
			if(function_exists('vc_map'))
			{

				$group = __("Main Options", "crum");

				vc_map (
					array(
						"name" => __("Flip Box", 'crum'),
						"base" => "icon_counter",
						"class" => "vc_flip_box",
						"icon" => "vc_icon_block",
						"category" => __("Presentation","crum"),
						"description" => __("Icon, some info &amp; CTA. Flips on hover.","crum"),
						"params" => array(
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
								"description" => __("Use an existing font icon</a> or upload a custom image.", "crum")
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
								"heading" => __("Icon Style", "crum"),
								"param_name" => "icon_style",
								"value" => array(
									"Simple" => "none",
									"Circle Background" => "circle",
									"Square Background" => "square",
									"Design your own" => "advanced",
								),
								"group"       => $group,
								"description" => __("We have given three quick preset if you are in a hurry. Otherwise, create your own with various options.", "crum"),
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
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
									"None" => "",
									"Solid" => "solid",
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
								"dependency" => Array("element" => "icon_style", "value" => array("advanced")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Flip Box Style", "crum"),
								"param_name" => "flip_box_style",
								"value" => array(
									"Simple" => "simple",
									"Advanced" => "advanced",
								),
								"group"       => $group,
								"description" => __("Select the border style for icon.","crum"),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Size of Box Border", "crum"),
								"param_name" => "border_size",
								"value" => 2,
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								"group"       => $group,
								"description" => __("Enter value in pixels.", "crum"),
								"dependency" => Array("element" => "flip_box_style", "value" => array("simple")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Border Color", "crum"),
								"param_name" => "border_color",
								"value" => "#A4A4A4",
								"group"       => $group,
								"description" => __("Select the color for border on front.", "crum"),
								"dependency" => Array("element" => "flip_box_style", "value" => array("simple")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Box Border Style", "crum"),
								"param_name" => "box_border_style",
								"value" => array(
									"None"=> "none",
									"Solid"=> "solid",
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset" => "inset",
									"Outset" => "outset",
								),
								"group"       => $group,
								"description" => __("Select the border style for box.","crum"),
								"dependency" => Array("element" => "flip_box_style", "value" => array("advanced")),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Size of Box Border", "crum"),
								"param_name" => "box_border_size",
								"value" => 2,
								"min" => 1,
								"max" => 10,
								"suffix" => "px",
								"group"       => $group,
								"description" => __("Enter value in pixels.", "crum"),
								"dependency" => Array("element" => "box_border_style", "value" => array("solid","dashed","dotted","double","inset","outset")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Front Side Border Color", "crum"),
								"param_name" => "box_border_color",
								"value" => "#A4A4A4",
								"group"       => $group,
								"description" => __("Select the color for border on front.", "crum"),
								"dependency" => Array("element" => "box_border_style", "value" => array("solid","dashed","dotted","double","inset","outset")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Back Side Border Color", "crum"),
								"param_name" => "box_border_color_back",
								"value" => "#A4A4A4",
								"group"       => $group,
								"description" => __("Select the color for border on back.", "crum"),
								"dependency" => Array("element" => "box_border_style", "value" => array("solid","dashed","dotted","double","inset","outset")),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Title on Front","crum"),
								"param_name" => "block_title_front",
								"admin_label" => true,
								"value" => "",
								"group"       => $group,
								"description" => __("Perhaps, this is the most highlighted text.","crum")
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Description on Front ","crum"),
								"param_name" => "block_desc_front",
								"value" => "",
								"group"       => $group,
								"description" => __("Keep it short and simple!","crum")
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Text Color", "crum"),
								"param_name" => "text_color",
								"value" => "#333333",
								"group"       => $group,
								"description" => __("Color of title & description text.", "crum"),
								"dependency" => Array("element" => "flip_box_style", "value" => array("simple")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Background Color", "crum"),
								"param_name" => "bg_color",
								"value" => "#efefef",
								"group"       => $group,
								"description" => __("Light colors look better for background.", "crum"),
								"dependency" => Array("element" => "flip_box_style", "value" => array("simple")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Front Side Text Color", "crum"),
								"param_name" => "block_text_color",
								"value" => "#333333",
								"group"       => $group,
								"description" => __("Color of front side title & description text.", "crum"),
								"dependency" => Array("element" => "flip_box_style", "value" => array("advanced")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Front Side Background Color", "crum"),
								"param_name" => "block_front_color",
								"value" => "#efefef",
								"group"       => $group,
								"description" => __("Light colors look better on front.", "crum"),
								"dependency" => Array("element" => "flip_box_style", "value" => array("advanced")),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Title on Back ","crum"),
								"param_name" => "block_title_back",
								"admin_label" => true,
								"value" => "",
								"group"       => $group,
								"description" => __("Some nice heading for the back side of the flip.","crum")
							),
							array(
								"type" => "textarea",
								"class" => "",
								"heading" => __("Description on Back","crum"),
								"param_name" => "block_desc_back",
								"value" => "",
								"group"       => $group,
								"description" => __("Text here will be followed by a button. So make it catchy!","crum")
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Back Side Text Color", "crum"),
								"param_name" => "block_back_text_color",
								"value" => "#333333",
								"group"       => $group,
								"description" => __("Color of back side title & description text.", "crum"),
								"dependency" => Array("element" => "flip_box_style", "value" => array("advanced")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Back Side Background Color", "crum"),
								"param_name" => "block_back_color",
								"value" => "#efefef",
								"group"       => $group,
								"description" => __("Select the background color for back .", "crum"),
								"dependency" => Array("element" => "flip_box_style", "value" => array("advanced")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Link","crum"),
								"param_name" => "custom_link",
								"value" => array(
									"No Link" => "",
									"Add custom link with button" => "1",
								),
								"group"       => $group,
								"description" => __("You can add / remove custom link","crum")
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Link ","crum"),
								"param_name" => "button_link",
								"value" => "",
								"group"       => $group,
								"description" => __("You can link or remove the existing link on the button from here.","crum"),
								"dependency" => Array("element" => "custom_link", "not_empty" => true, "value" => array("1")),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Button Text","crum"),
								"param_name" => "button_text",
								"value" => "",
								"group"       => $group,
								"description" => __("The \"call to action\" text","crum"),
								"dependency" => Array("element" => "custom_link", "not_empty" => true, "value" => array("1")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Button background color", "crum"),
								"param_name" => "button_bg",
								"value" => "#333333",
								"group"       => $group,
								"description" => __("Color of the button. Make sure it'll match with Back Side Box Color.", "crum"),
								"dependency" => Array("element" => "custom_link", "not_empty" => true, "value" => array("1")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Button Text Color", "crum"),
								"param_name" => "button_txt",
								"value" => "#FFFFFF",
								"group"       => $group,
								"description" => __("Select the color for button text.", "crum"),
								"dependency" => Array("element" => "custom_link", "not_empty" => true, "value" => array("1")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Flip Type ","crum"),
								"param_name" => "flip_type",
								"value" => array(
									"Flip Horizontally From Left" => "horizontal_flip_left",
									"Flip Horizontally From Right" => "horizontal_flip_right",
									"Flip Vertically From Top" => "vertical_flip_top",
									"Flip Vertically From Bottom" => "vertical_flip_bottom",
									"Flip From Left" => "flip_left",
									"Flip From Right" => "flip_right",
									"Flip From Top" => "flip_top",
									"Flip From Bottom" => "flip_bottom",
									"Vertical Door Flip" => "vertical_door_flip",
									"Reverse Vertical Door Flip" => "reverse_vertical_door_flip",
									"Horizontal Door Flip" => "horizontal_door_flip",
									"Reverse Horizontal Door Flip" => "reverse_horizontal_door_flip",
								),
								"group"       => $group,
								"description" => __("Select Flip type for this flip box.","crum")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Set Box Height","crum"),
								"param_name" => "height_type",
								"value" => array(
									"Display full the content and adjust height of the box accordingly"=>"ifb-jq-height",
									"Hide extra content that doesn't fit in height of the box" => "ifb-auto-height",
									"Give a custom height of your choice to the box" => "ifb-custom-height",
								),
								"group"       => $group,
								"description" => __("Select height option for this box.","crum")
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Box Height", "crum"),
								"param_name" => "box_height",
								"value" => 300,
								"min" => 200,
								"max" => 1200,
								"suffix" => "px",
								"description" => __("Provide box height", "crum"),
								"group"       => $group,
								"dependency" => Array("element" => "height_type","value" => array("ifb-custom-height")),
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
		// Shortcode handler function for  icon block
		function block_shortcode($atts)
		{
			wp_enqueue_style('aio-flip-style',get_template_directory_uri() .'/library/inc/crum-vc-ultimate/assets/css/flip-box.css');
			$icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $icon_link = $el_class = $icon_animation = $block_title_front = $block_desc_front = $block_title_back = $block_desc_back = $button_text = $button_link = $block_text_color = $block_front_color = $block_back_color = $el_class = $block_back_text_color = $animation = $font_size_icon = $box_border_style = $box_border_size = $box_border_color = $border_size = $border_color = $box_border_color_back = $custom_link = $button_bg = $button_txt = $height_type = $box_height = $flip_type = $flip_box_style = $text_color = $bg_color = $front_text = $back_text = $module_animation ='';
			extract(shortcode_atts( array(
				'icon_type' => 'selector',
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
				'block_title_front' => '',
				'block_desc_front' => '',
				'block_title_back' => '',
				'block_desc_back' =>'',
				'custom_link' => '',
				'button_text' =>'',
				'button_link' =>'',
				'button_bg' => '',
				'button_txt' => '',
				'flip_type' =>'horizontal_flip_left',
				'text_color' => '',
				'bg_color' => '',
				'block_text_color' =>'',
				'block_front_color' =>'',
				'block_back_color' =>'',
				'el_class' =>'',
				'block_back_text_color' =>'',
				'border_size' => '', 
				'border_color' => '', 
				'box_border_style' => 'none',
				'box_border_size' => '', 
				'box_border_color' => '', 
				'box_border_color_back' => '',
				'height_type' => 'ifb-jq-height',
				'box_height' => '',
				'flip_box_style' => 'simple',
				'module_animation' => '',
			),$atts));	
			$output = $f_style = $b_style = $ico_color = $box_border = $icon_border = $link_style = $height = $link_sufix = $link_prefix = $link_style = '';
			$flip_icon = do_shortcode('[just_icon icon_type="'.$icon_type.'" icon="'.$icon.'" icon_img="'.$icon_img.'" img_width="'.$img_width.'" icon_size="'.$icon_size.'" icon_color="'.$icon_color.'" icon_style="'.$icon_style.'" icon_color_bg="'.$icon_color_bg.'" icon_color_border="'.$icon_color_border.'"  icon_border_style="'.$icon_border_style.'" icon_border_size="'.$icon_border_size.'" icon_border_radius="'.$icon_border_radius.'" icon_border_spacing="'.$icon_border_spacing.'" icon_link="'.$icon_link.'" icon_animation="'.$icon_animation.'"]');
			$css_trans = $icon_border = $box_border = '';
			$height = '';
			if($icon_border_style !== 'none')
			{
				$icon_border .= 'border-style: '.$icon_border_style.';';
				$icon_border .= 'border-width: '.$icon_border_size.'px;';
			}
			if($height_type == "ifb-custom-height"){
				$height = 'height:'.$box_height.'px;';
				$flip_type .= ' flip-box-custom-height';
			}
			if($flip_box_style !== 'simple'){
				$border_front =  'border-color:'.$box_border_color.';';
				$border_back =  'border-color:'.$box_border_color_back.';';
				if($box_border_style !== 'none')
				{
					$box_border .= 'border-style: '.$box_border_style.';';
					$box_border .= 'border-width: '.$box_border_size.'px;';
				}
				if($animation !== 'none')
				{
					$css_trans = 'data-animation="'.$animation.'" data-animation-delay="03"';
				}
				if($block_text_color != ''){
					$f_style .='color:'.$block_text_color.';';
					$front_text .='color:'.$block_text_color.';';
				}
				if($block_front_color != '')
					$f_style .= 'background:'.$block_front_color.';';
				if($block_back_text_color != ''){
					$b_style .='color:'.$block_back_text_color.';';
					$back_text .='color:'.$block_back_text_color.';';
				}
				if($block_back_color != '')
					$b_style .= 'background:'.$block_back_color.';';
			} else {
				if($text_color != ''){
					$f_style .='color:'.$text_color.';';
					$b_style .='color:'.$text_color.';';
					$front_text = $back_text = 'color:'.$text_color.';';
				}
				if($bg_color != '')
				{
					$f_style .= 'background:'.$bg_color.';';
					$b_style .= 'background:'.$bg_color.';';
				}
				if($border_color != ''){
					$border_front =  'border-color:'.$border_color.';';
					$border_back =  'border-color:'.$border_color.';';
					$box_border = 'border-width: '.$border_size.'px;';
					$box_border .= 'border-style: solid;';
				}
			}

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			$output .= '<div class="flip-box-wrap '.$animate.'" '.$animation_data.'>';
			$output .= '<div class="flip-box '.$height_type.' '.$el_class. $flip_type .'" '.$css_trans.' style="'.$height.'">';
			$output .= '<div class="ifb-flip-box">';
				$output .= '<div class="ifb-face ifb-front" style="'.$f_style.' '.$box_border.' '.$border_front.'">';
						if($icon !== '' || $icon_img !== '')
								$output.='<div class="flip-box-icon">'.$flip_icon.'</div>';
						if($block_title_front!='')
							$output.='<h3 style="'.$front_text.'">'.$block_title_front.'</h3>';
						if($block_desc_front!='')
							$output.='<p>'.$block_desc_front.'</p>';
					$output.='</div><!-- END .front -->
						<div class="ifb-face ifb-back" style="'.$b_style.' '.$box_border.' '.$border_back.'">';
							if($block_title_back!='')
								$output.='<h3 style="'.$back_text.'">'.$block_title_back.'</h3>';
							if($block_desc_back!=''){
								if($button_link !== ''){
									$output .= '<div class="ifb-desc-back">';
								}
								$output.='<p>'.$block_desc_back.'</p>';
								if($button_link !== ''){
									$output .= '</div>';
								}
							}
							if($button_text!== '' && $custom_link){
								$link_prefix = '<div class="flip_link">';
								if($button_bg !== '' && $button_txt !== '')
									$link_style = 'style="background:'.$button_bg.'; color:'.$button_txt.';"';
								if($button_link!== ''){								
									$href = vc_build_link($button_link);
									if(isset($href['target'])){
										$target = 'target="'.$href['target'].'"';
									}
									$link_prefix .= '<a href = "'.$href['url'].'" '.$target.' '.$link_style.'>';
									$link_sufix .= '</a>';
								}
								$link_sufix .= '</div>';
								$output.=$link_prefix.$button_text.$link_sufix;
							}
						$output.='</div><!-- END .back -->';
					$output .= '</div> <!-- ifb-flip-box -->';
				$output .= '</div> <!-- flip-box -->';
			$output .='</div><!-- End icon block -->';
			return $output;		
		}
	}
	//instantiate the class
	new AIO_Flip_Box;
}