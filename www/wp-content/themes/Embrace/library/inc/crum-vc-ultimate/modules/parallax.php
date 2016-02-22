<?php
/*
Add-on: Ultimate Parallax Background for VC
Add-on URI: https://brainstormforce.com/demos/parallax/
Description: Display interactive image and video parallax background in visual composer row
Version: 1.0
*/
if(!class_exists('VC_Ultimate_Parallax')){
	class VC_Ultimate_Parallax{
		function __construct(){
			add_action('admin_enqueue_scripts',array($this,'admin_scripts'));
			/*add_action('wp_enqueue_scripts',array($this,'front_scripts'),9999); */
			add_action('admin_init',array($this,'parallax_init'));
			add_filter('parallax_image_video',array($this,'parallax_shortcode'), 10, 2);
			if ( function_exists('add_shortcode_param'))
			{
				//add_shortcode_param('number' , array(&$this, 'number_settings_field' ) );
			}
			if ( function_exists('add_shortcode_param'))
			{
				add_shortcode_param('gradient' , array(&$this, 'gradient_picker' ) );
			}
		}/* end constructor */
		public static function parallax_shortcode($atts, $content){
			$bg_type = $bg_image = $bg_image_new = $bsf_img_repeat = $parallax_style = $video_opts = $video_url = $video_url_2 = $video_poster = $bg_image_size = $bg_image_posiiton = $u_video_url = $parallax_sense = $bg_cstm_size = $bg_override = $bg_img_attach = $u_start_time = $u_stop_time = $layer_image = $css = $animation_type = $horizontal_animation = $vertical_animation = $animation_speed = $animated_bg_color = $fadeout_row = $fadeout_start_effect = $parallax_content = $parallax_content_sense = $disable_on_mobile = $disable_on_mobile_img_parallax = $animation_repeat = $animation_direction = "";
			$bg_image_repeat = $overlay_color = $bg_fade = $commom_data_attributes = $overlay = $seperator_html = $ult_hide_row_data = $viewport_vdo = $controls_color = $enable_controls = $bg_grad = $bg_color_value = '';
			extract( shortcode_atts( array(
				"bg_type" 					=> "",
				"bg_image" 					=> "",
				"bg_image_new" 				=> "",
				"bg_image_repeat" 			=> "no-repeat",
				'bg_image_size'				=> "cover",
				"parallax_style" 			=> "",
				"parallax_sense"			=> "30",
				"video_opts" 				=> "",
				"bg_image_posiiton"			=> "",
				"video_url" 				=> "",
				"video_url_2" 				=> "",
				"video_poster" 				=> "",
				"u_video_url" 				=> "",
				"bg_cstm_size"				=> "",
				"bg_override"				=> "0",
				"bg_img_attach" 			=> "",
				"u_start_time"				=> "",
				"u_stop_time"				=> "",
				"layer_image"				=> "",
				"bg_grad"					=> "",
				"bg_color_value" 			=> "",
				"bg_fade"					=> "",
				"css" 						=> "",
				"viewport_vdo" 				=> "",
				"enable_controls" 			=> "",
				"controls_color" 			=> "",
				"animation_direction" 		=> "left-animation",
				"animation_type" 			=> "h",
				"horizontal_animation" 		=> "",
				"vertical_animation" 		=> "",
				"animation_speed" 			=> "",
				"animation_repeat" 			=> "repeat",
				"animated_bg_color" 		=> "",
				"fadeout_row" 				=> "",
				"fadeout_start_effect" 		=> "30",
				"parallax_content" => "",
				"parallax_content_sense"	=> "30",
				"disable_on_mobile"			=> "",
				"disable_on_mobile_img_parallax" => "",
				"video_fixer" 				=> "true"
			), $atts ) );

			if($bg_img_attach === '')
				$bg_img_attach = 'scroll';

			/* enqueue scripts */
			if($bg_type !== "" || $parallax_content != '' || $fadeout_row != ''){

				if($bg_type == 'no_bg' && ($parallax_content != '' || $fadeout_row != ''))
				{
					wp_enqueue_script('ultimate-row-bg',get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/ultimate_bg.min.js');
					wp_enqueue_script('aio-custom');
				}
				else if($bg_type != 'no_bg' && ($parallax_content != '' || $fadeout_row != ''))
				{
					wp_enqueue_script('aio-jquery-appear');
					wp_enqueue_script('ultimate-row-bg',get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/ultimate_bg.min.js');
					wp_enqueue_script('aio-custom');
				}
				else if($bg_type != 'no_bg' && ($parallax_content == '' || $fadeout_row == ''))
				{
					wp_enqueue_script('aio-jquery-appear');
					wp_enqueue_script('ultimate-row-bg',get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/ultimate_bg.min.js');
					wp_enqueue_script('aio-custom');
				}

				$html = $autoplay = $muted = $loop = $pos_suffix = $bg_img = $bg_img_id = '';

				$rtl = 'false';
				if(is_rtl())
					$rtl = 'true';

				if($disable_on_mobile != '')
				{
					if($disable_on_mobile == 'enable_on_mobile_value')
						$disable_on_mobile = 'true';
					else
						$disable_on_mobile = 'false';
				}
				else
					$disable_on_mobile = 'false';

				if($disable_on_mobile_img_parallax != '')
					$disable_on_mobile_img_parallax = 'true';
				else
					$disable_on_mobile_img_parallax = 'false';

				$output = '<!-- Row Backgrounds -->';
				if($bg_image_new != ""){
					$bg_img_id = $bg_image_new;
				} elseif( $bg_image != ""){
					$bg_img_id = $bg_image;
				} else {
					if($css !== ""){
						$arr = explode('?id=', $css);
						if(isset($arr[1])){
							$arr = explode(')', $arr[1]);
							$bg_img_id = $arr[0];
						}
					}
				}
				if($bg_image_posiiton!=''){
					if(strpos($bg_image_posiiton, 'px')){
						$pos_suffix ='px';
					}
					elseif(strpos($bg_image_posiiton, 'em')){
						$pos_suffix ='em';
					}
					else{
						$pos_suffix='%';
					}
				}
				if($bg_type== "no_bg"){
					$html .= '<div class="upb_no_bg"  data-fadeout="'.$fadeout_row.'" data-fadeout-percentage="'.$fadeout_start_effect.'" data-parallax-content="'.$parallax_content.'" data-parallax-content-sense="'.$parallax_content_sense.'" data-row-effect-mobile-disable="'.$disable_on_mobile.'" data-img-parallax-mobile-disable="'.$disable_on_mobile_img_parallax.'"  data-rtl="'.$rtl.'"></div>';
				}
				elseif($bg_type == "image"){
					if($bg_image_size=='cstm'){
						if($bg_cstm_size!=''){
							$bg_image_size = $bg_cstm_size;
						}
					}
					if($parallax_style == 'vcpb-fs-jquery' || $parallax_style=="vcpb-mlvp-jquery"){
						if($parallax_style == 'vcpb-fs-jquery')
							wp_enqueue_script('jquery.vhparallax',get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/jparallax.min.js');

						//if($parallax_style=="vcpb-mlvp-jquery")
							//wp_enqueue_script('jquery.vhparallax',get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/vhparallax.min.js');
						$imgs = explode(',',$layer_image);
						$layer_image = array();
						foreach ($imgs as $value) {
							$layer_image[] = wp_get_attachment_image_src($value,'full');
						}
						foreach ($layer_image as $key=>$value) {
							$bg_imgs[]=$layer_image[$key][0];
						}
						$html .= '<div class="upb_bg_img"  data-ultimate-bg="'.implode(',', $bg_imgs).'" data-ultimate-bg-style="'.$parallax_style.'" data-bg-img-repeat="'.$bg_image_repeat.'" data-bg-img-size="'.$bg_image_size.'" data-bg-img-position="'.$bg_image_posiiton.'" data-parallx_sense="'.$parallax_sense.'" data-bg-override="'.$bg_override.'" data-upb-overlay-color="'.$overlay_color.'" data-upb-bg-animation="'.$bg_fade.'" data-fadeout="'.$fadeout_row.'" data-fadeout-percentage="'.$fadeout_start_effect.'" data-parallax-content="'.$parallax_content.'" data-parallax-content-sense="'.$parallax_content_sense.'" data-row-effect-mobile-disable="'.$disable_on_mobile.'" data-img-parallax-mobile-disable="'.$disable_on_mobile_img_parallax.'"  data-rtl="'.$rtl.'"></div>';
					}
					else{
						if($parallax_style == 'vcpb-vz-jquery' || $parallax_style=="vcpb-hz-jquery")
						wp_enqueue_script('jquery.vhparallax',get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/vhparallax.min.js');

						if($bg_img_id){
							if($animation_direction == '' && $animation_type != 'false')
							{
								if($animation_type == 'h')
									$animation = $horizontal_animation;
								else
									$animation = $vertical_animation;
							}
							else
							{
								if($animation_direction == 'top-animation' || $animation_direction == 'bottom-animation')
									$animation_type = 'v';
								else
									$animation_type = 'h';
								$animation = $animation_direction;
								if($animation == '')
									$animation = 'left-animation';
							}

							$bg_img = apply_filters('ult_get_img_single', $bg_img_id, 'url');
							$hasImage = wp_get_attachment_image_src( $bg_img_id, 'full' ); // returns an array

							if(isset($hasImage[0]) && !($hasImage[0] == '')){
								$bg_img = $hasImage[0];
							}

							$html .= '<div class="upb_bg_img" data-ultimate-bg="url('.$bg_img.')" data-image-id="'.$bg_img_id.'" data-ultimate-bg-style="'.$parallax_style.'" data-bg-img-repeat="'.$bg_image_repeat.'" data-bg-img-size="'.$bg_image_size.'" data-bg-img-position="'.$bg_image_posiiton.'" data-parallx_sense="'.$parallax_sense.'" data-bg-override="'.$bg_override.'" data-bg_img_attach="'.$bg_img_attach.'" data-upb-overlay-color="'.$overlay_color.'" data-upb-bg-animation="'.$bg_fade.'" data-fadeout="'.$fadeout_row.'" data-bg-animation="'.$animation.'" data-bg-animation-type="'.$animation_type.'" data-animation-repeat="'.$animation_repeat.'" data-fadeout-percentage="'.$fadeout_start_effect.'" data-parallax-content="'.$parallax_content.'" data-parallax-content-sense="'.$parallax_content_sense.'" data-row-effect-mobile-disable="'.$disable_on_mobile.'" data-img-parallax-mobile-disable="'.$disable_on_mobile_img_parallax.'" data-rtl="'.$rtl.'" '.$commom_data_attributes.' '.$overlay.' '.$seperator_html.' '.$ult_hide_row_data.'></div>';
						}
					}
				} elseif($bg_type == "video"){
					$v_opts = explode(",",$video_opts);
					if(is_array($v_opts)){
						foreach($v_opts as $opt){
							if($opt == "muted") $muted .= $opt;
							if($opt == "autoplay") $autoplay .= $opt;
							if($opt == "loop") $loop .= $opt;
						}
					}
					if($viewport_vdo != '')
						$enable_viewport_vdo = 'true';
					else
						$enable_viewport_vdo = 'false';

					$u_stop_time = ($u_stop_time!='')?$u_stop_time:0;
					$u_start_time = ($u_stop_time!='')?$u_start_time:0;
					$v_img = wp_get_attachment_image_src($video_poster,'full');
					$html .= '<div class="upb_content_video"  data-controls-color="'.$controls_color.'" data-controls="'.$enable_controls.'" data-viewport-video="'.$enable_viewport_vdo.'" data-ultimate-video="'.$video_url.'" data-ultimate-video2="'.$video_url_2.'" data-ultimate-video-muted="'.$muted.'" data-ultimate-video-loop="'.$loop.'" data-ultimate-video-poster="'.$v_img[0].'" data-ultimate-video-autoplay="autoplay" data-bg-override="'.$bg_override.'" data-upb-overlay-color="'.$overlay_color.'" data-upb-bg-animation="'.$bg_fade.'" data-fadeout="'.$fadeout_row.'" data-fadeout-percentage="'.$fadeout_start_effect.'" data-parallax-content="'.$parallax_content.'" data-parallax-content-sense="'.$parallax_content_sense.'" data-row-effect-mobile-disable="'.$disable_on_mobile.'" data-img-parallax-mobile-disable="'.$disable_on_mobile_img_parallax.'"  data-rtl="'.$rtl.'"></div>';

					//$html .= '<div class="upb_content_video" data-controls-color="'.$controls_color.'" data-controls="'.$enable_controls.'" data-viewport-video="'.$enable_viewport_vdo.'" data-ultimate-video="'.$video_url.'" data-ultimate-video2="'.$video_url_2.'" data-ultimate-video-muted="'.$muted.'" data-ultimate-video-loop="'.$loop.'" data-ultimate-video-poster="'.$v_img.'" data-ultimate-video-autoplay="autoplay" data-bg-override="'.$bg_override.'" data-upb-overlay-color="'.$overlay_color.'" data-upb-bg-animation="'.$bg_fade.'" data-fadeout="'.$fadeout_row.'" data-fadeout-percentage="'.$fadeout_start_effect.'" data-parallax-content="'.$parallax_content.'" data-parallax-content-sense="'.$parallax_content_sense.'" data-row-effect-mobile-disable="'.$disable_on_mobile.'" data-rtl="'.$rtl.'" data-img-parallax-mobile-disable="'.$disable_on_mobile_img_parallax.'" '.$commom_data_attributes.' '.$overlay.' '.$seperator_html.' '.$ult_hide_row_data.' data-video_fixer="'.$video_fixer.'"></div>';
				}
				elseif ($bg_type=='u_iframe') {
					wp_enqueue_script('jquery.ytplayer',get_template_directory_uri() . '/library/inc/crum-vc-ultimate/assets/js/jquery.mb.YTPlayer.min.js');
					$v_opts = explode(",",$video_opts);
					$v_img = wp_get_attachment_image_src($video_poster,'full');
					if(is_array($v_opts)){
						foreach($v_opts as $opt){
							if($opt == "muted") $muted .= $opt;
							if($opt == "autoplay") $autoplay .= $opt;
							if($opt == "loop") $loop .= $opt;
						}
					}
					if($viewport_vdo != '')
						$enable_viewport_vdo = 'true';
					else
						$enable_viewport_vdo = 'false';

					$html .= '<div class="upb_content_iframe"  data-controls="'.$enable_controls.'" data-viewport-video="'.$enable_viewport_vdo.'" data-ultimate-video="'.$u_video_url.'" data-bg-override="'.$bg_override.'" data-start-time="'.$u_start_time.'" data-stop-time="'.$u_stop_time.'" data-ultimate-video-muted="'.$muted.'" data-ultimate-video-loop="'.$loop.'" data-ultimate-video-poster="'.$v_img[0].'" data-upb-overlay-color="'.$overlay_color.'" data-upb-bg-animation="'.$bg_fade.'" data-fadeout="'.$fadeout_row.'" data-fadeout-percentage="'.$fadeout_start_effect.'"  data-parallax-content="'.$parallax_content.'" data-parallax-content-sense="'.$parallax_content_sense.'" data-row-effect-mobile-disable="'.$disable_on_mobile.'" data-img-parallax-mobile-disable="'.$disable_on_mobile_img_parallax.'"  data-rtl="'.$rtl.'"></div>';
				}
				elseif ($bg_type == 'grad') {
					$html .= '<div class="upb_grad"   data-grad="'.$bg_grad.'" data-bg-override="'.$bg_override.'" data-upb-overlay-color="'.$overlay_color.'" data-upb-bg-animation="'.$bg_fade.'" data-fadeout="'.$fadeout_row.'" data-fadeout-percentage="'.$fadeout_start_effect.'" data-parallax-content="'.$parallax_content.'" data-parallax-content-sense="'.$parallax_content_sense.'" data-row-effect-mobile-disable="'.$disable_on_mobile.'" data-img-parallax-mobile-disable="'.$disable_on_mobile_img_parallax.'"  data-rtl="'.$rtl.'"></div>';
				}
				elseif($bg_type == 'bg_color'){
					$html .= '<div class="upb_color"   data-bg-override="'.$bg_override.'" data-bg-color="'.$bg_color_value.'" data-fadeout="'.$fadeout_row.'" data-fadeout-percentage="'.$fadeout_start_effect.'" data-parallax-content="'.$parallax_content.'" data-parallax-content-sense="'.$parallax_content_sense.'" data-row-effect-mobile-disable="'.$disable_on_mobile.'" data-img-parallax-mobile-disable="'.$disable_on_mobile_img_parallax.'"  data-rtl="'.$rtl.'"></div>';
				}
				$output .= $html;
				if($bg_type=='no_bg'){
					return $output;
				}else{
					self::front_scripts();
					return $output;
				}
			}
		} /* end parallax_shortcode */
		function parallax_init(){
			$group_name = 'Background';
			$group_effects = 'Effect';
			if(function_exists('vc_remove_param')){
				//vc_remove_param('vc_row','bg_image');
				vc_remove_param('vc_row','bg_image_repeat');
			}
			if(function_exists('vc_add_param')){
				vc_add_param('vc_row',array(
						"type" => "dropdown",
						"class" => "",
						"admin_label" => true,
						"heading" => __("Background Style", "crum"),
						"param_name" => "bg_type",
						"value" => array(
							__("Default","crum") => "no_bg",
							__("Single Color","crum") => "bg_color",
							__("Gradient Color","crum") => "grad",
							__("Image / Parallax","crum") => "image",
							__("YouTube Video","crum") => "u_iframe",
							__("Hosted Video","crum") => "video",
							//__("Animated Background","crum") => "animated",
							//__("No","crum") => "no_bg",
						),
						"description" => __("Select the kind of background would you like to set for this row. Not sure? See Narrated <a href='https://www.youtube.com/watch?v=Qxs8R-uaMWk&list=PL1kzJGWGPrW981u5caHy6Kc9I1bG1POOx' target='_blank'>Video Tutorials</a>", "crum"),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "gradient",
						"class" => "",
						"heading" => __("Gradient Background", "crum"),
						"param_name" => "bg_grad",
						"description" => __('At least two color points should be selected. <a href="https://www.youtube.com/watch?v=yE1M4AKwS44" target="_blank">Video Tutorial</a>', "crum"),
						"dependency" => array("element" => "bg_type","value" => array("grad")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "colorpicker",
						"class" => "",
						"heading" => __("Background Color", "crum"),
						"param_name" => "bg_color_value",
						//"description" => __('At least two color points should be selected. <a href="https://www.youtube.com/watch?v=yE1M4AKwS44" target="_blank">Video Tutorial</a>', "crum"),
						"dependency" => array("element" => "bg_type","value" => array("bg_color")),
						"group" => $group_name,
					)
				);
				vc_add_param("vc_row", array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Parallax Style","ultimate_vc"),
					"param_name" => "parallax_style",
					"value" => array(
						__("No Parallax","ultimate_vc") => "",
						__("Simple Background Image","ultimate_vc") => "vcpb-default",
						__("Auto Moving Background","ultimate_vc") => "vcpb-animated",
						__("Vertical Parallax On Scroll","ultimate_vc") => "vcpb-vz-jquery",
						__("Horizontal Parallax On Scroll","ultimate_vc") => "vcpb-hz-jquery",
						__("Interactive Parallax On Mouse Hover","ultimate_vc") => "vcpb-fs-jquery",
						//__("Multilayer Vertical Parallax","ultimate_vc") => "vcpb-mlvp-jquery",
					),
					"description" => __("Select the kind of style you like for the background.","ultimate_vc"),
					"dependency" => array("element" => "bg_type","value" => array("image")),
					"group" => $group_name,
				));
				vc_add_param('vc_row',array(
						"type" => "attach_image",
						"class" => "",
						"heading" => __("Background Image", "crum"),
						"param_name" => "bg_image_new",
						"value" => "",
						"description" => __("Upload or select background image from media gallery.", "crum"),
						"dependency" => array("element" => "parallax_style","value" => array("vcpb-default","vcpb-animated","vcpb-vz-jquery","vcpb-hz-jquery",)),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "attach_images",
						"class" => "",
						"heading" => __("Layer Images", "crum"),
						"param_name" => "layer_image",
						"value" => "",
						"description" => __("Upload or select background images from media gallery.", "crum"),
						"dependency" => array("element" => "parallax_style","value" => array("vcpb-fs-jquery","vcpb-mlvp-jquery")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Background Image Repeat", "crum"),
						"param_name" => "bg_image_repeat",
						"value" => array(
							__("No Repeat", "crum") => "no-repeat",
							__("Repeat", "crum") => "repeat",
							__("Repeat X", "crum") => "repeat-x",
							__("Repeat Y", "crum") => "repeat-y",
						),
						"description" => __("Options to control repeatation of the background image. Learn on <a href='http://www.w3schools.com/cssref/playit.asp?filename=playcss_background-repeat' target='_blank'>W3School</a>", "crum"),
						"dependency" => Array("element" => "parallax_style","value" => array("vcpb-default","vcpb-fix","vcpb-vz-jquery","vcpb-hz-jquery")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Scroll Effect", "ultimate_vc"),
						"param_name" => "bg_img_attach",
						"value" => array(
							__("Move with the content", "ultimate_vc") => "",
							__("Fixed at its position", "ultimate_vc") => "fixed",
						),
						"description" => __("Options to set whether a background image is fixed or scroll with the rest of the page.", "ultimate_vc"),
						"dependency" => Array("element" => "parallax_style","value" => array("vcpb-vz-jquery")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Background Image Size", "crum"),
						"param_name" => "bg_image_size",
						"value" => array(
							__("Cover - Image to be as large as possible", "crum") => "cover",
							__("Contain - Image will try to fit inside the container area", "crum") => "contain",
							__("Initial", "crum") => "initial",
							/*__("Automatic", "crum") => "automatic", */
						),
						"description" => __("Options to control size of the background image. Learn on <a href='http://www.w3schools.com/cssref/playit.asp?filename=playcss_background-size&preval=50%25' target='_blank'>W3School</a>", "crum"),
						"dependency" => Array("element" => "parallax_style","value" => array("vcpb-default","vcpb-animated","vcpb-fix","vcpb-vz-jquery","vcpb-hz-jquery")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Custom Background Image Size", "crum"),
						"param_name" => "bg_cstm_size",
						"value" =>"",
						"description" => __("You can use initial, inherit or any number with px, em, %, etc. Example- 100px 100px", "crum"),
						"dependency" => Array("element" => "bg_image_size","value" => array("cstm")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "number",
						"class" => "",
						"heading" => __("Parallax Speed", "crum"),
						"param_name" => "parallax_sense",
						"value" =>"30",
						"min"=>"1",
						"max"=>"100",
						"description" => __("Control speed of parallax. Enter value between 1 to 100", "crum"),
						"dependency" => Array("element" => "parallax_style","value" => array("vcpb-vz-jquery","vcpb-animated","vcpb-hz-jquery","vcpb-vs-jquery","vcpb-hs-jquery","vcpb-fs-jquery","vcpb-mlvp-jquery")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Background Image Posiiton", "crum"),
						"param_name" => "bg_image_posiiton",
						"value" =>"",
						"description" => __("You can use any number with px, em, %, etc. Example- 100px 100px.", "crum"),
						"dependency" => Array("element" => "parallax_style","value" => array("vcpb-default","vcpb-fix")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Animation Direction", "ultimate_vc"),
						"param_name" => "animation_direction",
						"value" => array(
							__("Left to Right", "ultimate_vc") => "",
							__("Right to Left", "ultimate_vc") => "right-animation",
							__("Top to Bottom", "ultimate_vc") => "top-animation",
							__("Bottom to Top", "ultimate_vc") => "bottom-animation",

						),
						"dependency" => Array("element" => "parallax_style","value" => array("vcpb-animated")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Animation Type", "crum"),
						"param_name" => "animation_type",
						"value" => array(
							__("Horizontal", "crum") => "h",
							__("Vertical", "crum") => "v",
						),
						"dependency" => Array("element" => "parallax_style","value" => array("vcpb-animated")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Animation Direction", "crum"),
						"param_name" => "horizontal_animation",
						"value" => array(
							__("Left to Right", "crum") => "left-animation",
							__("Right to Left", "crum") => "right-animation",
						),
						"dependency" => Array("element" => "animation_type","value" => array("h")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Animation Direction", "crum"),
						"param_name" => "vertical_animation",
						"value" => array(
							__("Top to Bottom", "crum") => "top-animation",
							__("Bottom to Top", "crum") => "bottom-animation",
						),
						"dependency" => Array("element" => "animation_type","value" => array("v")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Background Repeat", "crum"),
						"param_name" => "animation_repeat",
						"value" => array(
							__("Repeat", "crum") => "repeat",
							__("Repeat X", "crum") => "repeat-x",
							__("Repeat Y", "crum") => "repeat-y",
						),
						"dependency" => Array("element" => "parallax_style","value" => array("vcpb-animated")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Link to the video in MP4 Format", "crum"),
						"param_name" => "video_url",
						"value" => "",
						"dependency" => Array("element" => "bg_type","value" => array("video")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Link to the video in WebM / Ogg Format", "crum"),
						"param_name" => "video_url_2",
						"value" => "",
						"description" => __("IE, Chrome & Safari <a href='http://www.w3schools.com/html/html5_video.asp' target='_blank'>support</a> MP4 format, while Firefox & Opera prefer WebM / Ogg formats. You can upload the video through <a href='".home_url()."/wp-admin/media-new.php' target='_blank'>WordPress Media Library</a>.", "crum"),
						"dependency" => Array("element" => "bg_type","value" => array("video")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Enter YouTube URL of the Video", "crum"),
						"param_name" => "u_video_url",
						"value" => "",
						"description" => __("Enter YouTube url. Example - YouTube (https://www.youtube.com/watch?v=tSqJIIcxKZM) ", "crum"),
						"dependency" => Array("element" => "bg_type","value" => array("u_iframe")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "checkbox",
						"class" => "",
						"heading" => __("Extra Options", "crum"),
						"param_name" => "video_opts",
						"value" => array(
							__("Loop","crum") => "loop",
							__("Muted","crum") => "muted",
						),
						/*"description" => __("Select options for the video.", "crum"),*/
						"dependency" => Array("element" => "bg_type","value" => array("video","u_iframe")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "attach_image",
						"class" => "",
						"heading" => __("Placeholder Image", "crum"),
						"param_name" => "video_poster",
						"value" => "",
						"description" => __("Placeholder image is displayed in case background videos are restricted (Ex - on iOS devices).", "crum"),
						"dependency" => Array("element" => "bg_type","value" => array("video","u_iframe")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "number",
						"class" => "",
						"heading" => __("Start Time", "crum"),
						"param_name" => "u_start_time",
						"value" => "",
						"suffix" => "seconds",
						/*"description" => __("Enter time in seconds from where video start to play.", "crum"),*/
						"dependency" => Array("element" => "bg_type","value" => array("u_iframe")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "number",
						"class" => "",
						"heading" => __("Stop Time", "crum"),
						"param_name" => "u_stop_time",
						"value" => "",
						"suffix" => "seconds",
						"description" => __("You may start / stop the video at any point you would like.", "crum"),
						"dependency" => Array("element" => "bg_type","value" => array("u_iframe")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "checkbox",
						"class" => "",
						"heading" => __("Play video only when in viewport", "crum"),
						"param_name" => "viewport_vdo",
						//"admin_label" => true,
						"value" => array( "Yes, please" => "true" ),
						"description" => __("Video will be played only when user is on the particular screen position. Once user scroll away, the video will pause.", "crum"),
						"dependency" => Array("element" => "bg_type","value" => array("video","u_iframe")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "checkbox",
						"class" => "",
						"heading" => __("Display Controls", "crum"),
						"param_name" => "enable_controls",
						//"admin_label" => true,
						"value" => array( "Yes, please" => "display_control" ),
						"description" => __("Display play / pause controls for the video on bottom right position.", "crum"),
						"dependency" => Array("element" => "bg_type","value" => array("video")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "colorpicker",
						"class" => "",
						"heading" => __("Color of Controls Icon", "crum"),
						"param_name" => "controls_color",
						//"admin_label" => true,
						//"description" => __("Display play / pause controls for the video on bottom right position.", "crum"),
						"dependency" => Array("element" => "enable_controls","value" => array("display_control")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "checkbox",
						"class" => "",
						"heading" => __("Easy Parallax", "crum"),
						"param_name" => "parallax_content",
						//"admin_label" => true,
						"value" => array( "Yes, please" => "parallax_content_value" ),
						"group" => $group_effects,
						"description" => __("If enabled, the elements inside row - will move slowly as user scrolls.", "crum")
					)
				);
				vc_add_param('vc_row',array(
						"type" => "textfield",
						"class" => "",
						"heading" => __("Parallax Speed", "crum"),
						"param_name" => "parallax_content_sense",
						//"admin_label" => true,
						"value" => "30",
						"group" => $group_effects,
						"description" => __("Enter value between 0 to 100", "crum")
					)
				);
				vc_add_param('vc_row',array(
						"type" => "checkbox",
						"class" => "",
						"heading" => __("Extra Effect", "crum"),
						"param_name" => "fadeout_row",
						//"admin_label" => true,
						"value" => array( "Yes, please" => "fadeout_row_value" ),
						"group" => $group_effects,
						"description" => __("If enabled, the the content inside row will fade out slowly as user scrolls down.", "crum")
					)
				);
				vc_add_param('vc_row',array(
						"type" => "number",
						"class" => "",
						"heading" => __("Viewport Position", "crum"),
						"param_name" => "fadeout_start_effect",
						"suffix" => "%",
						//"admin_label" => true,
						"value" => "30",
						"group" => $group_effects,
						"description" => __("The area of screen from top where fade out effect will take effect once the row is completely inside that area.", "crum"),
					)
				);
				vc_add_param('vc_row',array(
						"type" => "checkbox",
						"class" => "",
						"heading" => __("Activate on Mobile", "crum"),
						"param_name" => "disable_on_mobile",
						//"admin_label" => true,
						"value" => array( "Yes, please" => "enable_on_mobile_value" ),
						"group" => $group_effects,

					)
				);
                /*
				vc_add_param('vc_row',array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Show Background Overlay", "crum"),
						"param_name" => "overlay_set",
						"value" => array(
							"Hide"=>"overlay_hide",
							"Show"=>"overlay_show",
							),
						"description" => __("Hide or Show overlay on background images.", "crum"),
						"dependency" => Array("element" => "bg_type","value" => array("image","video","grad")),
                        "group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "colorpicker",
						"class" => "",
						"heading" => __("Overlay Color", "crum"),
						"param_name" => "overlay_color",
						"value" => "",
						"description" => __("Select color for background overlay.", "crum"),
						"dependency" => Array("element" => "overlay_set","value" => array("overlay_show")),
                        "group" => $group_name,
					)
				);
                */
				vc_add_param('vc_row',array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __("Background Override (Read Description)", "crum"),
						"param_name" => "bg_override",
						"value" =>array(
							"Default Width"=>"0",
							"Full Width "=>"full",
							"Browser Full Dimension"=>"browser_size"
						),
						"description" => __("By default, the background will be given to the Visual Composer row. However, in some cases depending on your theme's CSS - it may not fit well to the container you are wishing it would. In that case you will have to select the appropriate value here that gets you desired output..", "crum"),
						"dependency" => Array("element" => "bg_type","value" => array("u_iframe","image","video","grad","bg_color","animated")),
						"group" => $group_name,
					)
				);
				vc_add_param('vc_row',array(
						"type" => "checkbox",
						"class" => "",
						"heading" => __("Disable Parallax on Mobile", "crum"),
						"param_name" => "disable_on_mobile_img_parallax",
						//"admin_label" => true,
						"value" => array( "Yes, please" => "disable_on_mobile_img_parallax_value" ),
						"group" => $group_name,
						"dependency" => Array("element" => "parallax_style","value" => array("vcpb-animated","vcpb-vz-jquery","vcpb-hz-jquery","vcpb-fs-jquery","vcpb-mlvp-jquery")),
					)
				);
			}
		} /* parallax_init*/
		function gradient_picker($settings, $value)
		{
			$dependency = vc_generate_dependencies_attributes($settings);
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$color1 = isset($settings['color1']) ? $settings['color1'] : ' ';
			$color2 = isset($settings['color2']) ? $settings['color2'] : ' ';
			$class = isset($settings['class']) ? $settings['class'] : '';
			$uni = uniqid();
			$output = '<div class="vc_ug_control" data-uniqid="'.$uni.'" data-color1="'.$color1.'" data-color2="'.$color2.'">
						<div class="grad_trgt" id="grad_target'.$uni.'"></div>
						<div class="grad_hold" id="grad_hold'.$uni.'"></div>';
			$output .= '<input id="grad_val'.$uni.'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . ' vc_ug_gradient" name="' . $param_name . '"  style="display:none"  value="'.$value.'" '.$dependency.'/></div>';
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					function gradient_pre_defined(){
						jQuery('.vc_ug_control').each(function(){
							var uni = jQuery(this).data('uniqid');
							var hid = "#grad_hold"+uni;
							var did = "#grad_target"+uni;
							var tid = "#grad_val"+uni;
							var prev_col = jQuery(tid).val();
							if(prev_col!=''){
								var p_l = prev_col.indexOf('-webkit-linear-gradient(top,');
								prev_col = prev_col.substring(p_l+28);
								p_l = prev_col.indexOf(');');
								prev_col = prev_col.substring(0,p_l);
							}else{
								prev_col ="#fbfbfb 0%, #e3e3e3 50%, #c2c2c2 100%";
								//prev_col ="";
							}
							jQuery(hid).ClassyGradient({
								target:did,
								gradient: prev_col,
								onChange: function(stringGradient,cssGradient) {
									cssGradient = cssGradient.replace('url(data:image/svg+xml;base64,','');
									var e_pos = cssGradient.indexOf(';');
									cssGradient = cssGradient.substring(e_pos+1);
									if(jQuery(tid).parents('.wpb_el_type_gradient').css('display')=='none'){
										//jQuery(tid).val('');
										cssGradient='';
									}
									jQuery(tid).val(cssGradient);
								},
								onInit: function(){
									//console.log(jQuery(tid).val())
								}
							});
							jQuery('.colorpicker').css('z-index','999999');
						})
					}
					gradient_pre_defined();
				})
			</script>
			<?php
			return $output;
		}
		function number_settings_field($settings, $value)
		{
			$dependency = vc_generate_dependencies_attributes($settings);
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$min = isset($settings['min']) ? $settings['min'] : '';
			$max = isset($settings['max']) ? $settings['max'] : '';
			$suffix = isset($settings['suffix']) ? $settings['suffix'] : '';
			$class = isset($settings['class']) ? $settings['class'] : '';
			$output = '<input type="number" min="'.$min.'" max="'.$max.'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.$value.'" style="max-width:100px; margin-right: 10px;" />'.$suffix;
			return $output;
		}
		function admin_scripts($hook){
			if($hook == "post.php" || $hook == "post-new.php"){
				wp_enqueue_script('jquery.colorpicker',get_template_directory_uri().'/library/inc/crum-vc-ultimate/admin/js/jquery.colorpicker.js','1.0',array('jQuery'),true);
				wp_enqueue_script('jquery.classygradient',get_template_directory_uri().'/library/inc/crum-vc-ultimate/admin/js/jquery.classygradient.min.js','1.0',array('jQuery'),true);
				wp_enqueue_style('gradient-colorpicker',get_template_directory_uri().'/library/inc/crum-vc-ultimate/admin/css/jquery.colorpicker.css');
				wp_enqueue_style('classygradient.style',get_template_directory_uri().'/library/inc/crum-vc-ultimate/admin/css/jquery.classygradient.min.css');
			}
		}/* end admin_scripts */
		static function front_scripts(){
			//wp_enqueue_script('jquery.shake',get_template_directory_uri().'/library/inc/crum-vc-ultimate/assets/js/jparallax.js','1.0',array('jQuery'),true);
			//wp_enqueue_script('jquery.vhparallax',get_template_directory_uri().'/library/inc/crum-vc-ultimate/assets/js/jquery.vhparallax.js','1.0',array('jQuery'),true);
		} /* end front_scripts */
	}
	new VC_Ultimate_Parallax;
}

if (!function_exists('vc_theme_after_vc_row')) {
    function vc_theme_after_vc_row($atts, $content = null)
    {
        return VC_Ultimate_Parallax::parallax_shortcode($atts, $content);
    }
}
