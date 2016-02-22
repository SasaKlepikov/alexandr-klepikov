<?php
if ( ! class_exists( 'Crum_Simple_Timeline' ) ) {

	class Crum_Simple_Timeline {

		function __construct() {
			add_action( 'admin_init', array( &$this, 'simple_timeline_init' ) );
			add_shortcode( 'crum_simple_timeline', array( &$this, 'simple_timeline_form' ) );
			add_shortcode( 'crum_simple_timeline_item', array( &$this, 'simple_timeline_item_form' ) );
		}

		function simple_timeline_init() {
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => __( "Simple timeline", "crum" ),
						"base"                    => "crum_simple_timeline",
						"class"                   => "",
						"icon"                    => "vc_timeline_icon",
						"category"                => __( "Presentation", "crum" ),
						"as_parent"               => array( 'only' => 'crum_simple_timeline_item' ),
						"content_element"         => true,
						"show_settings_on_create" => false,
						"params"                  => array(
							array(
								"type"        => "dropdown",
								"heading"     => __( "Select style of displaying", "crum" ),
								"param_name"  => "displaying_type",
								"admin_label" => true,
								"value"       => array(
									'1 Column'  => '1_column',
									'2 Columns' => '2_column',
								),
								"group"       => "General",
								"description" => __( "Select, style of displaying", "crum" )
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
								"group" => "Animation settings"
							),
						),

						"js_view"                 => 'VcColumnView'
					)
				);
				vc_map(
					array(
						"name"            => __( "Simple timeline item", 'crum' ),
						"base"            => "crum_simple_timeline_item",
						"class"           => "",
						"icon"            => "vc_timeline_sep_icon",
						"category"        => __( 'Timeline', 'crum' ),
						"content_element" => true,
						"as_child"        => array( 'only' => 'crum_simple_timeline' ),
						"params"          => array(
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( "Item type", "crum" ),
								"param_name"  => "item_type",
								"value"       => array(
									__( "Simple", "crum" )       => "simple",
									__( "Advanced", "crum" )             => "advanced",
								),
								"description" => __( "Minimal or advanced set of item options", "crum" ),
							),
							array(
								"type"       => "checkbox",
								"heading"    => __( "", "crum" ),
								"param_name" => "description_hide",
								"value"      => array( "Hide description block of item" => "disable" ),
								"group"       => "",
							),
							array(
								"type"        => "textfield",
								"class"       => "",
								"heading"     => __( "Title", "crum" ),
								"param_name"  => "simple_timeline_item_title",
								"admin_label" => true,
								"value"       => "",
							),
                            array(
                                "type"        => "textfield",
                                "class"       => "",
                                "heading"     => __( "Subtitle", "crum" ),
                                "param_name"  => "item_subtitle",
                                "admin_label" => true,
                                "value"       => "",
                            ),
							array(
								"type"        => "icon_manager",
								"class"       => "",
								"heading"     => __( "Select Icon ", "crum" ),
								"param_name"  => "simple_timeline_item_icon",
								"value"       => "",
								"description" => __( "Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=Font_Icon_Manager' target='_blank'>add new here</a>.", "crum" ),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Thumbnail Icon Background Color", "crum"),
								"param_name" => "icon_bg_color",
								"value" => "",
								"description" => __("Select the color for icon background.", "crum"),
								"dependency" => array("element" => "item_type", "value" => "advanced"),
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Thumbnail Icon Color", "crum"),
								"param_name" => "icon_color",
								"value" => "",
								"description" => __("Select the color for icon.", "crum"),
								"dependency" => array("element" => "item_type", "value" => "advanced"),
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => __("Thumbnail Icon Border Style", "crum"),
								"param_name" => "icon_br_style",
								"value" => array(
									"None" => "none",
									"Solid"	=> "solid",
									"Dashed" => "dashed",
									"Dotted" => "dotted",
									"Double" => "double",
									"Inset" => "inset",
									"Outset" => "outset",
								),
								"dependency" => array("element" => "item_type", "value" => "advanced"),
								//"description" => __("Select the border style for icon.","crum"),
							),
							array(
								"type" => "number",
								"class" => "",
								"heading" => __("Thumbnail Icon Border Thickness", "crum"),
								"param_name" => "icon_br_width",
								"value" => 1,
								"min" => 0,
								"max" => 10,
								"suffix" => "px",
								//"description" => __("Thickness of the border.", "crum"),
								"dependency" => Array("element" => "icon_br_style","value" => array("solid","dashed","dotted","double","inset","outset")),
							),

							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Thumbnail Icon Border Color", "crum"),
								"param_name" => "icon_border_color",
								"value" => "",
								//"description" => __("Select the color border.", "crum"),
								"dependency" => Array("element" => "icon_br_style","value" => array("solid","dashed","dotted","double","inset","outset")),
							),
							array(
								"type"        => "textarea_html",
								"class"       => "",
								"heading"     => __( "Description", "crum" ),
								"param_name"  => "content",
								"admin_label" => true,
								"value"       => "",
								"description" => __( "Provide some description.", "crum" ),
							),
						)
					)
				);
			}
		}

		function simple_timeline_form( $atts, $content = null ) {

			$module_animation = $displaying_type = '';

			extract(shortcode_atts(
				array(
					"module_animation" => "",
					"displaying_type" => '',
				),$atts
			));

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-item = ".cd-timeline-block" data-animate-type = "'.$module_animation.'" ';
			}



			$output = '';

			$output .= '<section id="cd-timeline" class="'.$displaying_type.' cd-container '.$animate.'" '.$animation_data.'>';
			$output .= do_shortcode( $content );
			$output .= '</section>';
            $output .= "<script type='text/javascript'>
