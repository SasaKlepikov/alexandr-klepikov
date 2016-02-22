<?php
if ( ! class_exists( 'Crum_Clients_Testimonials' ) ) {
	class Crum_Clients_Testimonials {

		function __construct() {
			add_action( 'admin_init', array( $this, 'crum_clients_testimonials_init' ) );
			add_shortcode( 'clients_testimonials', array( $this, 'clients_testimonials_form' ) );
			add_shortcode( 'clients_testimonials_item', array( $this, 'clients_testimonials_item_form' ) );
		}

		function clients_testimonials_form( $atts, $content = null ) {

			$clients_testimonials_style = '';

			extract(
				shortcode_atts(
					array(
						'clients_testimonials_style'    => '3',
					), $atts
				)
			);
			switch ( $clients_testimonials_style ) {
				case '2' :
					$column_class = 'two-cols';
					break;
				case '3' :
					$column_class = 'three-cols';
					break;
				case '4' :
					$column_class = 'four-cols';
					break;
				case '5' :
					$column_class = 'five-cols';
					break;
				case '6' :
					$column_class = 'six-cols';
					break;
			}
			$unique_id = '_'.uniqid();


			$output = '';
			$output .= '<div class="container">';
			$output .= '<div class="client-list '.$column_class.'">';

			$output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );

			$output .= '</div>';

			$output .= '<div>';


			$output .= '</div>';
			$output .= '</div>';


			return $output;
		}

		function clients_testimonials_item_form( $atts, $content = null ) {

			$clients_testimonials_item_logo = $clients_testimonials_item_photo = $clients_testimonials_item_name = $clients_testimonials_item_job = '';

			extract(
				shortcode_atts(
					array(
						'clients_testimonials_item_logo'    => '',
						'clients_testimonials_item_photo'    => '',
						'clients_testimonials_item_name'    => '',
						'clients_testimonials_item_job'    => '',
					), $atts
				)
			);

			$output = '';

			$output .= '<div>';
			$output .= '<span class="logo">';
			$output .= wp_get_attachment_image($clients_testimonials_item_logo, 'full');
			$output .= '</span>';
			$output .= '<blockquote>';
			$output .= '<p class="quote">';
			$output .= $content;
			$output .= '</p>';
			$output .= '<footer class="author">';
			$output .= '<p>';
			$output .= '<span class="img">';
			$output .= wp_get_attachment_image($clients_testimonials_item_photo);
			$output .= '</span>';
			$output .= '<h5>'.$clients_testimonials_item_name.'</h5>';
			$output .= '<span class="title">'.$clients_testimonials_item_job.'</span>';
			$output .= '</p>';
			$output .= '</footer>';
			$output .= '</blockquote>';
			$output .= '</div>';



			return $output;
		}

		function crum_clients_testimonials_init() {
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => __( "Clients+Testimonials", "crum" ),
						"base"                    => "clients_testimonials",
						"class"                   => "clients_testimonials_icon",
						"icon"                    => "vc_clients_testimonials_icon",
						"category"                => __( "Presentation", "crum" ),
						"as_parent"               => array( 'only' => 'clients_testimonials_item' ),
						"content_element"         => true,
						"show_settings_on_create" => false,
						"params"                  => array(
							array(
								"type"        => "dropdown",
								"class"       => "",
								"heading"     => __( 'Columns', 'crum' ),
								"param_name"  => "clients_testimonials_style",
								"value"       => array(
									"Two"   => "2",
									"Three" => "3",
									"Four"  => "4",
									"Five"  => "5",
									"Six"   => "6"
								),
								"description" => __( 'Please select how many columns you would like..', 'crum' )
							),
						),
						"js_view"                 => 'VcColumnView'
					)
				);
				vc_map(
					array(
						"name"            => __( "Clients+Testimonials item", "crum" ),
						"base"            => "clients_testimonials_item",
						"class"           => "",
						"icon"            => "",
						"category"        => __( "Presentation", "crum" ),
						"as_child"        => array( 'only' => 'clients_testimonials', ),
						"content_element" => true,
						"params"          => array(
							array(
								"type"        => "attach_image",
								"class"       => "",
								"heading"     => __( "Upload Image:", "crum" ),
								"param_name"  => "clients_testimonials_item_logo",
								"value"       => "115",
								"description" => __( "Upload partner's logo.", "crum" ),
							),
							array(
								"type"        => "attach_image",
								"class"       => "",
								"heading"     => __( "Upload Image:", "crum" ),
								"param_name"  => "clients_testimonials_item_photo",
								"value"       => "115",
								"description" => __( "Upload partner's photo.", "crum" ),
							),
							array(
								"type"        => "textfield",
								"class"       => "",
								"heading"     => __( "Partner's name:", "crum" ),
								"param_name"  => "clients_testimonials_item_name",
								"admin_label" => true,
								"value"       => "Partner's name",
							),
							array(
								"type"        => "textfield",
								"class"       => "",
								"heading"     => __( "Partner's job:", "crum" ),
								"param_name"  => "clients_testimonials_item_job",
								"admin_label" => true,
								"value"       => "Partner's job",
							),
							array(
								"type"        => "textarea",
								"class"       => "",
								"heading"     => __( "Testimonial", "crum" ),
								"param_name"  => "content",
								"admin_label" => true,
								"value"       => "Testimonial text",
								"description" => __( "Provide partner's testimonial.", "crum" ),
							),

						)
					)
				);
			}
		}

	}
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_clients_testimonials extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_clients_testimonials_item extends WPBakeryShortCode {
	}
}

if ( class_exists( 'Crum_Clients_Testimonials' ) ) {
	$Crum_Clients_Testimonials = new Crum_Clients_Testimonials();
}