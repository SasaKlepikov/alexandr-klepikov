<?php
/*
* Add-on Name: Info Tables for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists("Ultimate_Info_Table")){
	class Ultimate_Info_Table{
		function __construct(){
			add_action("admin_init",array($this,"ultimate_it_init"));
			add_shortcode("ultimate_info_table",array($this,"ultimate_it_shortcode"));
		}
		function ultimate_it_init(){
			if(function_exists("vc_map")){

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name" => __("Info Tables", 'crum'),
						"base" => "ultimate_info_table",
						"class" => "vc_ultimate_info_table",
						"icon" => "vc_ultimate_info_table",
						"category" => __("Presentation",'crum'),
						"description" => __("Create nice looking info tables.","crum"),
						"params" => array(
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Select Design Style", "crum"),
								"param_name" => "design_style",
								"value" => array(
									"Design 01" => "design01",
									"Design 02" => "design02",
									"Design 03" => "design03",
									"Design 04" => "design04",
									"Design 05" => "design05",
                                    "Design 06" => "design06",
                                    "Design 07" => "design07",
                                    "Design 08" => "design08",
                                    "Design 09" => "design09",
								),
								"group"       => $group,
								"description" => __("Select Info table design you would like to use", "crum")
							),
                            array(
                                "type" => "colorpicker",
                                "class" => "",
                                "heading" => __("Accent color", "crum"),
                                "param_name" => "heading_color",
                                "value" => "",
                                "group"       => $group,
                                "dependency" => Array("element" => "design_style", "value" => array("design01","design04","design07","design08","design02", "design09", "design06")),
                            ),
                            array(
                                "type" => "colorpicker",
                                "class" => "",
                                "heading" => __("Button color", "crum"),
                                "param_name" => "button_color",
                                "value" => "",
                                "group"       => $group,
                            ),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Heading", "crum"),
								"param_name" => "package_heading",
								"admin_label" => true,
								"value" => "",
								"group"       => $group,
								"description" => __("The title of Info Table", "crum"),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Sub Heading", "crum"),
								"param_name" => "package_sub_heading",
								"value" => "",
								"group"       => $group,
								"description" => __(" Describe the info table in one line", "crum"),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Icon to display:", "crum"),
								"param_name" => "icon_type",
								"value" => array(
									"No Icon" => "none",
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
								"type" => "textarea_html",
								"class" => "",
								"heading" => __("Features", "crum"),
								"param_name" => "content",
								"value" => "",
								"group"       => $group,
								"description" => __("Describe the Info Table in brief.", "crum"),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Add link", "crum"),
								"param_name" => "use_cta_btn",
								"value" => array(
									"No Link" => "",
									"Call to Action Button" => "true",
									"Link to Complete Box" => "box",
								),
								"group"       => $group,
								"description" => __("Do you want to display call to action button?","crum"),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Call to action button text", "crum"),
								"param_name" => "package_btn_text",
								"value" => "",
								"group"       => $group,
								"description" => __("Enter call to action button text", "crum"),
								"dependency" => Array("element" => "use_cta_btn", "value" => array("true")),
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Call to action link", "crum"),
								"param_name" => "package_link",
								"value" => "",
								"group"       => $group,
								"description" => __("Select / enter the link for call to action button", "crum"),
								"dependency" => Array("element" => "use_cta_btn", "value" => array("true","box")),
							),
							// Customize everything
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Extra Class", "crum"),
								"param_name" => "el_class",
								"value" => "",
								"group"       => $group,
								"description" => __("Add extra class name that will be applied to the icon box, and you can use this class for your customizations.", "crum"),
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
						)// params
					));// vc_map
			}
		}

        function adjustBrightness($hex, $steps) {
            // Steps should be between -255 and 255. Negative = darker, positive = lighter
            $steps = max(-255, min(255, $steps));

            // Format the hex color string
            $hex = str_replace('#', '', $hex);
            if (strlen($hex) == 3) {
                $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
            }

            // Get decimal values
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));

            // Adjust number of steps and keep it inside 0 to 255
            $r = max(0,min(255,$r + $steps));
            $g = max(0,min(255,$g + $steps));
            $b = max(0,min(255,$b + $steps));

            $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
            $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
            $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

            return '#'.$r_hex.$g_hex.$b_hex;
        }

		function ultimate_it_shortcode($atts,$content = null){
			$design_style = 'design01';
			extract(shortcode_atts(array(
				"design_style" => "",
			),$atts));
			$output = '';

			require_once(get_template_directory().'/library/inc/crum-vc-ultimate/templates/info-tables/info-table-'.$design_style.'.php');
			$design_func = 'generate_'.$design_style;
			$design_cls = 'Info_'.ucfirst($design_style);
			$class = new $design_cls;
			$output .= $class->generate_design($atts,$content);
			return $output;
		}
	} // class Ultimate_Info_Table
	new Ultimate_Info_Table;
}