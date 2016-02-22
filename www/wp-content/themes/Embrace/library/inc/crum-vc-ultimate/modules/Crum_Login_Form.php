<?php
if ( ! class_exists( 'Crum_Login_Form' ) ) {
	class Crum_Login_Form {
		function __construct() {
			add_shortcode( 'sign_in_form', array( &$this, 'crum_login_form' ) );
			add_action( 'admin_init', array( &$this, 'crum_login_init' ) );
		}

		function crum_login_form( $atts ) {
			$redirect = $module_animation = '';
			extract(
				shortcode_atts(
					array(
						'redirect' => '', // redirect after login
						'module_animation' => '',
					), $atts
				)
			);

			$args = array(
				'echo'     => false,
				'remember' => false,
				'redirect' => $redirect
			);

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = 'cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			$output = '<div class="'.$animate.'" '.$animation_data.'>';

			$output .= wp_login_form( $args );

			$output .= '</div>';

			return $output;
		}

		function crum_login_init() {
			if ( function_exists( 'vc_map' ) ) {

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name"        => __( "Login form", "crum" ),
						"base"        => "sign_in_form",
						"icon"        => "icon-wpb-login",
						"category"    => __( 'Presentation', 'crum' ),
						"description" => __( 'Standart wordpress login form', 'crum' ),
						"params"      => array(
							array(
								"type"        => "textfield",
								"heading"     => __( "Redirect address", "crum" ),
								"param_name"  => "redirect",
								"group"       => $group,
								"description" => __( 'Url of page that user will be redirected after login', "crum" )
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

	new Crum_Login_Form;
}