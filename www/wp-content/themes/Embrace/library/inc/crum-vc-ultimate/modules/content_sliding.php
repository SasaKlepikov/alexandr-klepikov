<?php
if ( ! class_exists( 'Crum_Sliding_Content' ) ) {
	class Crum_Sliding_Content {
		function __construct() {
			add_action( 'admin_init', array( $this, 'crum_sliding_content_init' ) );
			add_shortcode( 'sliding_content', array( $this, 'crum_sliding_content_form' ) );
		}

		function crum_sliding_content_form( $atts, $content = null ) {

			$slides_to_show = $slides_to_scroll = $scroll_speed = $advanced_opts = $autoplay_speed = $module_animation = $output = '';

			extract(
				shortcode_atts(
					array(
						"slides_to_show"         => "1",
						"slides_to_scroll"             => "1",
						"scroll_speed"     => "400",
						"advanced_opts"     => "",
						"autoplay_speed"     => "3",
						"module_animation" => "",
					), $atts
				)
			);

			$infinite      = $autoplay = $dots = $arrows = 'false';
			$advanced_opts = explode( ",", $advanced_opts );

			if ( in_array( "infinite", $advanced_opts ) ) {
				$infinite = 'true';
			}
			if ( in_array( "autoplay", $advanced_opts ) ) {
				$autoplay = 'true';
			}
			if ( in_array( "dots", $advanced_opts ) ) {
				$dots = 'true';
			}
			if (in_array("arrows", $advanced_opts)){
				$arrows = 'true';
			}

			$slider_id = uniqid( 'cr_sldr_' );

			$animate = $animation_data = '';

			if ( ! ($module_animation == '')){
				$animate = ' cr-animate-gen';
				$animation_data = 'data-animate-type = "'.$module_animation.'" ';
			}

			preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches );

			$output .= '<div class="'.$animate.'" '.$animation_data.'>';

			$output .= '<div id="slider-'.$slider_id.'" class="sliding-content-slider cursor-move slider-loading">';
			$output .= '<div id="slides-'.$slider_id.'">';

			if(isset($matches[0]) && !($matches[0] == '') && (is_array($matches[0]))){
				foreach ($matches[0] as $single_shortcode){
					$output .= '<div class="sliding-content-item">';
					$output .= do_shortcode($single_shortcode);
					$output .= '</div>';
				}
			}

			$output .= '</div>';//slides
			$output .= '</div>';//sliding-content-slider
			$output .= '</div>';//row

			$output .= '';
			?>


			<script type="text/javascript">
				(function ($) {
					$(document).ready(function () {

						$('#<?php echo 'slides-'.$slider_id.''; ?>').slick({
							infinite      : <?php echo $infinite; ?>,
							slidesToShow  : <?php echo $slides_to_show; ?>,
							slidesToScroll: <?php echo $slides_to_scroll; ?>,
							arrows        : <?php echo $arrows;?>,
							dots          : <?php echo $dots; ?>,
							speed         : <?php echo $scroll_speed;?>,
							autoplay      : <?php echo $autoplay; ?>,
							autoplaySpeed : <?php echo $autoplay_speed.'000'; ?>,
                            onInit: function(){$('#<?php echo 'slider-'.$slider_id.''; ?>').removeClass('slider-loading')},
							responsive    : [
								{
									breakpoint: 600,
									settings  : {
                                        slidesToShow  : 2,
                                        slidesToScroll: 2
									}
								},
								{
									breakpoint: 480,
									settings  : {
										slidesToShow  : 1,
										slidesToScroll: 1,
										arrows        : false
									}
								}
							]
						});
					});
				})(jQuery);
			</script>

			<?php return $output;

		}

		function crum_sliding_content_init( $atts, $content = null ) {
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
						"name"                    => __( "Sliding content", "crum" ),
						"base"                    => "sliding_content",
						"as_parent"               =>
							array(
								'only' => 'vc_row, client, vc_column_text, vc_single_image, vc_text_separator, vc_cta_button2, vc_video, vc_pie, vc_button2, ult_countdown, icon_counter, crumina_gmap,
								heading, bsf-info-box, ultimate_info_table, just_icon, ultimate_pricing, pricing_table, qr_code, stat_counter, testimonial'
							),
						"show_settings_on_create" => true,
						"icon"                    => "sliding_content_icon",
						"category"                => __( 'Presentation', 'crum' ),
						"params"                  => array(
							array(
								"type"        => "number",
								"class"       => "",
								"heading"     => __( "Number of Slides to Show", "crum" ),
								"param_name"  => "slides_to_show",
								"value"       => "1",
								"min"         => 1,
								"max"         => 10,
								"suffix"      => "",
								"description" => __( "The number of slides to show on page", "crum" ),
								"group"       => "Carousel Settings",
							),
							array(
								"type"        => "number",
								"class"       => "",
								"heading"     => __( "Number of Slides to Scroll", "crum" ),
								"param_name"  => "slides_to_scroll",
								"value"       => "1",
								"min"         => 1,
								"max"         => 10,
								"suffix"      => "",
								"description" => __( "The number of slides to move on transition", "crum" ),
								"group"       => "Carousel Settings",
							),
                            array(
                                "type"        => "number",
                                "class"       => "",
                                "heading"     => __( "Slide Scrolling Speed", "crum" ),
                                "param_name"  => "scroll_speed",
                                "value"       => "400",
                                "min"         => 100,
                                "max"         => 10000,
                                "suffix"      => "ms",
                                "description" => __( "Slide transition duration", "crum" ),
                                "group"       => "Carousel Settings",
                            ),
                            array(
                                "type"        => "checkbox",
                                "class"       => "",
                                "heading"     => __( "Advanced settings", "crum" ),
                                "param_name"  => "advanced_opts",
                                "value"       => array(
                                    "Enable infinite scroll<br>" => "infinite",
                                    "Enable navigation dots<br>" => "dots",
                                    "Enable navigation arrows<br>" => "arrows",
                                    "Enable auto play"           => "autoplay",
                                ),
                                "description" => __( "", "crum" ),
                                "group"       => "Carousel Settings",
                            ),
                            array(
                                "type"        => "number",
                                "class"       => "",
                                "heading"     => __( "Autoplay Speed", "crum" ),
                                "param_name"  => "autoplay_speed",
                                "value"       => "3",
                                "min"         => 1,
                                "max"         => 10,
                                "suffix"      => "sec",
                                "description" => __( "The amount of time between each auto transition", "crum" ),
                                "group"       => "Carousel Settings",
                                "dependency"  => Array(
                                    "element" => "advanced_opts",
                                    "value"   => array( "autoplay" )
                                ),
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
						),
						"js_view"                 => 'VcColumnView'
					)
				);
			}
		}
	}
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Sliding_Content extends WPBakeryShortCodesContainer {
	}
}

if ( class_exists( 'Crum_Sliding_Content' ) ) {
	$Crum_Sliding_Content = new Crum_Sliding_Content();
}