<?php
/*
* Add-on Name: Info Tables for Visual Composer
* Template : Design layout 06
*/
if(class_exists("Ultimate_Info_Table")){
	class Info_Design06 extends Ultimate_Info_Table{
		public static function generate_design($atts,$content = null){
			$icon_type = $icon_img = $img_width = $icon = $icon_size  = $el_class = $package_heading = $package_sub_heading = $package_price = $package_unit = $package_btn_text = $package_link = $package_featured = $use_cta_btn = $module_animation = '';
			$button_color = $heading_color =  '';
            extract(shortcode_atts(array(
						'package_heading' => '',
						'package_sub_heading' => '',
						'icon_type' => '',
						'icon' => '',
						'icon_img' => '',
						'img_width' => '',
						'icon_size' => '',
						'use_cta_btn' => '',
						'package_btn_text' => '',
						'package_link' => '',
						'package_featured' => '',
						'module_animation' => '',
                        'button_color' => '',
	                    'heading_color' => '',
					),$atts));
			$output = $link = $target = $featured = $featured_style = $normal_style = $dynamic_style = '';
			if($icon_type !== "none"){
				$box_icon = do_shortcode('[just_icon icon_type="'.$icon_type.'" icon="'.$icon.'" icon_img="'.$icon_img.'" img_width="'.$img_width.'" icon_size="'.$icon_size.'" icon_style="circle"]');
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
			if($use_cta_btn == "box"){
				$output .= '<a href="'.$link.'" '.$target.' class="button" style="'.$featured_style.' background-color:'.$button_color.'">'.$package_btn_text;
			}

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			if (!($heading_color == '')) {
				$darker_heading_color = parent::adjustBrightness($heading_color, -26);
				$darker_heading_color_1 = 'style="background-color: ' . $heading_color . '; "';
				$darker_heading_color_2 = 'style="box-shadow:0 5px 5px '.$darker_heading_color.';"';
			}else{
				$darker_heading_color_1 = '';
				$darker_heading_color_2 = '';

			}

			$output .= '<div class="ult_info_table '.$animate.' ult_design_6 '.$featured.''.$el_class.'" '.$animation_data.'>
						<div class="ult_pricing_table">';
				
				$output .= '<div class="ult_pricing_heading">
								<h3>'.$package_heading.'</h3>';
							if($package_sub_heading !== ''){
								$output .= '<h5>'.$package_sub_heading.'</h5>';
							}
				$output .= '</div><!--ult_pricing_heading-->';


                $output .= '<div class="ult_price_body_block " '.$darker_heading_color_1.'>
                            <div class="oval" '.$darker_heading_color_2.'></div>
                                    <div class="ult_price_body">
                                        <div class="ult_price">
                                            ' . $box_icon .'
                                        </div>
                                    </div>
                                </div><!--ult_price_body_block-->';

					
				$output .= '<div class="ult_price_features">
								'.wpb_js_remove_wpautop(do_shortcode($content), true).'
							</div><!--ult_price_features-->';
		
				if($use_cta_btn == "true"){
					$output .= '<div class="ult_price_link" style="'.$normal_style.'">
								<a href="'.$link.'" '.$target.' class="button" style="'.$featured_style.' background-color:'.$button_color.'">'.$package_btn_text.'</a>
							</div><!--ult_price_link-->';
				}

				$output .= '<div class="ult_clr"></div>
				</div><!--pricing_table-->
			</div><!--pricing_table_wrap-->';
			if($use_cta_btn == "box"){
				$output .= '</a>';
			}
			return $output;
		}
	}
}