<?php
/*
* Add-on Name: Info List for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('AIO_Info_list'))
{
	class AIO_Info_list
	{
		var $connector_animate;
		var $connect_color;
		var $icon_font;
		var $border_col;
		var $icon_style;
		function __construct()
		{
			$this->connector_animate = '';
			$this->connect_color = '';
			$this->icon_style = '';
			$this->icon_style = '';
			add_action('admin_init', array($this, 'add_info_list'));
			if(function_exists('vc_is_inline')){
				if(!vc_is_inline()){
					add_shortcode( 'info_list', array($this, 'info_list' ) );
					add_shortcode( 'info_list_item', array($this, 'info_list_item' ) );
				}
			} else {
				add_shortcode( 'info_list', array($this, 'info_list' ) );
				add_shortcode( 'info_list_item', array($this, 'info_list_item' ) );
			}
		}
		function info_list($atts, $content = null)
		{
			// Do nothing
			$position = $style = $icon_color = $icon_bg_color = $connector_animation = $font_size_icon = $icon_border_style = $icon_border_size = $connector_color = $border_color = $el_class = $module_animation = '';
			extract(shortcode_atts(array(
				'position' => 'left',
				'style' => 'square with_bg',
				'connector_animation' => '',
				'icon_color' =>'',
				'icon_bg_color' =>'',
				'connector_color' => '',
				'border_color' => '',
				'font_size_icon' => '24',
				'icon_border_style' => 'none',
				'icon_border_size' => '',
				'el_class' => '',
				'module_animation' => '',
			), $atts));
			$this->connect_color = $connector_color;
			$this->border_col = $border_color;
			if($style == 'square with_bg' || $style == 'circle with_bg' || $style == 'hexagon'){
				$this->icon_font = 'font-size:'.($font_size_icon*3).'px;';
				if($icon_border_size !== ''){
					$this->icon_style .= 'font-size:'.$font_size_icon.'px;';
					$this->icon_style .= 'border-width:0px;';
					$this->icon_style .= 'border-style:none;';
					$this->icon_style .= 'background:'.$icon_bg_color.';';
					$this->icon_style .= 'color:'.$icon_color.';';
					if($style =="hexagon")
						$this->icon_style .= 'border-color:'.$icon_bg_color.';';
					else
						$this->icon_style .= 'border-color:'.$border_color.';';
				}
			} else {
				$big_size = ($font_size_icon*3)+($icon_border_size*2);
				if($icon_border_size !== ''){
					$this->icon_font = 'font-size:'.$big_size.'px;';
					$this->icon_style .= 'font-size:'.$font_size_icon.'px;';
					$this->icon_style .= 'border-width:'.$icon_border_size.'px;';
					$this->icon_style .= 'border-style:'.$icon_border_style.';';
					$this->icon_style .= 'background:'.$icon_bg_color.';';
					$this->icon_style .= 'color:'.$icon_color.';';
					$this->icon_style .= 'border-color:'.$border_color.';';
				}
			}
			if($position == "top"){
				$this->connector_animate = "fadeInLeft";
			}else{
				$this->connector_animate = $connector_animation;
			}
			$animate = $animation_data = '';

			if ( ! ($module_animation == '')) {
				$animate        = ' cr-animate-gen';
				$animation_data = 'data-animate-item = ".icon_list_item" data-animate-type = "'.$module_animation.'" ';
			}

			$output = '<div class="smile_icon_list_wrap '.$el_class.'">';
			$output .= '<ul class="smile_icon_list '.$animate.' '.$position.' '.$style.'" '.$animation_data.'>';
			$output .= do_shortcode($content);
			$output .= '</ul>';
			$output .= '</div>';
			return $output;
		}
		function info_list_item($atts,$content = null)
		{
			// Do nothing
			$list_title = $list_icon = $animation = $icon_color = $icon_bg_color = $icon_img = $icon_type = '';
			extract(shortcode_atts(array(
				'list_title' => '',
				'animation' => '',
				'list_icon' => '',
				'icon_img' => '',
				'icon_type' => 'selector',
			), $atts));
			//$content =  wpb_js_remove_wpautop($content);
			$css_trans = $style = $ico_col = $connector_trans = $icon_html = '';
			if($animation !== 'none')
			{
				$css_trans = 'data-animation="'.$animation.'" data-animation-delay="0"';
			}
			if($this->connector_animate)
			{
				$connector_trans = 'data-animation="'.$this->connector_animate.'" data-animation-delay="0"';
			}
			if($icon_color !=''){
				$ico_col = 'style="color:'.$icon_color.'";';
			}
			if($icon_bg_color != ''){
				$style .= 'background:'.$icon_bg_color.';  color:'.$icon_bg_color.';';	
			}
			if($icon_bg_color != ''){
				$style .= 'border-color:'.$this->border_col.';';
			}
			if($icon_type == "selector"){		
				$icon_html .= '<div class="icon_list_icon" '.$css_trans.' style="'.$this->icon_style.'">';
				$icon_html .= '<i class="'.$list_icon.'" '.$ico_col.'></i>';
				$icon_html .= '</div>';
			} else {
				$img = wp_get_attachment_image_src( $icon_img, 'large');
				$icon_html .= '<div class="icon_list_icon" '.$css_trans.' style="'.$this->icon_style.'">';
				$icon_html .= '<img class="list-img-icon" src="'.$img[0].'"/>';
				$icon_html .= '</div>';
			}
			$output = '<li class="icon_list_item" style=" '.$this->icon_font.'">';
			$output .= $icon_html;
			$output .= '<div class="icon_description">';
			$output .= '<h3>'.$list_title.'</h3>';
			$output .= '<span class="icon_description_text">'.wpb_js_remove_wpautop($content, true).'</span>';
			$output .= '</div>';
			$output .= '<div class="icon_list_connector" '.$connector_trans.' style="border-color:'.$this->connect_color.';"></div>';
			$output .= '</li>';
			return $output;
		}

	// Shortcode Functions for frontend editor
		function front_info_list($atts, $content = null)
		{
			// Do nothing
			$position = $style = $icon_color = $icon_bg_color = $connector_animation = $font_size_icon = $icon_border_style = $icon_border_size = $connector_color = $border_color = $el_class = '';
			extract(shortcode_atts(array(
				'position' => 'left',
				'style' => 'style',
				'connector_animation' => '',
				'icon_color' =>'',
				'icon_bg_color' =>'',
				'connector_color' => '',
				'border_color' => '',
				'font_size_icon' => '24',
				'icon_border_style' => 'none',
				'icon_border_size' => '',
				'el_class' => '',
			), $atts));
			$this->connect_color = $connector_color;
			$this->border_col = $border_color;
			if($style == 'square with_bg' || $style == 'circle with_bg' || $style == 'hexagon'){
				$this->icon_font = 'font-size:'.($font_size_icon*3).'px;';
				if($icon_border_size !== ''){
					$this->icon_style = 'font-size:'.$font_size_icon.'px;';
					$this->icon_style .= 'border-width:0px;';
					$this->icon_style .= 'border-style:none;';
					$this->icon_style .= 'background:'.$icon_bg_color.';';
					$this->icon_style .= 'color:'.$icon_color.';';
					if($style =="hexagon")
						$this->icon_style .= 'border-color:'.$icon_bg_color.';';
					else
						$this->icon_style .= 'border-color:'.$border_color.';';
				}
			} else {
				$big_size = ($font_size_icon*3)+($icon_border_size*2);
				if($icon_border_size !== ''){
					$this->icon_font = 'font-size:'.$big_size.'px;';
					$this->icon_style = 'font-size:'.$font_size_icon.'px;';
					$this->icon_style .= 'border-width:'.$icon_border_size.'px;';
					$this->icon_style .= 'border-style:'.$icon_border_style.';';
					$this->icon_style .= 'background:'.$icon_bg_color.';';
					$this->icon_style .= 'color:'.$icon_color.';';
					$this->icon_style .= 'border-color:'.$border_color.';';
				}
			}
			if($position == "top"){
				$this->connector_animate = "fadeInLeft";
			}else{
				$this->connector_animate = $connector_animation;
			}
			$output = '<div class="smile_icon_list_wrap '.$el_class.'">';
			$output .= '<ul class="smile_icon_list '.$position.' '.$style.'" data-style="'.$this->icon_style.'" data-fonts="'.$this->icon_font.'" data-connector="'.$connector_color.'">';
			$output .= do_shortcode($content);
			$output .= '</ul>';
			$output .= '</div>';
			return $output;
		}
		function front_info_list_item($atts,$content = null)
		{
			// Do nothing
			$list_title = $list_icon = $animation = $icon_color = $icon_bg_color = $icon_img = $icon_type = '';
			extract(shortcode_atts(array(
				'list_title' => '',
				'animation' => '',
				'list_icon' => '',
				'icon_img' => '',
				'icon_type' => '',
			), $atts));
			//$content =  wpb_js_remove_wpautop($content);
			$css_trans = $style = $ico_col = $connector_trans = $icon_html = '';
			if($animation !== 'none')
			{
				$css_trans = 'data-animation="'.$animation.'" data-animation-delay="03"';
			}
			if($this->connector_animate)
			{
				$connector_trans = 'data-animation="'.$this->connector_animate.'" data-animation-delay="02"';
			}
			if($icon_color !=''){
				$ico_col = 'style="color:'.$icon_color.'";';
			}
			if($icon_bg_color != ''){
				$style .= 'background:'.$icon_bg_color.';  color:'.$icon_bg_color.';';	
			}
			if($icon_bg_color != ''){
				$style .= 'border-color:'.$this->border_col.';';
			}
			if($icon_type == "selector"){		
				$icon_html .= '<div class="icon_list_icon" '.$css_trans.'>';
				$icon_html .= '<i class="'.$list_icon.'" '.$ico_col.'></i>';
				$icon_html .= '</div>';
			} else {
				$img = wp_get_attachment_image_src( $icon_img, 'large');
				$icon_html .= '<div class="icon_list_icon" '.$css_trans.'>';
				$icon_html .= '<img class="list-img-icon" src="'.$img[0].'"/>';
				$icon_html .= '</div>';
			}
			$output = '<li class="icon_list_item">';
			$output .= $icon_html;
			$output .= '<div class="icon_description">';
			$output .= '<h3>'.$list_title.'</h3>';
			$output .= wpb_js_remove_wpautop($content, true);
			$output .= '</div>';
			$output .= '<div class="icon_list_connector" '.$connector_trans.' style="border-color:'.$this->connect_color.';"></div>';
			$output .= '</li>';
			return $output;
		}

		function add_info_list()
		{
			if(function_exists('vc_map'))
			{

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name" => __("Info List","crum"),
						"base" => "info_list",
						"class" => "vc_info_list",
						"icon" => "vc_icon_list",
						"category" => __("Presentation","crum"),
						"as_parent" => array('only' => 'info_list_item'),
						"description" => __("Text blocks connected together in one list.","crum"),
						"content_element" => true,
						"show_settings_on_create" => true,
						"params" => array(
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon or Image Position","crum"),
								"param_name" => "position",
								"value" => array(
									'Icon to the Left' => 'left',
									'Icon to the Right' => 'right',
									'Icon at Top' => 'top',
								),
								"group"       => $group,
								"description" => __("Select the icon position for icon list.","crum")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Style of Image or Icon + Color","crum"),
								"param_name" => "style",
								"value" => array(
									'Square With Background' => 'square with_bg',
									'Square Without Background' => 'square no_bg',
									'Circle With Background' => 'circle with_bg',
									'Circle Without Background' => 'circle no_bg',
									'Hexagon With Background' => 'hexagon',
								),
								"group"       => $group,
								"description" => __("Select the icon style for icon list.","crum")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Border Style", "crum"),
								"param_name" => "icon_border_style",
								"value" => array(
									"None" => "none",
									"Solid"	=> "solid",
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset" => "inset",
									"Outset" => "outset",
								),
								"group"       => $group,
								"description" => __("Select the border style for icon.","crum"),
								"dependency" => Array("element" => "style", "value" => array("square no_bg","circle no_bg")),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Border Width", "crum"),
								"param_name" => "icon_border_size",
								"value" => 1,
								"min" => 0,
								"max" => 10,
								"suffix" => "px",
								"group"       => $group,
								"description" => __("Thickness of the border.", "crum"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Border Color:", "crum"),
								"param_name" => "border_color",
								"value" => "#333333",
								"group"       => $group,
								"description" => __("Select the color border.", "crum"),
								"dependency" => Array("element" => "icon_border_style", "not_empty" => true),
							),
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => __("Connector Line Animation: ","crum"),
								"param_name" => "connector_animation",
								"value" => array (
									'Enabled' => 'fadeInUp',
								),
								"group"       => $group,
								"description" => __("Select wheather to animate connector or not","crum")
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Connector Line Color:", "crum"),
								"param_name" => "connector_color",
								"value" => "#333333",
								"group"       => $group,
								"description" => __("Select the color for connector line.", "crum"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon Background Color:", "crum"),
								"param_name" => "icon_bg_color",
								"value" => "#ffffff",
								"group"       => $group,
								"description" => __("Select the color for icon background.", "crum"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Icon Color:", "crum"),
								"param_name" => "icon_color",
								"value" => "#333333",
								"group"       => $group,
								"description" => __("Select the color for icon.", "crum"),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Icon Font Size", "crum"),
								"param_name" => "font_size_icon",
								"value" => 24,
								"min" => 12,
								"max" => 72,
								"suffix" => "px",
								"group"       => $group,
								"description" => __("Enter value in pixels.", "crum")
							),
							// Customize everything
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Extra Class", "crum"),
								"param_name" => "el_class",
								"value" => "",
								"group"       => $group,
								"description" => __("Add extra class name that will be applied to the info list, and you can use this class for your customizations.", "crum"),
							),
							array(
								"type" => "heading",
								"group"       => $group,
								"sub_heading" => "This is a global setting page for the whole \"Info List\" block. Add some \"Info List Items\" in the container row to make it complete. <a href=\"http://youtu.be/8N3LGsOloWA\" target=\"_blank\"> Learn how. </a>",
								"param_name" => "notification",
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
						"js_view" => 'VcColumnView'
					));
				// Add list item
				vc_map(
					array(
						"name" => __("Info List Item", 'crum'),
						"base" => "info_list_item",
						"class" => "vc_info_list",
						"icon" => "vc_icon_list",
						"category" => __("Presentation",'crum'),
						"content_element" => true,
						"as_child" => array('only' => 'info_list'),
						"params" => array(
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Title","crum"),
								"admin_label" => true,
								"param_name" => "list_title",
								"value" => "",
								"description" => __("Provide a title for this icon list item.","crum")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon to display:", "crum"),
								"param_name" => "icon_type",
								"value" => array(
									"Font Icon Manager" => "selector",
									"Custom Image Icon" => "custom",
								),
								"description" => __("Use <a href='admin.php?page=Font_Icon_Manager' target='_blank'>existing font icon</a> or upload a custom image.", "crum")
							),
							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => __("Select List Icon ","crum"),
								"param_name" => "list_icon",
								"value" => "",
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=Font_Icon_Manager' target='_blank'>add new here</a>.", "crum"),
								"dependency" => Array("element" => "icon_type","value" => array("selector")),
							),
							array(
								"type" => "attach_image",
								"class" => "",
								"heading" => __("Upload Image Icon:", "crum"),
								"param_name" => "icon_img",
								"value" => "",
								"description" => __("Upload the custom image icon.", "crum"),
								"dependency" => Array("element" => "icon_type","value" => array("custom")),
							),
							array(
								"type" => "textarea_html",
								"class" => "",
								"heading" => __("Description","crum"),
								"param_name" => "content",
								"value" => "",
								"description" => __("Description about this list item","crum")
							),
						)
					)
				);
			}//endif
		}
	}
}
global $AIO_Info_list; // WPB: Beter to create singleton in AIO_Info_list I think, but it also work
if(class_exists('WPBakeryShortCodesContainer'))
{
	class WPBakeryShortCode_info_list extends WPBakeryShortCodesContainer {
        function content( $atts, $content = null ) {
            global $AIO_Info_list;
            return $AIO_Info_list->front_info_list($atts, $content);
        }
	}
	class WPBakeryShortCode_info_list_item extends WPBakeryShortCode {
        function content($atts, $content = null ) {
            global $AIO_Info_list;
            return $AIO_Info_list->front_info_list_item($atts, $content);
        }
	}
}
if(class_exists('AIO_Info_list'))
{
	$AIO_Info_list = new AIO_Info_list;
}