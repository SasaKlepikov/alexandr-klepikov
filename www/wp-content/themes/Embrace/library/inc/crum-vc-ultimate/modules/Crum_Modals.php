<?php
/*
* Add-on Name: Ultimate Modals
* Add-on URI: https://www.brainstormforce.com
*/
if(!class_exists('Ultimate_Modals'))
{
	class Ultimate_Modals
	{
		function __construct()
		{
			// Add shortcode for icon box
			add_shortcode('ultimate_modal', array(&$this, 'modal_shortcode' ) );
			// Initialize the icon box component for Visual Composer
			add_action('admin_init', array( &$this, 'ultimate_modal_init' ) );
		}
		// Add shortcode for icon-box
		function modal_shortcode($atts, $content = null)
		{
			wp_enqueue_script('ultimate-modernizr',get_template_directory_uri() .'/library/inc/crum-vc-ultimate/assets/js/modernizr.custom.js','1.0',array('jquery'));
			wp_enqueue_script('ultimate-classie',get_template_directory_uri() .'/library/inc/crum-vc-ultimate/assets/js/classie.js','1.0',array('jquery'));
			wp_enqueue_script('ultimate-snap-svg',get_template_directory_uri() .'/library/inc/crum-vc-ultimate/assets/js/snap.svg-min.js','1.0',array('jquery'));
			wp_enqueue_script('ultimate-modal',get_template_directory_uri() .'/library/inc/crum-vc-ultimate/assets/js/modal.js','1.0',array('jquery'),true);
			wp_enqueue_style('ultimate-modal',get_template_directory_uri() .'/library/inc/crum-vc-ultimate/assets/css/modal.css');
			
			$icon = $modal_on = $btn_size = $btn_bg_color = $btn_txt_color = $btn_text = $read_text = $txt_color = $modal_title = $modal_size = $el_class = $modal_style = $icon_type = $icon_img = $btn_img = $modal_on_align = $module_animation = $onload_delay = '';
			extract(shortcode_atts(array(
				'icon_type' => 'none',
				'icon' => '',
				'icon_img' => '',
				'modal_on' => 'button',
				'onload_delay'=>'',
				'btn_size' => 'sm',
				'btn_bg_color' => '',
				'btn_txt_color' => '',
				'btn_text' => '',				
				'read_text' => '',
				'txt_color' => '',
				'btn_img' => '',
				'modal_title' => '',
				'modal_size' => 'small',
				'modal_style' => 'overlay-cornerbottomleft',
				'modal_on_align' => 'center',
				'el_class' => '',
				'module_animation' => '',
				),$atts,'ultimate_modal'));
			$html = $style = $box_icon = $modal_class = $modal_data_class = $uniq = $overlay_bg = $border_style = '';

			$uniq = uniqid();
			if($icon_type == 'custom'){
				$ico_img = wp_get_attachment_image_src( $icon_img, 'large');
				$box_icon = '<div class="modal-icon"><img src="'.$ico_img[0].'" class="ult-modal-inside-img"></div>';
			} elseif($icon_type == 'selector'){
				if($icon !== '')
					$box_icon = '<div class="modal-icon"><i class="'.$icon.'"></i></div>';
			}
			if($modal_style != 'overlay-show-cornershape' && $modal_style != 'overlay-show-genie' && $modal_style != 'overlay-show-boxes'){
				$modal_class = 'overlay-show';
				$modal_data_class = 'data-overlay-class="'.$modal_style.'"';
			} else {
				$modal_class = $modal_style;
				$modal_data_class = '';
			}

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			if($modal_on == "button"){
				if($btn_bg_color !== ''){
					$style .= 'background:'.$btn_bg_color.';';
					$style .= 'border-color:'.$btn_bg_color.';';
				}
				if($btn_txt_color !== ''){
					$style .= 'color:'.$btn_txt_color.';';
				}
				$html .= '<button style="'.$style.'" data-class-id="content-'.$uniq.'" class="btn '.$animate.' btn-primary btn-'.$btn_size.' '.$modal_class.' vc_txt_align_'.$modal_on_align.'" '.$modal_data_class.' '.$animation_data.'>'.$btn_text.'</button>';
			} elseif($modal_on == "image"){
				if($btn_img !==''){
					$img = wp_get_attachment_image_src( $btn_img, 'large');
					$html .= '<img src="'.$img[0].'" data-class-id="content-'.$uniq.'" class="ult-modal-img '.$modal_class.' '.$animate.' vc_txt_align_'.$modal_on_align.'" '.$modal_data_class.' '.$animation_data.'/>';
				}
			} 
			elseif($modal_on == "onload"){				
				$html .= '<div data-class-id="content-'.$uniq.'" class="ult-onload '.$modal_class.' " '.$modal_data_class.' data-onload-delay="'.$onload_delay.'"></div>';				
			} 
			else {
				if($txt_color !== ''){
					$style .= 'color:'.$txt_color.';';
					$style .= 'cursor:pointer;';
				}
				$html .= '<div style="'.$style.'" data-class-id="content-'.$uniq.'" class="'.$modal_class.' '.$animate.' vc_txt_align_'.$modal_on_align.'" '.$modal_data_class.' '.$animation_data.'>'.$read_text.'</div>';
			}
			if($modal_style == 'overlay-show-cornershape') {
				$html .= "\n".'<div class="ult-overlay overlay-cornershape content-'.$uniq.' '.$el_class.'" data-class="content-'.$uniq.'" data-path-to="m 0,0 1439.999975,0 0,805.99999 -1439.999975,0 z">';
            	$html .= "\n\t".'<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1440 806" preserveAspectRatio="none">
                					<path class="overlay-path" d="m 0,0 1439.999975,0 0,805.99999 0,-805.99999 z" style="'.$overlay_bg.'"/>
            					</svg>';
			} elseif($modal_style == 'overlay-show-genie') {
				$html .= "\n".'<div class="ult-overlay overlay-genie content-'.$uniq.' '.$el_class.'" data-class="content-'.$uniq.'" data-steps="m 701.56545,809.01175 35.16718,0 0,19.68384 -35.16718,0 z;m 698.9986,728.03569 41.23353,0 -3.41953,77.8735 -34.98557,0 z;m 687.08153,513.78234 53.1506,0 C 738.0505,683.9161 737.86917,503.34193 737.27015,806 l -35.90067,0 c -7.82727,-276.34892 -2.06916,-72.79261 -14.28795,-292.21766 z;m 403.87105,257.94772 566.31246,2.93091 C 923.38284,513.78233 738.73561,372.23931 737.27015,806 l -35.90067,0 C 701.32034,404.49318 455.17312,480.07689 403.87105,257.94772 z;M 51.871052,165.94772 1362.1835,168.87863 C 1171.3828,653.78233 738.73561,372.23931 737.27015,806 l -35.90067,0 C 701.32034,404.49318 31.173122,513.78234 51.871052,165.94772 z;m 52,26 1364,4 c -12.8007,666.9037 -273.2644,483.78234 -322.7299,776 l -633.90062,0 C 359.32034,432.49318 -6.6979288,733.83462 52,26 z;m 0,0 1439.999975,0 0,805.99999 -1439.999975,0 z">';
				$html .= "\n\t".'<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1440 806" preserveAspectRatio="none">
							<path class="overlay-path" d="m 701.56545,809.01175 35.16718,0 0,19.68384 -35.16718,0 z" style="'.$overlay_bg.'"/>
						</svg>';
			} elseif($modal_style == 'overlay-show-boxes') {
				$html .= "\n".'<div class="ult-overlay overlay-boxes content-'.$uniq.' '.$el_class.'" data-class="content-'.$uniq.'">';
				$html .= "\n\t".'<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="101%" viewBox="0 0 1440 806" preserveAspectRatio="none">';
				$html .= "\n\t\t".'<path d="m0.005959,200.364029l207.551124,0l0,204.342453l-207.551124,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m0.005959,400.45401l207.551124,0l0,204.342499l-207.551124,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m0.005959,600.544067l207.551124,0l0,204.342468l-207.551124,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m205.752151,-0.36l207.551163,0l0,204.342437l-207.551163,0l0,-204.342437z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m204.744629,200.364029l207.551147,0l0,204.342453l-207.551147,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m204.744629,400.45401l207.551147,0l0,204.342499l-207.551147,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m204.744629,600.544067l207.551147,0l0,204.342468l-207.551147,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m410.416046,-0.36l207.551117,0l0,204.342437l-207.551117,0l0,-204.342437z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m410.416046,200.364029l207.551117,0l0,204.342453l-207.551117,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m410.416046,400.45401l207.551117,0l0,204.342499l-207.551117,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m410.416046,600.544067l207.551117,0l0,204.342468l-207.551117,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m616.087402,-0.36l207.551086,0l0,204.342437l-207.551086,0l0,-204.342437z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m616.087402,200.364029l207.551086,0l0,204.342453l-207.551086,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m616.087402,400.45401l207.551086,0l0,204.342499l-207.551086,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m616.087402,600.544067l207.551086,0l0,204.342468l-207.551086,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m821.748718,-0.36l207.550964,0l0,204.342437l-207.550964,0l0,-204.342437z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m821.748718,200.364029l207.550964,0l0,204.342453l-207.550964,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m821.748718,400.45401l207.550964,0l0,204.342499l-207.550964,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m821.748718,600.544067l207.550964,0l0,204.342468l-207.550964,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1027.203979,-0.36l207.550903,0l0,204.342437l-207.550903,0l0,-204.342437z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1027.203979,200.364029l207.550903,0l0,204.342453l-207.550903,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1027.203979,400.45401l207.550903,0l0,204.342499l-207.550903,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1027.203979,600.544067l207.550903,0l0,204.342468l-207.550903,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1232.659302,-0.36l207.551147,0l0,204.342437l-207.551147,0l0,-204.342437z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1232.659302,200.364029l207.551147,0l0,204.342453l-207.551147,0l0,-204.342453z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1232.659302,400.45401l207.551147,0l0,204.342499l-207.551147,0l0,-204.342499z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m1232.659302,600.544067l207.551147,0l0,204.342468l-207.551147,0l0,-204.342468z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t\t".'<path d="m-0.791443,-0.360001l207.551163,0l0,204.342438l-207.551163,0l0,-204.342438z" style="'.$overlay_bg.'"/>';
				$html .= "\n\t".'</svg>';
			} else {
				$html .= "\n".'<div class="ult-overlay content-'.$uniq.' '.$el_class.'" data-class="content-'.$uniq.'" id="button-click-overlay" style="'.$overlay_bg.'">';
			}
			$html .= "\n\t".'<div class="ult_modal ult-fade ult-'.$modal_size.'">';
			$html .= "\n\t\t".'<div class="ult_modal-content" style="'.$border_style.'">';
			if($modal_title !== ''){
				$html .= "\n\t\t\t".'<div class="ult_modal-header" style="">';
				$html .= "\n\t\t\t\t".$box_icon.'<h3 class="ult_modal-title">'.$modal_title.'</h3>';
				$html .= "\n\t\t\t".'</div>';
			}
			$html .= "\n\t\t\t".'<div class="ult_modal-body">';
			$html .= "\n\t\t\t".do_shortcode($content);
			$html .= "\n\t\t\t".'</div>';
			$html .= "\n\t".'</div>';
			$html .= "\n\t".'</div>';
			$html .= "\n\t".'<div class="ult-overlay-close">Close</div>';
			$html .= "\n".'</div>';

			return $html;
		}
		/* Add icon box Component*/
		function ultimate_modal_init()
		{
			if ( function_exists('vc_map'))
			{

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name"		=> __("Modal Box", "crum"),
						"base"		=> "ultimate_modal",
						"icon"		=> "vc_modal_box",
						"class"	   => "modal_box",
						"category"  => __("Presentation", "crum"),
						"description" => "Adds bootstrap modal box in your content",
						"controls" => "full",
						"show_settings_on_create" => true,
						"params" => array(
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
								"description" => __("Use <a href='admin.php?page=Font_Icon_Manager' target='_blank'>existing font icon</a> or upload a custom image.", "crum")
							),
							array(
								"type" => "icon_manager",
								"class" => "",
								"heading" => __("Select Icon ","crum"),
								"param_name" => "icon",
								"value" => "",
								"group"       => $group,
								"description" => __("Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=Crum_Icon_Manager' target='_blank'>add new here</a>.", "crum"),
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
							// Modal Title
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Modal Box Title", "crum"),
								"param_name" => "modal_title",
								"admin_label" => true,
								"value" => "",
								"group"       => $group,
								"description" => __("Provide the title for modal box.", "crum"),
							),
							// Add some description
							array(
								"type" => "textarea_html",
								"class" => "",
								"heading" => __("Modal Content", "crum"),
								"param_name" => "content",
								"value" => "",
								"group"       => $group,
								"description" => __("Provide the description for this icon box.", "crum")
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Display Modal On -", "crum"),
								"param_name" => "modal_on",
								"value" => array(
									"Button" => "button",
									"Image" => "image",
									"Text" => "text",
									"On Load" => "onload",
								),
								"group"       => $group,
								"description" => __("Select the target selector for modal", "crum")
							),
							array(
								"type"=>"number",
								"class"=>'',
								"heading"=>"Delay in Popup Display",
								"param_name"=>"onload_delay",
								"value"=>"2",
								"suffix"=>"seconds",
								"group"       => $group,
								"description"=>__("Time delay before modal popup on page load (in seconds)","crum"),
								"dependency"=>Array("element"=>"modal_on","value"=>array("onload"))
							),
							array(
								"type" => "attach_image",
								"class" => "",
								"heading" => __("Upload Image", "crum"),
								"param_name" => "btn_img",
								"admin_label" => true,
								"value" => "",
								"group"       => $group,
								"description" => __("Upload the custom image / image banner.", "crum"),
								"dependency" => Array("element" => "modal_on","value" => array("image")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Button Size", "crum"),
								"param_name" => "btn_size",
								"value" => array(
									"Small" => "sm",
									"Medium" => "md",
									"Large" => "lg",
									"Block" => "block",
								),
								"group"       => $group,
								"description" => __("How big the button would you like?", "crum"),
								"dependency" => Array("element" => "modal_on","value" => array("button")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Button Background Color", "crum"),
								"param_name" => "btn_bg_color",
								"value" => "#333333",
								"group"       => $group,
								"description" => __("Give it a nice paint!", "crum"),
								"dependency" => Array("element" => "modal_on","value" => array("button")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Button Text Color", "crum"),
								"param_name" => "btn_txt_color",
								"value" => "#FFFFFF",
								"group"       => $group,
								"description" => __("Give it a nice paint!", "crum"),
								"dependency" => Array("element" => "modal_on","value" => array("button")),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Alignment", "crum"),
								"param_name" => "modal_on_align",
								"value" => array(
									"Center" => "center",
									"Left" => "left",
									"Right" => "right",
								),
								"group"       => $group,
								"dependency"=>Array("element"=>"modal_on","value"=>array("button","image","text")),
								"description" => __("Selector the alignment of button/text/image", "crum")
							),
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Text on Button", "crum"),
								"param_name" => "btn_text",
								"admin_label" => true,
								"value" => "",
								"group"       => $group,
								"description" => __("Provide the title for this button.", "crum"),
								"dependency" => Array("element" => "modal_on","value" => array("button")),
							),
							// Custom text for modal trigger
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __("Enter Text", "crum"),
								"param_name" => "read_text",
								"value" => "",
								"group"       => $group,
								"description" => __("Enter the text on which the modal box will be triggered.", "crum"),
								"dependency" => Array("element" => "modal_on","value" => array("text")),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Text Color", "crum"),
								"param_name" => "txt_color",
								"value" => "#f60f60",
								"group"       => $group,
								"description" => __("Give it a nice paint!", "crum"),
								"dependency" => Array("element" => "modal_on","value" => array("text")),
							),
							// Modal box size
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Modal Size", "crum"),
								"param_name" => "modal_size",
								"value" => array(
									"Small" => "small",
									"Medium" => "medium",
									"Large" => "container",
									"Block" => "block",
								),
								"group"       => $group,
								"description" => __("How big the modal box would you like?", "crum"),
							),
							// Modal Style
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => "Modal Box Style",
								"param_name" => "modal_style",
								"value" => array(
									"Corner Bottom Left" => "overlay-cornerbottomleft",
									"Corner Bottom Right" => "overlay-cornerbottomright",
									"Corner Top Left" => "overlay-cornertopleft",
									"Corner Top Right" => "overlay-cornertopright",
									"Corner Shape" => "overlay-show-cornershape",
									"Door Horizontal" => "overlay-doorhorizontal",
									"Door Vertical" => "overlay-doorvertical",
									"Fade" => "overlay-fade",
									"Genie" => "overlay-show-genie",
									"Little Boxes" => "overlay-show-boxes",
									"Simple Genie" => "overlay-simplegenie",
									"Slide Down" => "overlay-slidedown",
									"Slide Up" => "overlay-slideup",
									"Slide Left" => "overlay-slideleft",
									"Slide Right" => "overlay-slideright",
									"Zoom in" => "overlay-zoomin",
									"Zoom out" => "overlay-zoomout",
								),
								"group"       => $group,
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
						) // end params array
					) // end vc_map array
				); // end vc_map
			} // end function check 'vc_map'
		}// end function icon_box_init
	}//Class Ultimate_Modals end
}
if(class_exists('Ultimate_Modals'))
{
	$Ultimate_Modals = new Ultimate_Modals;
}