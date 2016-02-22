<?php
/*
* Add-on Name: Pricing Tables for Visual Composer
* Add-on URI: http://dev.brainstormforce.com
*/
if(!class_exists("Ultimate_Pricing_Table")){
	class Ultimate_Pricing_Table{
		function __construct(){
			add_action("admin_init",array($this,"ultimate_pricing_init"));
			add_shortcode("ultimate_pricing",array($this,"ultimate_pricing_shortcode"));
		}
		function ultimate_pricing_init(){
			if(function_exists("vc_map")){

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name" => __("Pricing Block", 'crum'),
						"base" => "ultimate_pricing",
						"class" => "vc_ultimate_pricing",
						"icon" => "vc_ultimate_pricing",
						"category" => __("Presentation",'crum'),
						"description" => __("Create nice looking pricing block.","crum"),
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
								"description" => __("Select Pricing table design you would like to use", "crum")
							),
                            array(
                                "type" => "colorpicker",
                                "class" => "",
                                "heading" => __("Accent color", "crum"),
                                "param_name" => "heading_color",
                                "value" => "",
                                "group"       => $group,
                                "dependency" => Array("element" => "design_style", "value" => array("design01","design02","design03","design04","design06","design07","design08","design09")),
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
								"heading" => __("Package Name / Title", "crum"),
								"param_name" => "package_heading",
								"admin_label" => true,
								"value" => "",
								"group"       => $group,
								"description" => __("Enter the package name or table heading", "crum"),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Sub Heading", "crum"),
								"param_name" => "package_sub_heading",
								"value" => "",
								"group"       => $group,
								"description" => __("Enter short description for this package", "crum"),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Package Price", "crum"),
								"param_name" => "package_price",
								"value" => "",
								"group"       => $group,
								"description" => __("Enter the price for this package. e.g. $157", "crum"),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Price Unit", "crum"),
								"param_name" => "package_unit",
								"value" => "",
								"group"       => $group,
								"description" => __("Enter the price unit for this package. e.g. per month", "crum"),
							),
							array(
								"type" => "textarea_html",
								"class" => "",
								"heading" => __("Features", "crum"),
								"param_name" => "content",
								"value" => "",
								"group"       => $group,
								"description" => __("Create the features list using un-ordered list elements.", "crum"),
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Button Text", "crum"),
								"param_name" => "package_btn_text",
								"value" => "",
								"group"       => $group,
								"description" => __("Enter call to action button text", "crum"),
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Button Link", "crum"),
								"param_name" => "package_link",
								"value" => "",
								"group"       => $group,
								"description" => __("Select / enter the link for call to action button", "crum"),
							),
							array(
								"type" => "checkbox",
								"class" => "",
								"heading" => __("", "crum"),
								"param_name" => "package_featured",
								"group"       => $group,
								"value" => array("Make this pricing box as featured" => "enable"),
							),
                            array(
                                "type" => "checkbox",
                                "class" => "",
                                "heading" => __("", "crum"),
                                "param_name" => "package_recommended",
                                "group"       => $group,
                                "value" => array("Make this pricing box as recommended" => "enable"),
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

		function ultimate_pricing_shortcode($atts,$content = null){
			$design_style = '';
			extract(shortcode_atts(array(
				"design_style" => "design01",
			),$atts));
			$output = '';

			require_once(get_template_directory().'/library/inc/crum-vc-ultimate/templates/pricing-tables/pricing-'.$design_style.'.php');
			$design_func = 'generate_'.$design_style;
			$design_cls = 'Pricing_'.ucfirst($design_style);
			$class = new $design_cls;
			$output .= $class->generate_design($atts,$content);
			return $output;
		}
	} // class Ultimate_Pricing_Table
	new Ultimate_Pricing_Table;
}