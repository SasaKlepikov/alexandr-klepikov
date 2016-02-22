<?php
if ( ! class_exists( 'Crum_Slide_Parallax' ) ) {
	class Crum_Slide_Parallax {
		function __construct() {
			add_shortcode( 'slide_parallax', array( &$this, 'crum_slide_parallax_form' ) );
			add_action( 'admin_init', array( &$this, 'crum_slider_parallax_init' ) );
		}

		function crum_slide_parallax_form( $atts ) {

			$left_image = $right_image = '';
			extract(
				shortcode_atts(
					array(
						'left_image'  => '',
						'right_image' => ''
					), $atts
				)
			);

			$image_src   = wp_get_attachment_image_src( $left_image, 'full' );
			$left_image  = $image_src[0];
			$image_src   = wp_get_attachment_image_src( $right_image, 'full' );
			$right_image = $image_src[0];

			$output = '<div class="crum_slide_parallax">
		<div class="">
			<div class="image-left">
				<img src="' . $left_image . '" alt= "" />
			</div>
			<div class="image-right">
				<img src="' . $right_image . '" alt= "" />
			</div>
			<div class="handler" style="left: 50%;"><span class="pointer"></span></div>
		</div>
	</div>';

			return $output;
		}

		function crum_slider_parallax_init() {
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"        => __( "Slide Paralax", "crum" ),
						"base"        => "slide_parallax",
						"icon"        => "icon-wpb-sl-parallax",
						"category"    => __( 'Presentation', 'crum' ),
						"description" => __( '"Before" and "After" images difference', 'crum' ),
						"params"      => array(
							array(
								"type"        => "attach_image",
								"heading"     => __( "Image Left", "crum" ),
								"param_name"  => "left_image",
								"value"       => "",
								"description" => __( "Select image from media library.", "crum" )
							),
							array(
								"type"        => "attach_image",
								"heading"     => __( "Image Right", "crum" ),
								"param_name"  => "right_image",
								"value"       => "",
								"description" => __( "Select image from media library.", "crum" )
							),
						)
					)
				);
			}
		}
	}

	new Crum_Slide_Parallax;
}