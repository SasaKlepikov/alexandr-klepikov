<?php
if (!class_exists('Crum_Promo_Image')){

	class Crum_Promo_Image{

		function __construct(){
			add_action('admin_init', array($this, 'crum_promo_image_init'));
			add_action('wp_enqueue_scripts', array($this, 'promo_image_custom_styles') );
			add_shortcode('crum_promo_image', array($this, 'crum_promo_image_form'));
		}

		function promo_image_custom_styles(){
			if ( isset($promo_image_color) && !($promo_image_color == '') ) {
				$border_color = 'figure.effect-layla figcaption::before{style="color:' . $promo_image_color . '"}';
			}else{
				$border_color = '';
			}

			wp_add_inline_style('style', $border_color);
		}

		function crum_promo_image_form($atts, $content = null){

			$promo_image_title = $promo_image_subtitle = $promo_image_img = $promo_image_link = $promo_image_style = $promo_image_color = $module_animation = '';

			extract(
				shortcode_atts(
					array(
						'promo_image_title'=>'',
						'promo_image_subtitle'=>'',
						'promo_image_img'=>'',
						'promo_image_link'=>'',
						'promo_image_style'=>'',
						'promo_image_color'=>'',
						'module_animation' => '',
					),$atts
				)
			);

			$link = vc_build_link($promo_image_link);

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			$output = '';
			$output .= '<div class="promo-container '.$animate.'" '.$animation_data.'>';
			$output .= '<figure class="effect-'.$promo_image_style.'">';
			$output .= wp_get_attachment_image($promo_image_img, 'full');
			$output .= '<figcaption>';
			$output .= '<h2 style="color:'.$promo_image_color.'">'.$promo_image_title.'<span>'.$promo_image_subtitle.'</span>';
			if ($promo_image_style == 'honey'){
				$output .= '<i>'.$content.'</i>';
			}
			$output .= '</h2>';
			if ( !($promo_image_style == 'honey') ) {
				$output .= '<p style="color:'.$promo_image_color.'">' . $content . '</p>';
			}
			$output .= '<a href="'.$link['url'].'"></a>';
			$output .= '</figcaption>';
			$output .= '</figure>';
			$output .= '</div>';

			return $output;
		}

		function crum_promo_image_init(){
			if (function_exists('vc_map')){

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name" => __("Promo Image" , "crum"),
						"base" => "crum_promo_image",
						"class" => "",
						"icon" => "promo_image_icon",
						"category"                => __( "Presentation", "crum" ),
						"description" => __( 'Image with title, subtitle and hover effect', 'crum' ),
						"params" => array(
							array(
								"type"        => "textfield",
								"class"       => "",
								"heading"     => __( "Title", "crum" ),
								"param_name"  => "promo_image_title",
								"admin_label" => true,
								"group"       => $group,
								"value"       => "Title",
							),
							array(
								"type"        => "textfield",
								"class"       => "",
								"heading"     => __( "Subtitle", "crum" ),
								"param_name"  => "promo_image_subtitle",
								"admin_label" => true,
								"group"       => $group,
								"value"       => "Subtitle",
							),
							array(
								"type" => "textarea_html",
								"class" => "",
								"heading" => __("Description", "crum"),
								"param_name" => "content",
								"admin_label" => true,
								"value" => "",
								"group"       => $group,
								"description" => __("Provide some description.", "crum"),
							),
							array(
								"type"        => "attach_image",
								"class"       => "",
								"heading"     => __( "Upload Image:", "crum" ),
								"param_name"  => "promo_image_img",
								"group"       => $group,
								"description" => __( "Upload partner's photo.", "crum" ),
							),
							array(
								"type" => "vc_link",
								"class" => "",
								"heading" => __("Link ","crum"),
								"param_name" => "promo_image_link",
								"value" => "",
								"group"       => $group,
								"description" => __("You can link or remove the existing link on the image from here.","crum"),
							),
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( 'Hover style', 'crum' ),
								"param_name"  => "promo_image_style",
								"value"       => array(
									"Lily"   => "lily",
									"Sadie"   => "sadie",
									"Honey"   => "honey",
									"Layla"   => "layla",
									"Zoe"   => "zoe",
									"Oscar"   => "oscar",
									"Marley"   => "marley",
									"Ruby"   => "ruby",
									"Roxy"   => "roxy",
									"Bubba"   => "bubba",
									"Romeo"   => "romeo",
									"Dexter"   => "dexter",
									"Sarah"   => "sarah",
									"Chico"   => "chico",
									"Milo"   => "milo",
								),
								"group"       => $group,
								"description" => __( 'Please select style of animation on hover', 'crum' )
							),
							array(
								"type" => "colorpicker",
								"class" => "",
								"heading" => __("Color", "crum"),
								"param_name" => "promo_image_color",
								"value" => "",
								"group"       => $group,
								"description" => __("Give it a nice paint!", "crum"),
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
						)
					)
				);
			}
		}
	}

}

if (class_exists('Crum_Promo_Image')){
	$Crum_Promo_Image = new Crum_Promo_Image;
}