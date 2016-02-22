<?php
if ( ! class_exists( 'Crum_QR_Code' ) ) {
	class Crum_QR_Code {
		function __construct() {
			add_shortcode( 'qr_code', array( &$this, 'crum_qr_code_form' ) );
			add_action( 'admin_init', array( &$this, 'crum_qr_init' ) );
		}

		function crum_qr_code_form( $atts ) {

			$content_qr = $width = $height = $module_animation = '';

			extract(
				shortcode_atts(
					array(
						'content_qr' => 'http://crumina.net',
						'width'      => '140',
						'height'     => '140',
						'module_animation' => '',
					), $atts
				)
			);

			$id = uniqid( 'qr_code_' );

			wp_enqueue_script( 'qr-code-js' );

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			$output = '<div id="' . $id . '" class="qr_code '.$animate.'" '.$animation_data.'></div>';

			$output .= '<script type="text/javascript">
			    jQuery(document).ready(function(){
					jQuery(\'#' . $id . '\').qrcode({width: ' . $width . ', height: ' . $height . ',  background: "#ffffff", render: "image", text: "' . $content_qr . '"});
				});
                </script>';

			return $output;
		}

		function crum_qr_init() {
			if ( function_exists( 'vc_map' ) ) {

				$group = __("Main Options", "crum");

				vc_map(
					array(
						"name"        => __( "The QR module", "crum" ),
						"base"        => "qr_code",
						"icon"        => "icon-wpb-qr",
						"category"    => __( 'Presentation', 'crum' ),
						"description" => __( 'Adds the QR code', 'crum' ),
						"params"      => array(
							array(
								"type"        => "textfield",
								"heading"     => __( "Content", "crum" ),
								"param_name"  => "content_qr",
								"group"       => $group,
								"description" => __( 'Text that will be decoded with qr code', "crum" ),
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Width", "crum" ),
								"param_name"  => "width",
								"group"       => $group,
								"description" => __( 'Don\'t enter "px", just the number e.g. "120"', 'crum' ),
							),
							array(
								"type"        => "textfield",
								"heading"     => __( "Height", "crum" ),
								"param_name"  => "height",
								"group"       => $group,
								"description" => __( 'Don\'t enter "px", just the number e.g. "120"', 'crum' ),
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

	new Crum_QR_Code;
}
