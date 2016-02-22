<?php
if ( ! class_exists( 'Crum_Social_Buttons' ) ) {
	class Crum_Social_Buttons {
		function __construct() {
			add_shortcode( 'social_buttons', array( &$this, 'crum_social_buttons_form' ) );
			add_action( 'admin_init', array( &$this, 'crum_social_buttons_init' ) );
		}

		function crum_social_buttons_form( $atts ) {
			wp_enqueue_script( 'custom-share' );
			$facebook = $twitter = $googleplus = $pinterest = $module_animation = '';
			extract(
				shortcode_atts(
					array(
						"facebook"   => false,
						"twitter"    => false,
						"googleplus" => false,
						"pinterest"  => false,
						"module_animation" => '',
					), $atts
				)
			);

			global $post;

			$url = get_permalink( $post->ID );

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-item = ".soc-but-animate" data-animate-type = "'.$module_animation.'" ';
			}

			$shortcode_html = '<div id="social-share" class="'.$animate.'" data-directory="' . get_template_directory_uri() . '" '.$animation_data.'>';

			if ( $facebook ):
				$shortcode_html .= '<span id="cr-facebook-share" class="soc-but-animate" data-url="' . $url . '" data-text="' . get_the_title() . '" data-title="share"></span>';
			endif;
			if ( $twitter ):
				$shortcode_html .= '<span id="cr-twitter-share" class="soc-but-animate" data-url="' . $url . '" data-text="' . get_the_title() . '" data-title="share"></span>';
			endif;
			if ( $googleplus ):
				$shortcode_html .= '<span id="cr-google-share" class="soc-but-animate" data-url="' . $url . '" data-text="' . get_the_title() . '" data-title="share">
				<a href="#"><i class="soc-icon soc-google"></i></a></span>';
			endif;
			if ( $pinterest ):
				$shortcode_html .= '<span id="cr-pinterest-share" class="soc-but-animate" data-url="' . $url . '" data-text="' . get_the_title() . '" data-title="share"></span>';
			endif;

			$shortcode_html .= '</div>';

			return $shortcode_html;
		}

		function crum_social_buttons_init() {
			if ( function_exists( 'vc_map' ) ) {

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name"        => __( "Social Buttons", "crum" ),
						"base"        => "social_buttons",
						"icon"        => "icon-wpb-social-buttons",
						"category"    => __( 'Presentation', 'crum' ),
						"description" => __( 'Add social buttons to any page', 'crum' ),
						"params"      => array(
							array(
								"type"        => 'checkbox',
								"heading"     => __( "Facebook", "crum" ),
								"param_name"  => "facebook",
								"admin_label" => true,
								"group"       => $group,
								"value"       => Array( __( "Yes", "crum" ) => 'true' )
							),
							array(
								"type"        => 'checkbox',
								"heading"     => __( "Twitter", "crum" ),
								"param_name"  => "twitter",
								"admin_label" => true,
								"group"       => $group,
								"value"       => Array( __( "Yes", "crum" ) => 'true' )
							),
							array(
								"type"        => 'checkbox',
								"heading"     => __( "Google +", "crum" ),
								"param_name"  => "googleplus",
								"admin_label" => true,
								"group"       => $group,
								"value"       => Array( __( "Yes", "crum" ) => 'true' )
							),
							array(
								"type"        => 'checkbox',
								"heading"     => __( "Pinterest", "crum" ),
								"param_name"  => "pinterest",
								"admin_label" => true,
								"group"       => $group,
								"value"       => Array( __( "Yes", "crum" ) => 'true' )
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

	new Crum_Social_Buttons;
}