<?php
/*
* Add-on Name: Stats Counter for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists('AIO_Stats_Counter'))
{
	class AIO_Stats_Counter
	{
		// constructor
		function __construct()
		{
			add_action('admin_init',array($this,'counter_init'));
			add_shortcode('stat_counter',array($this,'counter_shortcode'));
		}
		// initialize the mapping function
		function counter_init()
		{
			if(function_exists('vc_map'))
			{

				$group = __("Main Options", "crum");

				// map with visual
				vc_map(
					array(
						"name" => __("Counter", 'crum'),
						"base" => "stat_counter",
						"class" => "vc_stats_counter",
						"icon" => "vc_icon_stats",
						"category" => __("Presentation",'crum'),
						"description" => __("Your milestones, achievements, etc.","crum"),
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
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php' target='_blank'>add new here</a>.", "crum"),
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
								//"dependency" => Array("element" => "icon_type","value" => array("selector")),
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
								"min" => 0,
								"max" => 500,
								"suffix" => "px",
								"group"       => $group,
								"description" => __("Spacing from center of the icon till the boundary of border / background", "crum"),
								"dependency" => Array("element" => "icon_style", "value" => array("advanced")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon Position", "crum"),
								"param_name" => "icon_position",
								"value" => array(
									'Top' => 'top',
									'Right' => 'right',
									'Left' => 'left',
								),
								"group"       => $group,
								"description" => __("Enter Position of Icon", "crum")
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Counter Title ", "crum"),
								"param_name" => "counter_title",
								"admin_label" => true,
								"value" => "",
								"group"       => $group,
								"description" => __("Enter title for stats counter block", "crum")
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Counter Value", "crum"),
								"param_name" => "counter_value",
								"value" => "1250",
								"group"       => $group,
								"description" => __("Enter number for counter without any special characters. e.g 125000 or 12.75", "crum")
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Digit Separator", "crum"),
								"param_name" => "counter_sep",
								"value" => ",",
								"group"       => $group,
								"description" => __("Enter character for decimal digit separator. e.g. ',' will separate 125000 into 1,25,00", "crum")
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Decimal Character", "crum"),
								"param_name" => "counter_decimal",
								"value" => ".",
								"group"       => $group,
								"description" => __("Enter custom charater for decimal. e.g '.' or '/' ", "crum"),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Counter Value Prefix", "crum"),
								"param_name" => "counter_prefix",
								"value" => "",
								"group"       => $group,
								"description" => __("Enter prefix for counter value", "crum")
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Counter Value Suffix", "crum"),
								"param_name" => "counter_suffix",
								"value" => "",
								"group"       => $group,
								"description" => __("Enter suffix for counter value", "crum")
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Counter rolling time", "crum"),
								"param_name" => "speed",
								"value" => 3,
								"min" => 1,
								"max" => 10,
								"suffix" => "seconds",
								"group"       => $group,
								"description" => __("How many seconds the counter should roll?", "crum")
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Title Font Size", "crum"),
								"param_name" => "font_size_title",
								"value" => 18,
								"min" => 10,
								"max" => 72,
								"suffix" => "px",
								"group"       => $group,
								"description" => __("Enter value in pixels.", "crum")
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Counter Font Size", "crum"),
								"param_name" => "font_size_counter",
								"value" => 28,
								"min" => 12,
								"max" => 72,
								"suffix" => "px",
								"group"       => $group,
								"description" => __("Enter value in pixels.", "crum")
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Extra Class",  "crum"),
								"param_name" => "el_class",
								"value" => "",
								"group"       => $group,
								"description" => __("Add extra class name that will be applied to the icon process, and you can use this class for your customizations.",  "crum"),
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
		// Shortcode handler function for stats counter
		function counter_shortcode($atts)
		{
			wp_enqueue_script('front-js',get_template_directory_uri() .'/library/inc/crum-vc-ultimate/assets/js/countUp.js');
			wp_enqueue_style('crumVCmodules');
			$icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $icon_link = $el_class = $icon_animation = $counter_title = $counter_value = $icon_position = $counter_style = $font_size_title = $font_size_counter = $counter_font = $title_font = $speed = $el_class = $counter_sep = $counter_suffix = $counter_prefix = $counter_decimal = $counter_color_txt = $counter_icon_bg_color = $module_animation = '';
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
				'counter_title' => '',
				'counter_value' => '',
				'counter_sep' => '',
				'counter_suffix' => '',
				'counter_prefix' => '',
				'counter_decimal' => '',
				'icon_position'=>'top',
				'counter_style'=>'',
				'speed'=>'',
				'font_size_title' => '',
				'font_size_counter' => '',
				'counter_color_txt' => '',
				'el_class'=>'',
				'module_animation' => '',
			),$atts));			 
			$class = $style = '';
			$stats_icon = do_shortcode('[just_icon icon_type="'.$icon_type.'" icon="'.$icon.'" icon_img="'.$icon_img.'" img_width="'.$img_width.'" icon_size="'.$icon_size.'" icon_color="'.$icon_color.'" icon_style="'.$icon_style.'" icon_color_bg="'.$icon_color_bg.'" icon_color_border="'.$icon_color_border.'"  icon_border_style="'.$icon_border_style.'" icon_border_size="'.$icon_border_size.'" icon_border_radius="'.$icon_border_radius.'" icon_border_spacing="'.$icon_border_spacing.'" icon_link="'.$icon_link.'" icon_animation="'.$icon_animation.'"]');
			if($counter_color_txt !== ''){
				$counter_color = 'color:'.$counter_color_txt.';';
			} else {
				$counter_color = '';
			}
			if($icon_color != '')
				$style.='color:'.$icon_color.';';
			if($icon_animation !== 'none')
			{
				$css_trans = 'data-animation="'.$icon_animation.'" data-animation-delay="03"';
			}
			$counter_font = 'font-size:'.$font_size_counter.'px;';
			$title_font = 'font-size:'.$font_size_title.'px;';
			
			if($counter_style !=''){
				$class = $counter_style;
				if(strpos($counter_style, 'no_bg')){
					$style.= "border:2px solid ".$counter_icon_bg_color.';';
				}
				elseif(strpos($counter_style, 'with_bg')){
					if($counter_icon_bg_color != '')
						$style.='background:'.$counter_icon_bg_color.';';
				}
			}
			if($el_class != '')
				$class.= ' '.$el_class;
			$ic_position = 'stats-'.$icon_position;
			$ic_class = 'aio-icon-'.$icon_position;

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			$output = '<div class="stats-block '.$animate.' '.$ic_position.' '.$class.'" '.$animation_data.'>';
				//$output .= '<div class="stats-icon" style="'.$style.'">
				//				<i class="'.$stats_icon.'"></i>
				//			</div>';
				$id = 'counter_'.uniqid();
				if($counter_sep == ""){
					$counter_sep = 'none';
				}
				if($counter_decimal == ""){
					$counter_decimal = 'none';
				}
				if($icon_position !== "right")
					$output .= '<div class="'.$ic_class.'">'.$stats_icon.'</div>';
				$output .= '<div class="stats-desc">';
					if($counter_prefix !== ''){
						$output .= '<div class="counter_prefix" style="'.$counter_font.'">'.$counter_prefix.'</div>';
					}
					$output .= '<div id="'.$id.'" data-id="'.$id.'" class="stats-number" style="'.$counter_font.' '.$counter_color.'" data-speed="'.$speed.'" data-counter-value="'.$counter_value.'" data-separator="'.$counter_sep.'" data-decimal="'.$counter_decimal.'">0</div>';
					if($counter_suffix !== ''){
						$output .= '<div class="counter_suffix" style="'.$counter_font.' '.$counter_color.'">'.$counter_suffix.'</div>';
					}
					$output .= '<div class="stats-text" style="'.$title_font.' '.$counter_color.'">'.$counter_title.'</div>';
				$output .= '</div>';
				if($icon_position == "right")
					$output .= '<div class="'.$ic_class.'">'.$stats_icon.'</div>';
			$output .= '</div>';				
			return $output;		
		}
	}
}
if(class_exists('AIO_Stats_Counter'))
{
	$AIO_Stats_Counter = new AIO_Stats_Counter;
}