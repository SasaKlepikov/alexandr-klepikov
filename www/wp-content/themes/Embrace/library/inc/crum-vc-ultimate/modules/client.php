<?php
if ( ! class_exists( 'Crum_Clients_Display' ) ) {
    class Crum_Clients_Display {
        function __construct() {
            add_shortcode( 'client', array( &$this, 'crum_client_display' ) );
            add_action( 'admin_init', array( &$this, 'crum_clients_display_init' ) );
        }

        function  crum_client_display( $atts, $content = null ) {

	        wp_enqueue_script('tooltipster',get_template_directory_uri() .'/library/inc/crum-vc-ultimate/assets/js/jquery.tooltipster.min.js',array('jquery'));
	        wp_enqueue_style('tooltipster_css');

            $image = $url = $alt = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = $tooltip_class = $tooltip_options = '';
            extract( shortcode_atts( array( "image" => "", "url" => '#', "alt" => "", 'el_class' => '', 'css' => '', ), $atts ) );
            $client_content = null;
            $image          = crum_int_image( $image, '500', '400', false );

            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row ' . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), 'clients', $atts );

            $style = WPBakeryShortCode_VC_Row::buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);

            if ($content) {
                $content = 'title="'.$content.'"';
                $tooltip_class = 'class="client-tooltip"';
                //$tooltip_options = 'data-tooltip data-options="disable_for_touch:true"';
            }

            ( ! empty( $alt ) ) ? $alt_tag = $alt : $alt_tag = 'client';
            if ( ! empty( $url ) && $url != 'none' && $url != '#' ) {
                $client_content = '
					<div class="partner-item  '.$css_class.'"'.$style.' ><a href="' . $url . '"  title="' . $alt_tag . '"><img '.$tooltip_class.'  src="' . $image . '" alt="' . $alt_tag . '" '.$tooltip_options.' '.$content.' ></a></div>';
            } else {
                $client_content = '<div class="partner-item '.$css_class.'"'.$style.'><img '.$tooltip_class.'  src="' . $image . '" alt="' . $alt_tag . '" '.$tooltip_options.' '.$content.' /></div>';
            }

	        if (isset($content) && !($content == '')){

		    $client_content .= '<script >';
			        $client_content .= 'jQuery(function () {
				        jQuery(\'.client-tooltip\').tooltipster({
				        contentAsHTML: true
				        });
			        })';

		    $client_content .= '</script>';

	        }

            return $client_content;
        }

        function crum_clients_display_init() {
            if ( function_exists( 'vc_map' ) ) {

             vc_map(
                array(
                    "name"                      => __( "Client", "crum" ),
                    "base"                      => "client",
                    "allowed_container_element" => 'vc_row',
                    "as_child"                  => array( 'only' => 'clients' ),
                    "content_element"           => true,
                    "params"                    => array(
                        array(
                            "type"        => "attach_image",
                            "heading"     => __( "Image", "crum" ),
                            "param_name"  => "image",
                            "value"       => "",
                            "description" => __( "Select image from media library.", "crum" )
                        ),
                        array(
                            "type"        => "textfield",
                            "heading"     => __( "URL", "crum" ),
                            "param_name"  => "url",
                            "description" => __( "Add an optional link to your client", "crum" )
                        ),
                        array(
                            "admin_label" => true,
                            "type"        => "textfield",
                            "heading"     => __( "Client Name", "crum" ),
                            "param_name"  => "name",
                            "description" => __( "Enter clients name to identify block in clients list", "crum" )
                        ),
                        array(
                            "type" => "textarea",
                            "class" => "",
                            "heading" => __("Description", "crum"),
                            "param_name" => "content",
                            "admin_label" => false,
                            "value" => "",
                            "description" => __("Provide some description.", "crum"),
                        ),
                        array(
                            'type' => 'css_editor',
                            'heading' => __( 'Css', 'js_composer' ),
                            'param_name' => 'css',
                            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
                            'group' => __( 'Design options', 'js_composer' )
                        )
                    ),
                )
            );

            }
        }
    }

	if ( class_exists('Crum_Clients_Display') ) {
		$Crum_Clients_Display = new Crum_Clients_Display;
	}

}