jQuery(document).ready(function($){
var timeline_block = $('.cd-timeline-block');
timeline_block.each(function(){
if($(this).offset().top > $(window).scrollTop()+$(window).height()*0.75) {
$(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');
}
});
	$(window).on('scroll', function(){
		timeline_block.each(function(){
			if( $(this).offset().top <= $(window).scrollTop()+$(window).height()*0.75 && $(this).find('.cd-timeline-img').hasClass('is-hidden') ) {
				$(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
			}
		});
	});
});
</script>";

			return $output;
		}

		function simple_timeline_item_form( $atts, $content = null ) {

			$simple_timeline_item_title = $simple_timeline_item_icon_type = $simple_timeline_item_icon = $simple_timeline_item_icon_img = $item_subtitle = '';

			$item_type = $description_hide = $icon_bg_color = $icon_br_style = $icon_color =  $icon_br_width = $icon_border_color = '';

			extract( shortcode_atts( array(
				'simple_timeline_item_title'     => '',
				'item_type' => '',
				'description_hide' => '',
                'item_subtitle' => '',
				'simple_timeline_item_icon_type' => '',
				'simple_timeline_item_icon'      => '',
				'icon_bg_color' => '',
				'icon_color' => '',
				'icon_br_style' => 'none',
				'icon_br_width' => '',
				'icon_border_color' => '',
				'simple_timeline_item_icon_img'  => ''

			), $atts ) );

			$style = '';

			if($icon_bg_color!=''){
				$style .='background:'.$icon_bg_color.';';
			}
			if($icon_color!=''){
				$style .='color:'.$icon_color.';';
			}

			if($icon_br_style!='none' && $icon_br_width!='' && $icon_border_color!=''){
				$style.='border-style:'.$icon_br_style.';';
				$style.='border-width:'.$icon_br_width.'px;';
				$style.='border-color:'.$icon_border_color.';';
			}

			$output = '';

			$output .= '<div class="cd-timeline-block">';

			$output .= '<div class="cd-timeline-img cd-picture" >';
			$output .= '<i class="' . $simple_timeline_item_icon . '" style="'.$style.'"></i>';

			$output .= '</div>';

			if ( ($description_hide == 'disable') ) {
                $hide_description = 'is-hidden';
            }else{
                $hide_description = '';
            }
				$output .= '<h4 class="cd-date '.$hide_description.'">' . $simple_timeline_item_title;
				if ( $item_subtitle ) {
					$output .= '<span class="item-subtitle">' . $item_subtitle . '</span>';
				}
				$output .= '</h4>';
				$output .= '<div class="cd-timeline-content '.$hide_description.'">';
				$output .= $content;

				$output .= '</div>';


			$output .= '</div>';

			return $output;

		}
	}

}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_crum_simple_timeline extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_crum_simple_timeline_item extends WPBakeryShortCode {
	}
}

if ( class_exists( 'Crum_Simple_Timeline' ) ) {
	$Crum_Simple_Timeline = new Crum_Simple_Timeline;
}