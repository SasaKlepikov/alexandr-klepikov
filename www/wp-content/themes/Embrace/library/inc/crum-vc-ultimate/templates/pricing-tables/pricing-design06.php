<?php
/*
* Add-on Name: Stats Counter for Visual Composer
* Template : Design layout 06
*/
if(class_exists("Ultimate_Pricing_Table")){
	class Pricing_Design06 extends Ultimate_Pricing_Table{
		public static function generate_design($atts,$content = null){
			$package_heading = $package_sub_heading = $package_price = $package_unit = $package_btn_text = $package_link = $package_featured = $color_bg_main = $color_txt_main = $color_bg_highlight = $color_txt_highlight = $color_scheme = $module_animation = $package_recommended = $heading_color = $button_color = '';
			extract(shortcode_atts(array(
				"color_scheme" => "",
				"package_heading" => "",
				"package_sub_heading" => "",
				"package_price" => "",
				"package_unit" => "",
				"package_btn_text" => "",
				"package_link" => "",
				"package_featured" => "",
				"color_bg_main" => "",
				"color_txt_main" => "",
				"color_bg_highlight" => "",
				"color_txt_highlight" => "",
                "package_recommended" => "",
				"module_animation" => "",
                "button_color" => "",
                "heading_color" => ""
			),$atts));
			$output = $link = $target = $featured = $featured_style = $normal_style = $dynamic_style = '';
			if($color_scheme == "custom"){
				if($color_bg_main !== ""){
					$normal_style .= 'background:'.$color_bg_main.';';
				}
				if($color_txt_main !== ""){
					$normal_style .= 'color:'.$color_txt_main.';';
				}
				if($color_bg_highlight!== ""){
					$featured_style .= 'background:'.$color_bg_highlight.';';
				}
				if($color_txt_highlight !== ""){
					$featured_style .= 'color:'.$color_txt_highlight.';';
				}
			}
			if($package_link !== ""){
				$link = vc_build_link($package_link);
				if(isset($link['target'])){
					$target = 'target="'.$link['target'].'"';
				} else {
					$target = '';
				}
				$link = $link['url'];
			} else {
				$link = "#";
			}
			if($package_featured !== ""){
				$featured = "ult_featured";
			}

            $recommended = '';
            if (!($package_recommended == '') ){
                $recommended = "recommended";
            }

			$animate = $animation_data = '';

            if (!($heading_color == '')) {
                $darker_heading_color = parent::adjustBrightness($heading_color, -26);
                $darker_heading_color = 'box-shadow: 0 5px 5px '.$darker_heading_color.'';
            }else{
                $darker_heading_color = '';
            }

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			if (!($heading_color == '')) {
				$darker_heading_color = parent::adjustBrightness($heading_color, -26);
				$darker_heading_color_1 = '; box-shadow:inset 0 5px 5px '.$darker_heading_color.';';
				$darker_heading_color_2 = 'box-shadow: 3px 3px 3px '.$darker_heading_color.';';
				$body_style = 'style="background-color: '.$heading_color.'"';
				$square_style = 'style="'.$darker_heading_color.'"';
				$button_style = 'style="background-color:'.$button_color.'"';
			}else{
				$body_style = '';
				$square_style = '';
				$button_style = '';
			}

			$output .= '<div class="ult_pricing_table_wrap '.$animate.' ult_design_6 '.$featured.' '.$recommended.' ult-cs-'.$color_scheme.'" '.$animation_data.'>';

            if (!($package_recommended == '')){
                $output .= ' <div class="ribbon-wrapper-green"><div class="ribbon-green">Recommended</div></div>';
            }

			$output .= '<div class="ult_pricing_table">';
				
				$output .= '<div class="ult_pricing_heading">
								<h3>'.$package_heading.'</h3>';
							if($package_sub_heading !== ''){
								$output .= '<h5>'.$package_sub_heading.'</h5>';
							}
				$output .= '</div><!--ult_pricing_heading-->';
					
				$output .= '<div class="ult_price_body_block" '.$body_style.'>
                                <div class="oval" '.$square_style.' ></div>
								<div class="ult_price_body" >
									<div class="ult_price">
										<span class="ult_price_figure">'.$package_price.'</span>
										<span class="ult_price_term">'.$package_unit.'</span>
									</div>
								</div>
							</div><!--ult_price_body_block-->';
					
				$output .= '<div class="ult_price_features">
								'.wpb_js_remove_wpautop(do_shortcode($content), true).'
							</div><!--ult_price_features-->';
		
				$output .= '<div class="ult_price_link">
								<a href="'.$link.'" '.$target.' class="button" '.$button_style.'>'.$package_btn_text.'</a>
							</div><!--ult_price_link-->';

				$output .= '<div class="ult_clr"></div>
				</div><!--pricing_table-->
			</div><!--pricing_table_wrap-->';
			return $output;
		}
	}
}